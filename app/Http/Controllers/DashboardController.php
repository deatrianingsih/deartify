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
    $prevMonthDate = $monthDate->copy()->subMonth();

    $totalRevenue = Order::where('status', 'completed')
        ->whereYear('updated_at', $monthDate->year)->whereMonth('updated_at', $monthDate->month)
        ->sum('total_price');
    $prevRevenue = Order::where('status', 'completed')
        ->whereYear('updated_at', $prevMonthDate->year)->whereMonth('updated_at', $prevMonthDate->month)
        ->sum('total_price');

    $totalTransactions = Order::whereYear('created_at', $monthDate->year)->whereMonth('created_at', $monthDate->month)->count();
    $prevTransactions = Order::whereYear('created_at', $prevMonthDate->year)->whereMonth('created_at', $prevMonthDate->month)->count();

    $revenueChange = $prevRevenue > 0 ? round((($totalRevenue - $prevRevenue) / $prevRevenue) * 100) : ($totalRevenue > 0 ? 100 : 0);
    $transactionChange = $prevTransactions > 0 ? round((($totalTransactions - $prevTransactions) / $prevTransactions) * 100) : ($totalTransactions > 0 ? 100 : 0);

    $revenuePerDay = collect(range(1, $monthDate->daysInMonth))->map(function ($day) use ($monthDate) {
        return [
            'label' => $day,
            'total' => Order::where('status', 'completed')
                ->whereYear('updated_at', $monthDate->year)->whereMonth('updated_at', $monthDate->month)->whereDay('updated_at', $day)
                ->sum('total_price'),
        ];
    });

    $statusCounts = [
        'pending' => Order::where('status', 'pending')->count(),
        'in_progress' => Order::where('status', 'in_progress')->count(),
        'shipped' => Order::where('status', 'shipped')->count(),
        'completed' => Order::where('status', 'completed')->count(),
    ];
    $totalOrdersAll = array_sum($statusCounts);

    return view('dashboard.admin', [
        'month' => $month,
        'totalRevenue' => $totalRevenue,
        'totalTransactions' => $totalTransactions,
        'revenueChange' => $revenueChange,
        'transactionChange' => $transactionChange,
        'recentOrders' => Order::with(['user', 'servicePrice'])->latest()->take(5)->get(),
        'revenueLabels' => $revenuePerDay->pluck('label'),
        'revenueData' => $revenuePerDay->pluck('total'),
        'statusCounts' => $statusCounts,
        'totalOrdersAll' => $totalOrdersAll,
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