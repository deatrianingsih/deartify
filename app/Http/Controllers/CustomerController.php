<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\View\View;

class CustomerController extends Controller
{
    public function index(): View
    {
        $customers = User::where('role', 'customer')->latest()->paginate(10);

        return view('admin.customers.index', compact('customers'));
    }

    public function show(User $customer): View
    {
        $customer->load(['orders.servicePrice']);

        return view('admin.customers.show', compact('customer'));
    }
}