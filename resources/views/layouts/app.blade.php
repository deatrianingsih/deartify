<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>DeArtify</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=caveat:500,700|nunito:400,600,700,800" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @include('layouts.brand')
    <style>
        body { font-family: 'Nunito', sans-serif; }
        .auth-nav { background: #fff; box-shadow: 0 2px 12px rgba(74, 59, 50, .08); }
        .auth-nav-inner { max-width: 1320px; margin: 0 auto; padding: 0 1.5rem; height: 72px; display: flex; align-items: center; justify-content: space-between; }
        .auth-nav .nav-text { color: var(--c-text); font-weight: 600; text-decoration: none; }
        .auth-nav .nav-text:hover { color: var(--c-primary); }
        .auth-main { min-height: calc(100vh - 72px); display: flex; align-items: center; padding: 2rem 0; }
        .auth-main > .container { width: 100%; }
        .form-control:focus { border-color: var(--c-mid); box-shadow: 0 0 0 .2rem rgba(139, 111, 91, .2); }
        .form-check-input:checked { background-color: var(--c-primary); border-color: var(--c-primary); }
    </style>
</head>
<body>
    <div id="app">
        <nav class="auth-nav">
            <div class="auth-nav-inner">
                <a href="{{ url('/') }}" class="brand">
                    <i class="bi bi-palette-fill"></i><span>DeArtify</span>
                </a>

                <div class="d-flex align-items-center gap-3">
                    @guest
                        @if (Route::has('login'))
                            <a class="nav-text" href="{{ route('login') }}">Masuk</a>
                        @endif

                        @if (Route::has('register'))
                            <a class="btn-brand text-decoration-none" href="{{ route('register') }}">Daftar</a>
                        @endif
                    @else
                        <span class="nav-text d-none d-sm-inline">{{ Auth::user()->name }}</span>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn-soft">Logout</button>
                        </form>
                    @endguest
                </div>
            </div>
        </nav>

        <main class="auth-main">
            @yield('content')
        </main>
    </div>
</body>
</html>