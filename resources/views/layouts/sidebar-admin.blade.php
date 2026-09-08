@php
    $links = [
        ['label' => 'Dashboard', 'route' => 'home', 'icon' => 'bi-house'],
        ['label' => 'Data Customer', 'route' => 'customers.index', 'icon' => 'bi-people'],
        ['label' => 'Harga Jasa', 'route' => 'service_prices.index', 'icon' => 'bi-palette'],
        ['label' => 'Pesanan', 'route' => 'orders.index', 'icon' => 'bi-bag'],
        ['label' => 'Pembayaran', 'route' => 'payments.index', 'icon' => 'bi-cash-coin'],
        ['label' => 'Profil', 'route' => 'profile.edit', 'icon' => 'bi-person'],
    ];
@endphp

@foreach ($links as $link)
    <a href="{{ route($link['route']) }}" class="nav-link {{ request()->routeIs($link['route']) ? 'active' : '' }}">
        <i class="bi {{ $link['icon'] }} me-2"></i>{{ $link['label'] }}
    </a>
@endforeach