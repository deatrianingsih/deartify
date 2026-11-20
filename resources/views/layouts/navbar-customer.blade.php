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
    background: #fff;
    box-shadow: 0 2px 12px rgba(74, 59, 50, .08);
}

.cx-nav-inner {
    max-width: 1320px;
    margin: 0 auto;
    padding: 0 1.5rem;
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
    color: var(--c-text);
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
    color: var(--c-primary);
}

.cx-links a:hover::after {
    transform: scaleX(.55);
    background: var(--c-mid);
}

.cx-links a.active {
    color: var(--c-dark);
}

.cx-links a.active::after {
    transform: scaleX(1);
    background: var(--c-primary);
}

.cx-collapse form {
    margin: 0;
    display: flex;
    align-items: center;
}

.cx-toggle {
    display: none;
    margin-left: auto;
    border: 0;
    background: var(--c-tint);
    color: var(--c-dark);
    width: 42px;
    height: 42px;
    border-radius: 12px;
    font-size: 1.5rem;
    align-items: center;
    justify-content: center;
}

.cx-main {
    max-width: 1320px;
    margin: 0 auto;
    padding: 1.75rem 1.5rem 3rem;
}

@media (max-width: 991.98px) {
    .cx-nav-inner {
        flex-wrap: wrap;
        height: auto;
        min-height: 64px;
        padding-top: .6rem;
        padding-bottom: .6rem;
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
        background: var(--c-tint);
    }

    .cx-links a::after,
    .cx-links a.active::after {
        display: none;
    }

    .cx-main {
        padding: 1.25rem 1rem 2.5rem;
    }
}
    </style>
    @stack('styles')
</head>
<body>
    @php
        $navLinks = [
            ['label' => 'Dashboard', 'href' => route('home'), 'icon' => 'bi-house', 'active' => request()->routeIs('home')],
            ['label' => 'Layanan & Harga', 'href' => route('service_prices.index'), 'icon' => 'bi-palette', 'active' => request()->routeIs('service_prices.*')],
            ['label' => 'Pesanan Saya', 'href' => route('orders.index'), 'icon' => 'bi-bag', 'active' => request()->routeIs('orders.*')],
            ['label' => 'Ulasan Saya', 'href' => route('reviews.index'), 'icon' => 'bi-star', 'active' => request()->routeIs('reviews.*')],
            ['label' => 'Profil', 'href' => route('profile.show'), 'icon' => 'bi-person', 'active' => request()->routeIs('profile.*')],
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

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-soft d-inline-flex align-items-center gap-2">
                        <i class="bi bi-box-arrow-right"></i>Logout
                    </button>
                </form>
            </div>
        </div>
    </header>

    <main class="cx-main">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @yield('content')
    </main>

    <script>
        (function () {
            var toggle = document.getElementById('cxToggle');
            var menu = document.getElementById('cxMenu');
            toggle.addEventListener('click', function () {
                var open = menu.classList.toggle('open');
                toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
            });
        })();
    </script>
</body>
</html>