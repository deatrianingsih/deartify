<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\ServicePrice;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $user = auth()->user();

        $orders = $user->isAdmin() ? Order::with(['user', 'servicePrice'])->latest()->paginate(10) : Order::where(['user_id', $user->id])->with('servicePrice')->latest()->paginate(10);

        return view('orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $servicePrices = ServicePrice::all();

        return view('orders.create', compact('servicePrices'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'service_price_id' => ['required|exists:service_prices,id'],
            'description' => ['required', 'string'],
            'reference_image' => ['nullable', 'image', 'max:2048'],
            'recipient_name' => ['required', 'string', 'max:128'],
            'recipient_phone' => ['required', 'string', 'max:20'],
            'shipping_address' => ['required', 'string'],
        ]);

        $servicePrice = ServicePrice::findOrFail($validated['service_price_id']);

        if ($request->hasFile('reference_image')) {
            $validated['reference_image'] = $request->file('reference_image')->store('references', 'public');
        }

        Order::create([
            ...$validated,
            'user_id' => auth()->id(),
            'status' => 'pending',
            'total_price' => $servicePrice->price,
        ]);

        return redirect()->route('orders.index')->with('success', 'Order created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order): View
    {
        $this->authorizeAccess($order);

        return view('orders.show', compact('order'));
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
            'status' => ['required', 'in:pending,in_progress,shipped,completed'],
        ]);

        $order->update($validated);

        if ($validated['status'] === 'shipped') {
            $order->update(['shipped_at' => now()]);
        }

        return redirect()->route('orders.index')->with('success', 'Order updated successfully.');
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
        if (!auth()->user()->isAdmin() && $order->user_id !== auth()->id()) {
            abort(403);
        }
    }
}