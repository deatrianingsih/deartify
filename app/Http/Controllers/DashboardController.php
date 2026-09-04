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
            return view('dashboard.admin', [
                'totalCustomers' => User::where('role', 'customer')->count(),
                'totalOrders' => Order::count(),
                'inProgressOrders' => Order::where('status', 'in_progress')->count(),
                'completedOrders' => Order::where('status', 'completed')->count(),
                'totalRevenue' => Order::where('status', 'completed')->sum('total_price'),
                'recentOrders' => Order::with(['user', 'servicePrice'])->latest()->take(5)->get(),
            ]);
        }

        return view('dashboard.customer', [
            'myOrders' => Order::where('user_id', $user->id)->with('servicePrice')->latest()->take(5)->get(),
            'totalMyOrders' => Order::where('user_id', $user->id)->count(),
        ]);
    }
}