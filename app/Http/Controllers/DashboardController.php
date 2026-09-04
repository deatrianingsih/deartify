<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->isAdmin()) {

        $revenuePerDay = collect(range(6, 0))->map(function ($daysAgo) {
            $date = now()->subDays($daysAgo);
            return [
                'label' => $date->format('d M'),
                'total' => Order::where('status', 'completed')
                    ->whereDate('updated_at', $date)
                    ->sum('total_price'),
            ];
        });
            return view('dashboard.admin', [
                'totalCustomers' => User::where('role', 'customer')->count(),
                'totalOrders' => Order::count(),
                'inProgressOrders' => Order::where('status', 'in_progress')->count(),
                'completedOrders' => Order::where('status', 'completed')->count(),
                'totalRevenue' => Order::where('status', 'completed')->sum('total_price'),
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
            'myOrders' => Order::where('user_id', $user->id)->with('servicePrice')->latest()->take(5)->get(),
            'totalMyOrders' => Order::where('user_id', $user->id)->count(),
        ]);
    }
}