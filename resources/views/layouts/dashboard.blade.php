<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'DeArtify') }}</title>
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=playfair-display|instrument-sans" rel="stylesheet">
    @vute(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#FBF3E7] text-[#4A3B32]">
    <div class="flex min-h-screen">

        {{-- Sidebar --}}
        <aside class="w-64 bg-white border-r border-[#F0E4D3] flex flex-col">
            <div class="px-6 py-6">
                <span class="text=2xl italic" style="font-family: 'Playfair Display', serif;">DeArtify</span>
            </div>

            <nav class="flex-1 px-4 space-y-1">
                @if (auth()->user()->isAdmin())
                @include('layouts.sidebar-admin')
                @else
                @include('layouts.sidebar-customer')
                @endif
            </nav>

            <div class="px-4 py-4 border-t border-[#F0E4D3]">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" cllass="w-full text-left px-4 py-2 rounded-lg hover:bg-[#FBF3E7] text-sm">
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        {{-- Konten utama --}}
        <main class="flex-1 p-8">
            @if (session('success'))
            <div class="mb-4 px-4 py-3 rounded-xl bg-green-100 text-green-800 text-sm">
                {{ session('success') }}
            </div>
            @endif

            @yield('content')
        </main>
    </div>
    
</body>
</html>