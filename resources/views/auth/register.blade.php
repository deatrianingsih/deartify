<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - DeArtify</title>
    <link href="https://fonts.bunny.net/css?family=playfair-display|instrument-sans" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-cream text-brown">
     <div class="min-h-screen flex items-center justify-center px-8 py-4">
        <div class="w-full max-w-md bg-white rounded-3xl shadow-lg overflow-hidden flex">

            <div class="hidden md:flex w-1/3 bg-cream/20 items-center justify-center p-4">
                <div class="text-center">
                    <div class="w-20 h-20 mx-auto rounded-full bg-cream/30 flex items-center justify-center text-3xl">
                        🎨
                    </div>
                    <p class="mt-3 italic text-sm" style="font-family: 'Playfair Display', serif;">DeArtify</p>
                </div>
            </div>

            <div class="w-full md:w-2/3 p-6">
                <h1 class="text-lg font-semibold mb-1">Buat Akun Baru</h1>
                <p class="text-xs text-brown/60 mb-4">Daftar untuk mulai memesan jasa gambar</p>
            
                @if ($errors->any())
                    <div class="mb-3 px-3 py-2 rounded-xl bg-red-100 text-red-700 text-xs">
                        <ul class="list-disc pl-4">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}" class="space-y-3">
                    @csrf

                                       <div>
                        <label class="block text-xs font-medium mb-1">Nama Lengkap</label>
                        <input type="text" name="nama" value="{{ old('nama') }}" required autofocus
                        class="w-full rounded-lg border border-gray-200 px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-coffee">
                    </div>
                        
                    <div>
                        <label class="block text-xs font-medium mb-1">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" required 
                        class="w-full rounded-lg border border-gray-200 px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-coffee">
                    </div>

                    <div>
                        <label class="block text-xs font-medium mb-1">No. Telepon</label>
                        <input type="text" name="phone" value="{{ old('phone') }}" 
                        class="w-full rounded-lg border border-gray-200 px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-coffee">
                    </div>

                    <div>
                        <label class="block text-xs font-medium mb-1">Password</label>
                        <input type="password" name="password" required 
                        class="w-full rounded-lg border border-gray-200 px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-coffee">
                    </div>

                    <div>
                        <label class="block text-xs font-medium mb-1">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" required 
                        class="w-full rounded-lg border border-gray-200 px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-coffee">
                    </div>

                    <button type="submit" class="w-full bg-coffee hover:bg-coffee-dark text-white font-medium rounded-lg py-2 transition text-sm">
                        Daftar
                    </button>
                </form>

                <p class="text-xs text-center mt-4 text-brown/60">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="text-coffee-dark font-medium hover:underline">Login disini</a>
            </p>
            </div>
        </div>
    </div>
</body>
</html>