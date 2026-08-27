<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;


class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        // Semua orang (customer & admin) boleh lihat daftar review
        $reviews =Review::with(['user', 'order.servicePrice'])->latest()->paginate(10);

        return view('reviews.index', compact('reviews'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Order $order): View
    {
        $this->authorizeOwner($order);

        return view('reviews.create', compact('order'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Order $order): RedirectResponse
    {
        $this->authorizeOwner($order);

        $validated = $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['nullable', 'string'],
        ]);

        Review::create([
            ...$validated,
            'order_id' => $order->id,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('orders.index')->with('success', 'Thank you for your review!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Review $review): RedirectResponse
    {
        if (!auth()->user()->isAdmin() && $review->user_id !== auth()->id()){
            abort(403);
        }

        $review->delete();

        return redirect()->route(reviews.index)->with('succes', 'Review deleted successfully.');
    }

    private function authorizeOwner (Order $order): void
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        if ($order->status !== 'completed') {
            abort(403, 'You can only review a completed order.');
        }
    }
}
