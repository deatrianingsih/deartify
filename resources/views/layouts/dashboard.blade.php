<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'DeArtify') }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=playfair-display|instrument-sans" rel="stylesheet">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body { background-color: #FCF5EC; }
        .sidebar { background-color: #EDDECA; min-height: 100vh; }
        .sidebar .nav-link { color: #4A3B32; border-radius: 10px; padding: 10px 16px; }
        .sidebar .nav-link.active { background-color: #8B6F5B; color: #fff; }
        .sidebar .nav-link:hover:not(.active) { background-color: #E3D2BA; }
        .brand-logo { font-family: 'Playfair Display', serif; font-style: italic; color: #6B4F3F}
    </style>
</head>
<body>
    <div class="d-flex" style="min-height: 100vh;">
        <nav class="sidebar d-flex flex-column p-3" style="width: 240px;">
            <div class="px-2 py-2 mb-3 text-center">
                <span class="brand-logo fs-3 fw-bold">DeArtify</span>
            </div>

            <div class="nav flex-column flex-grow-1">
                @if (auth()->user()->isAdmin())
                    @include('layouts.sidebar-admin')
                @else
                    @include('layouts.sidebar-customer')
                @endif
            </div>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="nav-link border-0 bg-transparent w-100 text-start">
                    <i class="bi bi-box-arrow-right me-2"></i>Logout
                </button>
            </form>
        </nav>

        <div class="d-flex flex-column flex-grow-1">
            <header class="d-flex justify-content-end align-items-center gap-3 px-4 py-3" style="background-color: #8B6F5B;">
                <i class="bi bi-bell fs-5 text-white"></i>
                <div class="d-flex align-items-center gap-2">
                    <div class="rounded-circle d-flex align-items-center justify-content-center fw-semibold"
                         style="width: 32px; height: 32px; background-color: #FFF8F0; color: #8B6F5B; font-size: 0.8rem;">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <span class="small fw-medium text-white">Halo, {{ auth()->user()->name }}</span>
                    <i class="bi bi-chevron-down small text-white"></i>
                </div>
            </header>

            <main class="flex-grow-1 p-4">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>