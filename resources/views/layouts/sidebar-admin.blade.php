@php
    $links = [
        ['label' => 'Dashboard', 'route' => 'home'],
        ['label' => 'Data Customer', 'route' => 'customers.index'],
        ['label' => 'Harga Jasa', 'route' => 'service_prices.index'],
        ['label' => 'Pesanan', 'route' => 'orders.index'],
        ['label' => 'Pembayaran', 'route' => 'payments.index'],
    ];
@endphp

@foreach ($links as $link)
    <a href="{{ route($link['route']) }}" class="nav-link {{ request()->routeIs($link['route']) ? 'active' : '' }}">
        {{ $link['label'] }}
    </a>
@endforeach