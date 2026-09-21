<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CustomerController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->query('search');

        $customers = User::where('role', 'customer')
        ->when($search, function ($query, $search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        })->latest()->paginate(10)->withQueryString();

        $totalCustomers = User::where('role', 'customer')->count();

        return view('admin.customers.index', compact('customers', 'search', 'totalCustomers'));
    }

    public function show(User $customer): View
    {
        $customer->load(['orders.servicePrice']);

        return view('admin.customers.show', compact('customer'));
    }
}