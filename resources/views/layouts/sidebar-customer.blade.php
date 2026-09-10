@php
    $links = [
        ['label' => 'Dashboard', 'route' => 'home', 'icon' => 'bi-house'],
        ['label' => 'Layanan & Harga', 'route' => 'service_prices.index', 'icon' => 'bi-palette'],
        ['label' => 'Pesanan Saya', 'route' => 'orders.index', 'icon' => 'bi-bag'],
        ['label' => 'Ulasan Saya', 'route' => 'reviews.index', 'icon' =>'bi-star'],
        ['label' => 'Profil', 'route' => 'profile.show', 'icon' => 'bi-person'],

    ];
@endphp

@foreach ($links as $link)
    <a href="{{ route($link['route']) }}" class="nav-link {{ request()->routeIs($link['route']) ? 'active' : '' }}">
        <i class="bi {{ $link['icon'] }} me-2"></i>{{ $link['label'] }}
    </a>
@endforeach