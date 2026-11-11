<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Product;
use App\Models\ServicePrice;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class CartController extends Controller
{
    private const MAX_QTY = 99;

    private function raw(): array
    {
        return session('cart', []);
    }
    private function lines(): array
    {
        $raw = $this->raw();
        $lines = [];

        foreach ($raw as $key => $row) {
            $model = $row['type'] === 'product'
                ? Product::find($row['id'])
                : ServicePrice::find($row['id']);

            if (! $model) {
                unset($raw[$key]);

                continue;
            }

            $isProduct = $row['type'] === 'product';
            $stock = $isProduct ? (int) $model->stock : null;
            $qty = max(1, (int) $row['qty']);
            if ($isProduct) {
                $qty = min($qty, max(1, $stock));
            }

            $lines[$key] = [
                'key' => $key,
                'type' => $row['type'],
                'id' => $model->id,
                'name' => $model->name,
                'image' => $model->image,
                'price' => (float) $model->price,
                'qty' => $qty,
                'stock' => $stock,
                'badge' => $isProduct ? $model->category_label : $model->badge,
                'subtotal' => (float) $model->price * $qty,
            ];
        }

        if (count($raw) !== count($this->raw())) {
            session(['cart' => $raw]);
        }

        return $lines;
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


    public function index(): View
    {
        $lines = $this->lines();
        $subtotal = collect($lines)->sum('subtotal');

        return view('cart.index', compact('lines', 'subtotal'));
    }

    public function add(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'type' => ['required', 'in:service,product'],
            'id' => ['required', 'integer'],
            'qty' => ['nullable', 'integer', 'min:1', 'max:'.self::MAX_QTY],
            'buy' => ['nullable', 'boolean'],
        ]);

        $qty = (int) ($data['qty'] ?? 1);
        $cart = $this->raw();
        $key = ($data['type'] === 'product' ? 'p-' : 's-').$data['id'];

        if ($data['type'] === 'product') {
            $product = Product::findOrFail($data['id']);
            $have = (int) ($cart[$key]['qty'] ?? 0);

            if ($product->stock < 1) {
                return back()->with('error', 'Maaf, stok '.$product->name.' sedang habis.');
            }
            if ($have + $qty > $product->stock) {
                $qty = max(1, $product->stock - $have);
                if ($have >= $product->stock) {
                    return back()->with('error', 'Jumlah '.$product->name.' di keranjang sudah mencapai stok ('.$product->stock.').');
                }
            }
            $name = $product->name;
        } else {
            $name = ServicePrice::findOrFail($data['id'])->name;
        }

        $cart[$key] = [
            'type' => $data['type'],
            'id' => (int) $data['id'],
            'qty' => min(self::MAX_QTY, (int) ($cart[$key]['qty'] ?? 0) + $qty),
        ];
        session(['cart' => $cart]);

        if ($request->boolean('buy')) {
            return redirect()->route('cart.checkout');
        }

        return back()->with('success', $name.' ditambahkan ke keranjang.');
    }

    public function update(Request $request, string $key): RedirectResponse
    {
        $cart = $this->raw();

        if (! isset($cart[$key])) {
            return back();
        }

        $qty = (int) $request->validate(['qty' => ['required', 'integer', 'min:1', 'max:'.self::MAX_QTY]])['qty'];

        if ($cart[$key]['type'] === 'product') {
            $product = Product::find($cart[$key]['id']);
            if ($product) {
                $qty = min($qty, max(1, (int) $product->stock));
            }
        }

        $cart[$key]['qty'] = $qty;
        session(['cart' => $cart]);

        return back();
    }

    public function remove(string $key): RedirectResponse
    {
        $cart = $this->raw();
        unset($cart[$key]);
        session(['cart' => $cart]);

        return back()->with('success', 'Item dihapus dari keranjang.');
    }

    public function checkout(): View|RedirectResponse
    {
        $lines = $this->lines();

        if (! $lines) {
            return redirect()->route('cart.index')->with('error', 'Keranjang masih kosong.');
        }

        $subtotal = collect($lines)->sum('subtotal');
        $hasService = collect($lines)->contains('type', 'service');
        $wallets = $this->wallets();

        return view('cart.checkout', compact('lines', 'subtotal', 'hasService', 'wallets'));
    }

    public function store(Request $request): RedirectResponse
    {
        $lines = $this->lines();

        if (! $lines) {
            return redirect()->route('cart.index')->with('error', 'Keranjang masih kosong.');
        }

        $hasService = collect($lines)->contains('type', 'service');

        $validated = $request->validate([
            'description' => [Rule::requiredIf($hasService), 'nullable', 'string'],
            'reference_image' => ['nullable', 'image', 'max:2048'],
            'recipient_name' => ['required', 'string', 'max:128'],
            'recipient_phone' => ['required', 'string', 'max:20'],
            'shipping_address' => ['required', 'string'],
            'shipping_lat' => ['nullable', 'numeric', 'between:-90,90'],
            'shipping_lng' => ['nullable', 'numeric', 'between:-180,180'],
            'delivery_area' => ['required', 'in:'.implode(',', array_keys(config('shipping.areas', ['local' => 1])))],
            'payment_method' => ['required', 'in:cod,'.implode(',', array_keys(config('payment.wallets', [])))],
        ]);

        $area = config('shipping.areas.'.$validated['delivery_area'], ['fee' => 0, 'cod' => true, 'label' => 'Dalam Kota']);
        $shippingFee = (float) $area['fee'];
        $paymentMethod = $validated['payment_method'];

        if ($paymentMethod === 'cod' && ! ($area['cod'] ?? true)) {
            return back()->withInput()->withErrors(['payment_method' => 'Pengiriman '.$area['label'].' wajib bayar lewat QR, COD tidak tersedia.']);
        }

        if ($paymentMethod !== 'cod' && ! ($this->wallets()[$paymentMethod]['ready'] ?? false)) {
            return back()->withInput()->withErrors(['payment_method' => 'Metode pembayaran ini belum tersedia. Silakan pilih yang lain.']);
        }

        $referencePath = $request->hasFile('reference_image')
            ? $request->file('reference_image')->store('references', 'public')
            : null;

        try {
            $order = DB::transaction(function () use ($lines, $validated, $shippingFee, $paymentMethod, $referencePath) {
                // Kunci baris produk supaya stok tidak bisa dibeli bersamaan
                foreach ($lines as $line) {
                    if ($line['type'] === 'product') {
                        $product = Product::lockForUpdate()->find($line['id']);
                        if (! $product || $product->stock < $line['qty']) {
                            throw new \RuntimeException('Stok '.($product->name ?? 'produk').' tidak cukup (tersisa '.($product->stock ?? 0).').');
                        }
                    }
                }

                $itemsTotal = collect($lines)->sum('subtotal');
                $firstService = collect($lines)->firstWhere('type', 'service');

                $note = filled($validated['description'] ?? null)
                    ? $validated['description']
                    : 'Pesanan produk: '.collect($lines)->map(fn ($l) => $l['name'].' x'.$l['qty'])->implode(', ');

                $order = Order::create([
                    'user_id' => auth()->id(),
                    'service_price_id' => $firstService['id'] ?? null,
                    'description' => $note,
                    'reference_image' => $referencePath,
                    'recipient_name' => $validated['recipient_name'],
                    'recipient_phone' => $validated['recipient_phone'],
                    'shipping_address' => $validated['shipping_address'],
                    'status' => 'pending',
                    'total_price' => $itemsTotal + $shippingFee,
                ]);

                $order->forceFill([
                    'delivery_area' => $validated['delivery_area'],
                    'shipping_fee' => $shippingFee,
                    'shipping_lat' => $validated['shipping_lat'] ?? null,
                    'shipping_lng' => $validated['shipping_lng'] ?? null,
                ])->save();

                foreach ($lines as $line) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'item_type' => $line['type'],
                        'service_price_id' => $line['type'] === 'service' ? $line['id'] : null,
                        'product_id' => $line['type'] === 'product' ? $line['id'] : null,
                        'name' => $line['name'],
                        'image' => $line['image'],
                        'price' => $line['price'],
                        'quantity' => $line['qty'],
                    ]);

                    if ($line['type'] === 'product') {
                        Product::where('id', $line['id'])->decrement('stock', $line['qty']);
                    }
                }

                Payment::create([
                    'order_id' => $order->id,
                    'user_id' => auth()->id(),
                    'amount' => $order->total_price,
                    'method' => $paymentMethod,
                    'status' => 'pending',
                ]);

                return $order;
            });
        } catch (\RuntimeException $e) {
            return redirect()->route('cart.index')->with('error', $e->getMessage());
        }

        session()->forget('cart');

        if ($paymentMethod !== 'cod') {
            return redirect()->route('orders.show', $order)
                ->with('success', 'Pesanan dibuat! Silakan transfer sesuai nomor di bawah lalu unggah bukti pembayaran.');
        }

        return redirect()->route('orders.index')->with('success', 'Pesanan berhasil dibuat.');
    }
}
