<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PaymentController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->query('search');
        $method = $request->query('method');

        $payments = Payment::with(['order', 'user'])
            ->when($method, fn ($query, $method) => $query->where('method', $method))
            ->when($search, function ($query, $search) {
                $query->whereHas('user', fn ($q) => $q->where('name', 'like', "%{$search}%")->orWhere('email', 'like', "%{$search}%"));
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('payments.index', compact('payments', 'search', 'method'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Order $order): RedirectResponse
    {
        Payment::create([
            'order_id' => $order->id,
            'user_id' => $order->user_id,
            'amount' => $order->total_price,
            'method' => 'cod',
            'status' => 'pending',
        ]);

        return redirect()->route('payments.index')->with('success', 'COD payment invoice created successfully');
    }

    public function confirmReceived(Payment $payment): RedirectResponse
    {
        $payment->update([
            'status' => 'received',
            'received_at' => now(),
        ]);

        return redirect()->route('payments.index')->with('success', 'Pembayaran berhasil dikonfirmasi.');
    }

    public function show(Payment $payment): View
    {
        return view('payments.show', compact('payment'));
    }

    public function uploadProof(Request $request, Payment $payment): RedirectResponse
    {
        abort_unless($payment->user_id === auth()->id(), 403);

        if (! $payment->isEwallet() || $payment->status !== 'pending') {
            return back()->with('error', 'Bukti pembayaran tidak bisa diunggah untuk pesanan ini.');
        }

        $request->validate([
            'proof' => ['required', 'image', 'max:4096'],
        ], [
            'proof.required' => 'Pilih foto bukti pembayaran dulu.',
            'proof.image' => 'Bukti pembayaran harus berupa gambar.',
            'proof.max' => 'Ukuran gambar maksimal 4 MB.',
        ]);

        if ($payment->proof_path) {
            Storage::disk('public')->delete($payment->proof_path);
        }

        $payment->update([
            'proof_path' => $request->file('proof')->store('payment-proofs', 'public'),
            'proof_uploaded_at' => now(),
        ]);

        return redirect()->route('orders.show', $payment->order_id)
            ->with('success', 'Bukti pembayaran terkirim. Kami akan segera mengeceknya.');
    }
}
