@extends('layouts.dashboard')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-xl font-semibold">Harga Jasa</h1>
        <a href="{{ route('service_prices.create') }}" class="bg-coffee-dark text-white text-sm font-medium px-4 py-2 rounded-lg transition">
            + Tambah Harga Jasa
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
        <table class="w-full text-left">
            <thead>
                <tr class="text-left text-brown/60 border-b border-gray-100">
                    <th class="px-6 py-3 font-medium">Nama Jasa</th>
                    <th class="px-6 py-3 font-medium">Nama Jasa</th>
                    <th class="px-6 py-3 font-medium">Harga</th>
                    <th class="px-6 py-3 font-medium">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($servicePrices as $servicePrice)
                <tr class="border-b border-gray-50 last:border-0">
                    <td class="px-6 py-4 text-sm">{{ $servicePrice->service_name }}</td>
                    <td class="px-6 py-4 text-sm">Rp {{ number_format($servicePrice->price, 0, ',', '.') }}</td>
                    <td class="px-6 py-4 text-sm space-x-2">
                        <a href="{{ route('service_prices.edit', $servicePrice->id) }}" class="text-blue-600 hover:underline">Edit</a>
                        <form action="{{ route('service_prices.destroy', $servicePrice->id) }}" method="POST" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Apakah Anda yakin ingin menghapus harga jasa ini?')" class="text-red-600 hover:underline">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
    </div>