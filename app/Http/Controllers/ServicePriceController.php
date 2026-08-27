<?php

namespace App\Http\Controllers;

use App\Models\ServicePrice;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ServicePriceController extends Controller
{
    public function index(): View
    {
        $servicePrices = ServicePrice::latest()->paginate(10);

        return view('admin.service_prices.index', compact('servicePrices'));
    }

    public function create(): View
    {
        return view('admin.service_prices.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:128'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
        ]);

        ServicePrice::create($validated);

        return redirect()->route('service_prices.index')->with('success', 'Service price created successfully.');
    }

    public function edit(ServicePrice $servicePrice): View
    {
        return view('admin.service_prices.edit', compact('servicePrice'));
    }

    public function update(Request $request, ServicePrice $servicePrice): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:128'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
        ]);

        $servicePrice->update($validated);

        return redirect()->route('service_prices.index')->with('success', 'Service price updated successfully.');
    }

    public function destroy(ServicePrice $servicePrice): RedirectResponse
    {
        $servicePrice->delete();

        return redirect()->route('service_prices.index')->with('success', 'Service price deleted successfully.');
    }
}