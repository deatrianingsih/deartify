<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>DeArtify</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=caveat:500,700|nunito:400,600,700,800" rel="stylesheet">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @include('layouts.brand')
    <style>
       body {
    font-family: 'Nunito', sans-serif;
}

:root {
    --cx-nav-h: 72px;
}

.cx-nav {
    position: sticky;
    top: 0;
    z-index: 1030;
    background: linear-gradient(120deg, #5E4334 0%, #7A5844 55%, #8B6F5B 100%);
    box-shadow: 0 6px 20px rgba(74, 59, 50, .28);
}

.cx-nav .brand,
.cx-nav .brand i,
.cx-nav .brand span {
    color: #FFF3E0 !important;
}

.cx-nav-inner {
    max-width: none;
    margin: 0 auto;
    padding: 0 2.5rem;
    height: var(--cx-nav-h);
    display: flex;
    align-items: center;
    gap: 2rem;
}

.cx-nav .brand {
    display: flex;
    align-items: center;
    gap: .5rem;
    margin: 0;
    padding: 0;
    line-height: 1;
}

/* Tinggi dibuat eksplisit (bukan persen) supaya menu pasti satu garis tengah dengan logo */
.cx-collapse {
    display: flex;
    flex: 1;
    align-items: center;
    gap: 1rem;
    height: var(--cx-nav-h);
}

.cx-links {
    display: flex;
    align-items: center;
    gap: .15rem;
    height: var(--cx-nav-h);
    margin: 0;
    padding: 0;
    list-style: none;
    flex: 1;
}

.cx-links li {
    display: flex;
    align-items: center;
    height: var(--cx-nav-h);
}

.cx-links a {
    display: flex;
    align-items: center;
    gap: .55rem;
    height: var(--cx-nav-h);
    padding: 0 1.1rem;
    line-height: 1;
    margin: 0 .1rem;
    color: #F6E8D5;
    font-weight: 700;
    font-size: .95rem;
    letter-spacing: .01em;
    text-decoration: none;
    position: relative;
    white-space: nowrap;
    transition: color .2s;
}

.cx-links a i {
    font-size: 1.1rem;
    line-height: 1;
    color: #F1D9B8;
    transition: transform .2s;
}

.cx-links a:hover i {
    transform: translateY(-2px) scale(1.12);
}

.cx-links a::after {
    content: '';
    position: absolute;
    left: .8rem;
    right: .8rem;
    bottom: 0;
    height: 3px;
    border-radius: 3px 3px 0 0;
    background: var(--c-primary);
    transform: scaleX(0);
    transition: transform .25s ease;
}

.cx-links a:hover {
    color: #fff;
    background: rgba(255, 243, 224, .16);
    border-radius: 12px;
    height: 44px;
}

.cx-links a:hover::after {
    transform: scaleX(.55);
    background: var(--c-mid);
}

.cx-links a.active {
    color: #5E4334;
    background: #FFF3E0;
    border-radius: 12px;
    height: 44px;
    box-shadow: 0 6px 14px rgba(0, 0, 0, .22);
}

.cx-links a.active i {
    color: #8B6F5B;
}

.cx-links a.active::after {
    display: none;
}

/* Dropdown akun (Profil + Logout) */
.cx-cart {
    position: relative;
    width: 44px;
    height: 44px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #FFF3E0;
    background: rgba(255, 243, 224, .14);
    font-size: 1.25rem;
    text-decoration: none;
    flex-shrink: 0;
    transition: *background* .2s, transform .2s;
}

.cx-cart:hover,
.cx-cart.active {
    background: #FFF3E0;
    color: #5E4334;
    transform: translateY(-1px);
}

.cx-cart-n {
    position: absolute;
    top: -4px;
    right: -4px;
    min-width: 20px;
    height: 20px;
    padding: 0 .3rem;
    border-radius: 999px;
    background: #E0A21B;
    color: #fff;
    font-size: .7rem;
    font-weight: 800;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 2px solid #6B4F3F;
}

.cx-account {
    position: relative;
}

.cx-acc-btn {
    display: flex;
    align-items: center;
    gap: .6rem;
    background: #FFF3E0;
    color: #5E4334;
    border: 2px solid #FFF3E0;
    box-shadow: 0 4px 12px rgba(0, 0, 0, .2);
    border-radius: 999px;
    padding: .3rem .9rem .3rem .3rem;
    font-weight: 700;
    font-size: .93rem;
    line-height: 1;
    cursor: pointer;
    transition: *background* .2s, border-color .2s;
}

.cx-acc-btn:hover {
    background: #fff;
    transform: translateY(-1px);
}

.cx-acc-text {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    line-height: 1.15;
}

.cx-acc-text small {
    font-size: .68rem;
    font-weight: 700;
    color: #9A7B66;
    letter-spacing: .04em;
    text-transform: uppercase;
}

.cx-acc-btn.active,
.cx-account.open .cx-acc-btn {
    border-color: #E0A21B;
}

.cx-avatar {
    width: 38px;
    height: 38px;
    border-radius: 50%;
    background: linear-gradient(135deg, #A78468, #5E4334);
    color: #fff;
    font-weight: 800;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: .9rem;
    flex-shrink: 0;
}

.cx-acc-arrow {
    font-size: .8rem;
    transition: transform .2s;
}

.cx-account.open .cx-acc-arrow {
    transform: rotate(180deg);
}

.cx-acc-menu {
    display: none;
    position: absolute;
    right: 0;
    top: calc(100% + 10px);
    min-width: 190px;
    background: #fff;
    border: 1px solid var(--c-line);
    border-radius: 14px;
    box-shadow: 0 12px 30px rgba(74, 59, 50, .18);
    padding: .4rem;
    z-index: 1040;
}

.cx-account.open .cx-acc-menu {
    display: block;
}

.cx-acc-menu form {
    margin: 0;
    display: block;
}

.cx-acc-menu a,
.cx-acc-menu button {
    display: flex;
    align-items: center;
    gap: .65rem;
    width: 100%;
    padding: .65rem .8rem;
    border: 0;
    background: transparent;
    border-radius: 10px;
    color: var(--c-text);
    font-weight: 700;
    font-size: .92rem;
    text-align: left;
    text-decoration: none;
    cursor: pointer;
}

.cx-acc-menu a:hover,
.cx-acc-menu button:hover {
    background: var(--c-tint);
}

.cx-acc-menu .danger {
    color: #B3402F;
}

.cx-acc-menu i {
    font-size: 1.05rem;
}

.cx-toggle {
    display: none;
    margin-left: auto;
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

/* footer selalu menempel di dasar layar walau halaman pendek */
body {
    min-height: 100vh;
    display: flex;
    flex-direction: column;
}

.cx-main {
    flex: 1 0 auto;
    width: 100%;
    max-width: none;
    margin: 0 auto;
    padding: 1.75rem 2.5rem 3rem;
}

@media (max-width: 991.98px) {
    .cx-nav-inner {
        flex-wrap: wrap;
        height: auto;
        min-height: 64px;
        padding: .6rem 1rem;
        gap: .5rem;
    }

    .cx-toggle {
        display: inline-flex;
    }

    .cx-collapse {
        display: none;
        flex-direction: column;
        align-items: stretch;
        width: 100%;
        height: auto;
        padding: .5rem 0 .25rem;
    }

    .cx-collapse.open {
        display: flex;
    }

    .cx-cart {
        align-self: flex-start;
        margin: .4rem 0;
    }

    .cx-links {
        flex-direction: column;
        align-items: stretch;
        height: auto;
    }

    .cx-links li {
        display: block;
        height: auto;
    }

    .cx-links a {
        height: auto;
        padding: .75rem 1rem;
        border-radius: 12px;
    }

    .cx-links a.active {
        background: #FFF3E0;
        height: auto;
    }

    .cx-links a::after,
    .cx-links a.active::after {
        display: none;
    }

    .cx-main {
        padding: 1.25rem 1rem 2.5rem;
    }

    .cx-account {
        width: 100%;
    }

    .cx-acc-btn {
        width: 100%;
    }

    .cx-acc-arrow {
        margin-left: auto;
    }

    .cx-acc-menu {
        position: static;
        box-shadow: none;
        margin-top: .4rem;
    }
}
    </style>
    @stack('styles')
</head>
<body>
    @php
        $cartCount = collect(session('cart', []))->sum('qty');
        $navLinks = [
            ['label' => 'Dashboard', 'href' => route('home'), 'icon' => 'bi-house', 'active' => request()->routeIs('home')],
            ['label' => 'Layanan & Harga', 'href' => route('service_prices.index'), 'icon' => 'bi-palette', 'active' => request()->routeIs('service_prices.*')],
            ['label' => 'Pesanan Saya', 'href' => route('orders.index'), 'icon' => 'bi-bag', 'active' => request()->routeIs('orders.*')],
            ['label' => 'Ulasan Saya', 'href' => route('reviews.index'), 'icon' => 'bi-star', 'active' => request()->routeIs('reviews.*')],
        ];
    @endphp

    <header class="cx-nav">
        <div class="cx-nav-inner">
            <a href="{{ route('home') }}" class="brand">
                <i class="bi bi-palette-fill"></i><span>DeArtify</span>
            </a>

            <button type="button" class="cx-toggle" id="cxToggle" aria-controls="cxMenu" aria-expanded="false" aria-label="Buka menu">
                <i class="bi bi-list"></i>
            </button>

            <div class="cx-collapse" id="cxMenu">
                <ul class="cx-links">
                    @foreach ($navLinks as $link)
                        <li>
                            <a href="{{ $link['href'] }}" class="{{ $link['active'] ? 'active' : '' }}">
                                <i class="bi {{ $link['icon'] }}"></i>{{ $link['label'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>

                <a href="{{ route('cart.index') }}" class="cx-cart {{ request()->routeIs('cart.*') ? 'active' : '' }}" aria-label="Keranjang">
                    <i class="bi bi-cart3"></i>
                    @if ($cartCount > 0)<span class="cx-cart-n">{{ $cartCount }}</span>@endif
                </a>

                <div class="cx-account" id="cxAccount">
                    <button type="button" class="cx-acc-btn {{ request()->routeIs('profile.*') ? 'active' : '' }}" id="cxAccBtn" aria-haspopup="true" aria-expanded="false">
                        <span class="cx-avatar">{{ strtoupper(mb_substr(auth()->user()->name, 0, 1)) }}</span>
                        <span class="cx-acc-text"><span class="cx-acc-name">{{ Str::of(auth()->user()->name)->trim()->before(' ') }}</span><small>Customer</small></span>
                        <i class="bi bi-chevron-down cx-acc-arrow"></i>
                    </button>

                    <div class="cx-acc-menu" role="menu" aria-labelledby="cxAccBtn">
                        <a href="{{ route('profile.edit') }}" role="menuitem"><i class="bi bi-pencil-square"></i>Edit Profil</a>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="danger" role="menuitem"><i class="bi bi-box-arrow-right"></i>Logout</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <main class="cx-main">
        @yield('content')
    </main>

    @include('layouts.footer')

    @include('layouts.toast')

    <script>
        (function () {
            var toggle = document.getElementById('cxToggle');
            var menu = document.getElementById('cxMenu');
            toggle.addEventListener('click', function () {
                var open = menu.classList.toggle('open');
                toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
            });

            // Dropdown akun
            var acc = document.getElementById('cxAccount');
            var accBtn = document.getElementById('cxAccBtn');
            function setAcc(open) {
                acc.classList.toggle('open', open);
                accBtn.setAttribute('aria-expanded', open ? 'true' : 'false');
            }
            accBtn.addEventListener('click', function (e) {
                e.stopPropagation();
                setAcc(!acc.classList.contains('open'));
            });
            document.addEventListener('click', function (e) {
                if (!acc.contains(e.target)) { setAcc(false); }
            });
            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape') { setAcc(false); accBtn.focus(); }
            });
        })();
    </script>
</body>
</html>