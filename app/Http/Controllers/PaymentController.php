<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
    $search = $request->query('search');

    $payments = Payment::with(['order', 'user'])
        ->when($search, function ($query, $search) {
            $query->whereHas('user', fn ($q) => $q->where('name', 'like', "%{$search}%")->orWhere('email', 'like', "%{$search}%"));
        })
        ->latest()
        ->paginate(10)
        ->withQueryString();

    return view('payments.index', compact('payments', 'search'));
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

        return redirect()->route('payments.index')->with('success', 'Payment confirmed as received.');
    }

    public function show(Payment $payment): View
    {
        return view('payments.show', compact('payment'));
    }
}
