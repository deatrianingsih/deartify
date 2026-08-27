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
    public function index(): View
    {
        //Cuma admin yang buka halaman ini 
        $payments = Payment::with(['order', 'user'])->latest()->paginate(10);

        return view('payments.index', compact('payments'));
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
}
