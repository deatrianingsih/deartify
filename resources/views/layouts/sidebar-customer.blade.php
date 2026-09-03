@php
    $links = [
        ['label' => 'Dashboard', 'route' => 'home'],
        ['label' => 'Layanan & Harga', 'route' => 'service_prices.index'],
        ['label' => 'Pesanan Saya', 'route' => 'orders.index'],
        ['label' => 'Ulasan Saya', 'route' => 'reviews.index'],
        ['label' => 'Profil', 'route' => 'profile.edit'],

    ];
@endphp

@foreach ($links as $link)
    <a href="{{ route($link['route']) }}" class="nav-link {{ request()->routeIs($link['route']) ? 'active' : '' }}">
        {{ $link['label'] }}
    </a>
@endforeach