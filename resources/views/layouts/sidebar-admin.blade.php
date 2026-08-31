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
    <a href="{{ route($link['route']) }}"
       class="block px-4 py-2 rounded-lg text-sm font-medium {{ request()->routeIs($link['route']) ? 'bg-peach text-white' : 'hover:bg-cream text-brown' }}">
        {{ $link['label'] }}
    </a>
@endforeach