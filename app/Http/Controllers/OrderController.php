<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use App\Models\ServicePrice;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class OrderController extends Controller
{
    public const CANCELLABLE = ['pending', 'in_progress'];

    public const CANCEL_REASONS = [
        'Ingin mengubah detail pesanan (deskripsi / referensi gambar)',
        'Salah memilih layanan',
        'Ingin mengubah alamat atau nomor penerima',
        'Menemukan layanan lain yang lebih sesuai',
        'Ingin mengubah metode pembayaran',
        'Berubah pikiran / tidak jadi memesan',
        'Alasan lainnya',
    ];

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $user = auth()->user();
        $status = $request->query('status');
        $search = $request->query('search');

        $query = $user->isAdmin()
            ? Order::with(['user', 'servicePrice'])
            : Order::where('user_id', $user->id)->with('servicePrice');

        $counts = ($user->isAdmin() ? Order::query() : Order::where('user_id', $user->id))
            ->selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        if ($status && $status !== 'all') {
            $query->where('status', $status);
        }

        if ($search) {
            $query->where(function ($w) use ($search) {
                $w->whereHas('servicePrice', fn ($q) => $q->where('name', 'like', "%{$search}%"))
                    ->orWhereHas('product', fn ($q) => $q->where('name', 'like', "%{$search}%"));
            });
        }

        $orders = $query->latest()->paginate(10)->withQueryString();

        return view('orders.index', compact('orders', 'status', 'search', 'counts'));
    }

    private function wallets(): array
    {
        $list = [];

        foreach (config('payment.wallets', []) as $key => $wallet) {
            $hasImage = filled($wallet['image'] ?? null) && file_exists(public_path($wallet['image']));
            $list[$key] = $wallet + ['ready' => $hasImage || filled($wallet['number'] ?? null)];
        }

        return $list;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $servicePrices = ServicePrice::all();
        $selectedServiceId = $request->query('service_price_id');

        $wallets = $this->wallets();
        $product = $request->filled('product_id') ? Product::find($request->query('product_id')) : null;

        return view('orders.create', compact('servicePrices', 'selectedServiceId', 'wallets', 'product'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'service_price_id' => ['required_without:product_id', 'nullable', 'exists:service_prices,id'],
            'product_id' => ['nullable', 'exists:products,id'],
            'quantity' => ['nullable', 'integer', 'min:1', 'max:99'],
            'description' => ['required_without:product_id', 'nullable', 'string'],
            'reference_image' => ['nullable', 'image', 'max:2048'],
            'recipient_name' => ['required', 'string', 'max:128'],
            'recipient_phone' => ['required', 'string', 'max:20'],
            'shipping_address' => ['required', 'string'],
            'shipping_lat' => ['nullable', 'numeric', 'between:-90,90'],
            'shipping_lng' => ['nullable', 'numeric', 'between:-180,180'],
            'delivery_area' => ['required', 'in:'.implode(',', array_keys(config('shipping.areas', ['local' => 1])))],
        ]);

        $area = config('shipping.areas.'.$validated['delivery_area'], ['fee' => 0, 'cod' => true, 'label' => 'Dalam Kota']);
        $shippingFee = (float) $area['fee'];
        unset($validated['delivery_area']);
        $lat = $validated['shipping_lat'] ?? null;
        $lng = $validated['shipping_lng'] ?? null;
        unset($validated['shipping_lat'], $validated['shipping_lng']);

        $paymentMethod = $request->validate([
            'payment_method' => ['required', 'in:cod,'.implode(',', array_keys(config('payment.wallets', [])))],
        ])['payment_method'];

        if ($paymentMethod === 'cod' && ! ($area['cod'] ?? true)) {
            return back()->withInput()->withErrors(['payment_method' => 'Pengiriman '.$area['label'].' wajib bayar lewat QR, COD tidak tersedia.']);
        }

        if ($paymentMethod !== 'cod' && ! ($this->wallets()[$paymentMethod]['ready'] ?? false)) {
            return back()->withInput()->withErrors(['payment_method' => 'Metode pembayaran ini belum tersedia. Silakan pilih yang lain.']);
        }

        $product = null;
        $qty = 1;
        if (! empty($validated['product_id'])) {
            $product = Product::findOrFail($validated['product_id']);
            $qty = (int) ($validated['quantity'] ?? 1);

            if ($product->stock < 1) {
                return back()->withInput()->withErrors(['quantity' => 'Maaf, stok produk ini sudah habis.']);
            }
            if ($qty > $product->stock) {
                return back()->withInput()->withErrors(['quantity' => 'Stok tersisa hanya '.$product->stock.'.']);
            }
            $itemPrice = (float) $product->price * $qty;
            $validated['service_price_id'] = null;
            $validated['description'] = filled($validated['description'] ?? null) ? $validated['description'] : 'Pesanan produk: '.$product->name.' x'.$qty;
        } else {
            $servicePrice = ServicePrice::findOrFail($validated['service_price_id']);
            $itemPrice = (float) $servicePrice->price;
        }
        unset($validated['product_id'], $validated['quantity']);

        if ($request->hasFile('reference_image')) {
            $validated['reference_image'] = $request->file('reference_image')->store('references', 'public');
        }

        $order = DB::transaction(function () use ($validated, $itemPrice, $shippingFee, $request, $lat, $lng, $product, $qty) {
            $order = Order::create([
                ...$validated,
                'user_id' => auth()->id(),
                'status' => 'pending',
                'total_price' => $itemPrice + $shippingFee,
            ]);

            $order->forceFill([
                'delivery_area' => $request->input('delivery_area'),
                'shipping_fee' => $shippingFee,
                'shipping_lat' => $lat,
                'shipping_lng' => $lng,
                'product_id' => $product?->id,
                'quantity' => $product ? $qty : 1,
            ])->save();

            if ($product) {
                $product->decrement('stock', $qty);
            }

            return $order;
        });

        Payment::create([
            'order_id' => $order->id,
            'user_id' => auth()->id(),
            'amount' => $order->total_price,
            'method' => $paymentMethod,
            'status' => 'pending',
        ]);

        if ($paymentMethod !== 'cod') {
            return redirect()->route('orders.show', $order)
                ->with('success', 'Pesanan dibuat! Silakan transfer sesuai nomor di bawah lalu unggah bukti pembayaran.');
        }

        return redirect()->route('orders.index')->with('success', 'Order created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order): View
    {
        $this->authorizeAccess($order);

        $payment = Payment::where('order_id', $order->id)->latest()->first();
        $wallets = $this->wallets();

        return view('orders.show', compact('order', 'payment', 'wallets'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order): View
    {
        $this->authorizeAccess($order);

        return view('orders.edit', compact('order'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:pending,in_progress,shipped,completed,cancelled'],
        ]);

        DB::transaction(function () use ($order, $validated) {
            $wasCancelled = $order->status === 'cancelled';
            $order->update($validated);

            if ($validated['status'] === 'shipped') {
                $order->update(['shipped_at' => now()]);
            }

            if ($validated['status'] === 'cancelled') {
                $this->removePendingPayment($order);

                if (! $wasCancelled) {
                    $order->restock();
                }
            }
        });

        return redirect()->route('orders.index')->with('success', 'Order updated successfully.');
    }
    public function cancelForm(Order $order): View|RedirectResponse
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        if (! in_array($order->status, self::CANCELLABLE, true)) {
            return redirect()->route('orders.show', $order)
                ->with('error', 'Pesanan yang sudah dikirim atau selesai tidak bisa dibatalkan.');
        }

        $order->load('servicePrice');
        $payment = Payment::where('order_id', $order->id)->latest()->first();
        $reasons = self::CANCEL_REASONS;

        return view('orders.cancel', compact('order', 'payment', 'reasons'));
    }

    public function cancel(Request $request, Order $order): RedirectResponse
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        if (! in_array($order->status, self::CANCELLABLE, true)) {
            return redirect()->route('orders.show', $order)
                ->with('error', 'Pesanan yang sudah dikirim atau selesai tidak bisa dibatalkan.');
        }

        $data = $request->validate([
            'cancel_reason' => ['required', Rule::in(self::CANCEL_REASONS)],
        ], [
            'cancel_reason.required' => 'Pilih alasan pembatalan dulu.',
            'cancel_reason.in' => 'Alasan pembatalan tidak valid.',
        ]);

        DB::transaction(function () use ($order, $data) {
            $order->forceFill([
                'status' => 'cancelled',
                'cancel_reason' => $data['cancel_reason'],
                'cancelled_at' => now(),
            ])->save();

            $this->removePendingPayment($order);

            $order->restock();
        });

        return redirect()->route('orders.show', $order)->with('success', 'Pesanan berhasil dibatalkan.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order): RedirectResponse
    {
        $this->authorizeAccess($order);

        $order->delete();

        return redirect()->route('orders.index')->with('success', 'Order deleted successfully.');

    }

    private function authorizeAccess(Order $order): void
    {
        if (! auth()->user()->isAdmin() && $order->user_id !== auth()->id()) {
            abort(403);
        }
    }
    private function removePendingPayment(Order $order): void
    {
        Payment::where('order_id', $order->id)
            ->where('status', 'pending')
            ->whereNull('proof_path')
            ->delete();
    }
}
