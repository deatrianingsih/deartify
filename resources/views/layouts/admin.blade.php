<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'DeArtify Admin')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link href="https://fonts.bunny.net/css?family=caveat:500,700|nunito:400,600,700,800" rel="stylesheet">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @include('layouts.brand')
    <style>
       :root {
    --sb-w: 264px;
    --top-h: 68px;
}

body {
    font-family: 'Nunito', sans-serif;
    background: #FBF3E8;
    margin: 0;
    color: var(--c-text, #4A3B32);
}

/* Sidebar */
.ad-sb {
    position: fixed;
    top: 0;
    left: 0;
    bottom: 0;
    width: var(--sb-w);
    background: linear-gradient(180deg, #F3E4CE 0%, #EBD6BB 100%);
    border-right: 1px solid #E5D2B8;
    display: flex;
    flex-direction: column;
    z-index: 1040;
    transition: transform .25s;
}

.ad-brand {
    display: flex;
    align-items: center;
    gap: .55rem;
    padding: 0 1.4rem;
    height: var(--top-h);
    text-decoration: none;
    color: #5E4334;
    font-family: 'Caveat', cursive;
    font-size: 2.1rem;
    font-weight: 700;
    line-height: 1;
}

.ad-brand i {
    font-size: 1.6rem;
    color: #8B6F5B;
}

.ad-nav {
    padding: .4rem .9rem 1rem;
    display: flex;
    flex-direction: column;
    gap: .2rem;
    overflow-y: auto;
    flex: 1;
}

.ad-cap {
    font-size: .7rem;
    font-weight: 800;
    letter-spacing: .12em;
    text-transform: uppercase;
    color: #A68B73;
    padding: .9rem .8rem .3rem;
}

.ad-nav a {
    display: flex;
    align-items: center;
    gap: .8rem;
    padding: 0 .95rem;
    height: 46px;
    margin: 0;
    line-height: 1;
    border-radius: 13px;
    color: #5E4334;
    font-weight: 700;
    font-size: .95rem;
    text-decoration: none;
    transition: *background* .2s, transform .2s;
}

.ad-nav a i {
    font-size: 1.15rem;
    width: 22px;
    text-align: center;
    color: #8B6F5B;
}

.ad-nav a:hover {
    background: rgba(139, 111, 91, .14);
    transform: translateX(3px);
}

.ad-nav a.active {
    background: linear-gradient(135deg, #8B6F5B, #5E4334);
    color: #fff;
    box-shadow: 0 8px 18px rgba(94, 67, 52, .3);
}

.ad-nav a.active i {
    color: #fff;
}

.ad-sb-foot {
    padding: 1rem 1.3rem;
    font-size: .78rem;
    color: #A68B73;
}

/* Topbar */
.ad-wrap {
    margin-left: var(--sb-w);
    min-height: 100vh;
}

.ad-top {
    position: sticky;
    top: 0;
    z-index: 1030;
    height: var(--top-h);
    background: linear-gradient(120deg, #5E4334, #8B6F5B);
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 2rem;
    box-shadow: 0 6px 18px rgba(74, 59, 50, .22);
}

.ad-burger {
    display: none;
    border: 0;
    background: rgba(255, 243, 224, .16);
    color: #FFF3E0;
    width: 42px;
    height: 42px;
    border-radius: 12px;
    font-size: 1.5rem;
    align-items: center;
    justify-content: center;
}

.ad-title {
    color: #F6E8D5;
    font-weight: 700;
    display: flex;
    align-items: center;
    gap: .5rem;
}

.ad-acc {
    position: relative;
    margin-left: auto;
}

.ad-acc-btn {
    display: flex;
    align-items: center;
    gap: .65rem;
    background: #FFF3E0;
    color: #5E4334;
    border: 2px solid #FFF3E0;
    border-radius: 999px;
    padding: .28rem .95rem .28rem .28rem;
    font-weight: 800;
    font-size: .93rem;
    line-height: 1;
    cursor: pointer;
    box-shadow: 0 4px 12px rgba(0, 0, 0, .2);
    transition: transform .2s, *background* .2s;
}

.ad-acc-btn:hover {
    background: #fff;
    transform: translateY(-1px);
}

.ad-acc.open .ad-acc-btn {
    border-color: #E0A21B;
}

.ad-ava {
    width: 38px;
    height: 38px;
    border-radius: 50%;
    background: linear-gradient(135deg, #A78468, #5E4334);
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 800;
    flex-shrink: 0;
}

.ad-acc-text {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    line-height: 1.15;
}

.ad-acc-text small {
    font-size: .66rem;
    font-weight: 800;
    color: #9A7B66;
    letter-spacing: .06em;
    text-transform: uppercase;
}

.ad-acc-arrow {
    font-size: .8rem;
    transition: transform .2s;
}

.ad-acc.open .ad-acc-arrow {
    transform: rotate(180deg);
}

.ad-menu {
    display: none;
    position: absolute;
    right: 0;
    top: calc(100% + 12px);
    min-width: 220px;
    background: #fff;
    border: 1px solid #EFE3D3;
    border-radius: 16px;
    box-shadow: 0 16px 36px rgba(74, 59, 50, .22);
    padding: .45rem;
    z-index: 1050;
}

.ad-acc.open .ad-menu {
    display: block;
}

.ad-menu-head {
    padding: .6rem .8rem .7rem;
    border-bottom: 1px solid #F1E6D6;
    margin-bottom: .35rem;
}

.ad-menu-head b {
    display: block;
    color: #4A3B32;
}

.ad-menu-head span {
    font-size: .8rem;
    color: #9A8B80;
    word-break: break-all;
}

.ad-menu form {
    margin: 0;
}

.ad-menu a,
.ad-menu button {
    display: flex;
    align-items: center;
    gap: .65rem;
    width: 100%;
    padding: .62rem .8rem;
    border: 0;
    background: transparent;
    border-radius: 10px;
    color: #4A3B32;
    font-weight: 700;
    font-size: .92rem;
    text-align: left;
    text-decoration: none;
    cursor: pointer;
}

.ad-menu a:hover,
.ad-menu button:hover {
    background: #F5EAD8;
}

.ad-menu .danger {
    color: #B3402F;
}

.ad-main {
    padding: 1.75rem 2rem 3rem;
}

.ad-ov {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(40, 25, 15, .5);
    z-index: 1035;
}

@media (max-width: 991.98px) {
    .ad-sb {
        transform: translateX(-100%);
    }

    .ad-sb.open {
        transform: none;
    }

    .ad-ov.open {
        display: block;
    }

    .ad-wrap {
        margin-left: 0;
    }

    .ad-burger {
        display: inline-flex;
    }

    .ad-top {
        padding: 0 1rem;
        gap: .8rem;
    }

    .ad-main {
        padding: 1.25rem 1rem 2.5rem;
    }

    .ad-title {
        display: none;
    }
}
    </style>
    {{-- Chart.js harus dimuat di head: script grafik di halaman berjalan saat konten dirender --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    @stack('styles')
    @yield('styles')
</head>
<body>
@php
    $user = auth()->user();
    $links = [
        ['label' => 'Dashboard',     'href' => route('home'),                 'icon' => 'bi-house',          'on' => request()->routeIs('home')],
        ['label' => 'Pesanan',       'href' => route('orders.index'),         'icon' => 'bi-bag',            'on' => request()->routeIs('orders.*')],
        ['label' => 'Pembayaran',    'href' => route('payments.index'),       'icon' => 'bi-credit-card-2-front', 'on' => request()->routeIs('payments.*')],
        ['label' => 'Laporan',       'href' => route('admin.reports.index'),  'icon' => 'bi-bar-chart-line', 'on' => request()->routeIs('admin.reports.*')],
    ];
    $master = [
        ['label' => 'Harga Jasa',    'href' => route('service_prices.index'), 'icon' => 'bi-palette',        'on' => request()->routeIs('service_prices.*')],
        ['label' => 'Produk',        'href' => route('admin.products.index'), 'icon' => 'bi-pencil',         'on' => request()->routeIs('admin.products.*')],
        ['label' => 'Data Customer', 'href' => route('customers.index'),      'icon' => 'bi-people',         'on' => request()->routeIs('customers.*')],
    ];
@endphp

<aside class="ad-sb" id="adSb">
    <a href="{{ route('home') }}" class="ad-brand"><i class="bi bi-palette-fill"></i>DeArtify</a>
    <nav class="ad-nav">
        <div class="ad-cap">Menu Utama</div>
        @foreach ($links as $l)
            <a href="{{ $l['href'] }}" class="{{ $l['on'] ? 'active' : '' }}"><i class="bi {{ $l['icon'] }}"></i>{{ $l['label'] }}</a>
        @endforeach
        <div class="ad-cap">Data Master</div>
        @foreach ($master as $l)
            <a href="{{ $l['href'] }}" class="{{ $l['on'] ? 'active' : '' }}"><i class="bi {{ $l['icon'] }}"></i>{{ $l['label'] }}</a>
        @endforeach
    </nav>
    <div class="ad-sb-foot">© {{ date('Y') }} DeArtify</div>
</aside>
<div class="ad-ov" id="adOv"></div>

<div class="ad-wrap">
    <header class="ad-top">
        <button type="button" class="ad-burger" id="adBurger" aria-label="Menu"><i class="bi bi-list"></i></button>
        <div class="ad-title"><i class="bi bi-shield-check"></i>Panel Admin</div>

        <div class="ad-acc" id="adAcc">
            <button type="button" class="ad-acc-btn" id="adAccBtn" aria-haspopup="true" aria-expanded="false">
                <span class="ad-ava">{{ strtoupper(mb_substr($user->name, 0, 1)) }}</span>
                <span class="ad-acc-text">
                    <span>{{ Str::of($user->name)->trim()->before(' ') }}</span>
                    <small>Administrator</small>
                </span>
                <i class="bi bi-chevron-down ad-acc-arrow"></i>
            </button>
            <div class="ad-menu" role="menu">
                <div class="ad-menu-head"><b>{{ $user->name }}</b><span>{{ $user->email }}</span></div>
                <a href="{{ route('profile.show') }}" role="menuitem"><i class="bi bi-person-circle"></i>Profil Saya</a>
                <a href="{{ route('profile.edit') }}" role="menuitem"><i class="bi bi-pencil-square"></i>Edit Profil</a>
                <a href="{{ route('profile.password.edit') }}" role="menuitem"><i class="bi bi-key"></i>Ubah Password</a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="danger" role="menuitem"><i class="bi bi-box-arrow-right"></i>Logout</button>
                </form>
            </div>
        </div>
    </header>

    <main class="ad-main">
        @yield('content')
    </main>
</div>

@include('layouts.toast')


<script>
    (function () {
        var sb = document.getElementById('adSb'), ov = document.getElementById('adOv');
        function side(open) { sb.classList.toggle('open', open); ov.classList.toggle('open', open); }
        document.getElementById('adBurger').addEventListener('click', function () { side(!sb.classList.contains('open')); });
        ov.addEventListener('click', function () { side(false); });

        var acc = document.getElementById('adAcc'), btn = document.getElementById('adAccBtn');
        function setAcc(o) { acc.classList.toggle('open', o); btn.setAttribute('aria-expanded', o ? 'true' : 'false'); }
        btn.addEventListener('click', function (e) { e.stopPropagation(); setAcc(!acc.classList.contains('open')); });
        document.addEventListener('click', function (e) { if (!acc.contains(e.target)) { setAcc(false); } });
        document.addEventListener('keydown', function (e) { if (e.key === 'Escape') { setAcc(false); side(false); } });
    })();
</script>
@stack('scripts')
@yield('scripts')
</body>
</html>