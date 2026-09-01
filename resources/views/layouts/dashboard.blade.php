<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'DeArtify') }}</title>
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=playfair-display|instrument-sans" rel="stylesheet">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <style>
        body { background-color: #F5EAD8; }
        .sidebar { background-color: #fff; min-height: 100vh; }
        .sidebar .nav-link { color: #4A3B32; border-radius: 10px; padding: 10px 16px; }
        .sidebar .nav-link-active { background-color: #8B6F5B; color: #fff; }
        .sidebar .nav-link:hover:not (.active) { background-color: #F5EAD8; }
        .brand-logo { font-family: 'Playfair Display', serif; font-style: italic;}
    </style>
</head>
<body >
    <div class="d-flex">
        <nav class="sidebar d-flex flex-column p-3" style="width: 240px;">
            <span class="brand-logo fs-4 mb-4 px-2">DeArtify</span>

            <div class="nav flex-column flex-grow-1">
                @if (auth()->user()->isAdmin())
                    @include('layouts.sidebar-admin')
                @else
                    @include('layouts.sidebar-customer')
                @endif
            </div>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="nav-link border-0 bg-transparent w-100 text-start">Logout</button>
            </form>
        </nav>

        <main class="flex-grow-1 p-4">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @yield('content')
        </main>
    </div>
</body>
</html>