@extends('layouts.dashboard')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-semibold mb-0">Harga Jasa</h4>
        <a href="{{ route('service_prices.create') }}" class="btn text-white" style="background-color: #8B6F5B;">
            + Tambah Harga Jasa
        </a>
    </div>

    <div class="card border-0 shadow-sm" style="border-radius: 16px;">
        <table class="card-body p-0">
            <thead>
                <tr class="text-muted">
                    <th class="px-4 py-3">Nama Jasa</th>
                    <th class="px-4 py-3">Deskripsi</th>
                    <th class="px-4 py-3">Harga</th>
                    <th class="px-4 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($servicePrices as $servicePrice)
                <tr>
                    <td class="px-4 py-3 fw-medium">{{ $servicePrice->service_name }}</td>
                    <td class="px-4 py-3 text-muted">{{ $servicePrice->description }}</td>
                    <td class="px-4 py-3">Rp {{ number_format($servicePrice->price, 0, ',', '.') }}</td>
                    <td class="px-4 py-3">
                        <a href="{{ route('service_prices.edit', $servicePrice) }}" style="color: #6B4F3F">Edit</a>
                        <form action="{{ route('service_prices.destroy', $servicePrice) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-link text-danger p-0 ms-3">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center text-muted">Belum ada data harga jasa.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        </div>
    </div>

    <div class="mt-3">
        {{ $servicePrices->links() }}
    </div>
@endsection