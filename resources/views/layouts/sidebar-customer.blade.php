@php
    $links = [
        ['label' => 'Dashboard', 'route' => 'home'],
        ['label' => 'Layanan & Harga', 'route' => 'service_prices.index'],
        ['label' => 'Pesanan Saya', 'route' => 'orders.index'],
        ['label' => 'Ulasan Saya', 'route' => 'reviews.index'],

    ];
@endphp

@foreach ($links as $link)
<a href="{{ route($link['route']) }}" class="blocl px-4 py-2 rounded-lg text-sm font-medium {{ request()->routeIs($link['route']) ? 'bg-peach text-white' : 'hover:bg-cream text-brown'  }}">
    {{ $link['label'] }}
</a>
@endforeach