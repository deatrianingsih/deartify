<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        if ($user->isAdmin()) {
        $month = $request->query('month', now()->format('Y-m'));
        $monthDate = \Carbon\Carbon::parse($month . '-01');

        $totalRevenue = Order::where('status', 'completed')
        ->whereYear('updated_at', $monthDate->year)
        ->whereMonth('updated_at', $monthDate->month)
        ->sum('total_price');

        $totalTransactions = Order::whereYear('created_at', $monthDate->year)
        ->whereMonth('created_at', $monthDate->month)->count();

        $revenuePerDay = collect(range(1, $monthDate->daysInMonth))->map(function ($day) use ($monthDate) {
            return [
                'label' => $day,
                'total' => Order::where('status', 'completed')
                    ->whereYear('updated_at', $monthDate->year)
                    ->whereMonth('updated_at', $monthDate->month)
                    ->whereDay('updated_at', $day)
                    ->sum('total_price'),
            ];
        });
            return view('dashboard.admin', [
                'month' => $month,
            'totalRevenue' => $totalRevenue,
            'totalTransactions' => $totalTransactions,
            'recentOrders' => Order::with(['user', 'servicePrice'])->latest()->take(5)->get(),
            'revenueLabels' => $revenuePerDay->pluck('label'),
            'revenueData' => $revenuePerDay->pluck('total'),
            'statusCounts' => [
                'pending' => Order::where('status', 'pending')->count(),
                'in_progress' => Order::where('status', 'in_progress')->count(),
                'shipped' => Order::where('status', 'shipped')->count(),
                'completed' => Order::where('status', 'completed')->count(),
                ],
            ]);
        }

        return view('dashboard.customer', [
            'totalMyOrders' => Order::where('user_id', $user->id)->count(),
            'inProgressOrders' => Order::where('user_id', $user->id)->where('status', 'in_progress')->count(),
            'completedOrders' => Order::where('user_id', $user->id)->where('status', 'completed')->count(),
            'avgRating' => \App\Models\Review::whereHas('order', fn ($q) => $q->where('user_id', $user->id))->avg('rating'),
            'myOrders' => Order::where('user_id', $user->id)->with('servicePrice')->latest()->take(5)->get(),
        ]);
    }
}