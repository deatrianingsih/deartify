<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ServicePrice;
use Illuminate\View\View;

class CatalogController extends Controller
{
    public function index(): View
    {
        return view('public.layanan', [
            'services' => ServicePrice::latest()->get(),
            'products' => Product::latest()->get(),
        ]);
    }
}
