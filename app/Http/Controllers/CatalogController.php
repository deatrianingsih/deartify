<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ServicePrice;
use Illuminate\View\View;

class CatalogController extends Controller
{
    /**
     * Halaman Layanan & Harga untuk tamu (jasa gambar + produk).
     */
    public function index(): View
    {
        return view('public.layanan', [
            'services' => ServicePrice::latest()->get(),
            'products' => Product::latest()->get(),
        ]);
    }
}
