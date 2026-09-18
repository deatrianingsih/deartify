@extends('layouts.dashboard')

@section('content')
<div class="mb-4">
    <h4 class="fw-semibold mb-1"><i class="bi bi-palette me-2" style="color: #8B6F5B;"></i>Layanan & Harga Jasa</h4>
    <p class="text-muted small mb-0">Pilih layanan ilustrasi yang sesuai dengan kebutuhanmu</p>
</div>

@if (auth()->user()->isAdmin())
    <a href="{{ route('service_prices.create') }}" class="btn text-white mb-4" style="background-color: #8B6F5B;">
        + Tambah Harga Jasa
    </a>
@endif

<div class="row g-3">
    @php
        $badges = ['Populer', 'Paling Dicari', 'Terlaris', 'Favorit'];
    @endphp
    @forelse ($servicePrices as $servicePrice)
        <div class="col-md-4 col-lg-3">
            <div class="h-100" style="border-radius: 16px; overflow: hidden; background-color: #FCF5EC;">
                <div class="position-relative">
                    @if ($servicePrice->image)
                        <img src="{{ Storage::url($servicePrice->image) }}" class="w-100" style="height: 200px; object-fit: cover;">
                    @else
                        <div class="d-flex align-items-center justify-content-center" style="height: 200px; background-color: #F5EAD8;">
                            <span class="text-muted small">Tidak ada gambar</span>
                        </div>
                    @endif
                    <span class="position-absolute top-0 end-0 m-2 badge" style="background-color: #FCF5EC; color: #6B4F3F; font-weight: 500;">
                        ★ {{ $badges[$loop->index % count($badges)] }}
                    </span>
                </div>
                <div class="p-3">
                    <span class="badge mb-2" style="background-color: #EDDECA; color: #6B4F3F; font-weight: 500;">{{ $servicePrice->name }}</span>
                    <h6 class="fw-semibold mb-1">{{ $servicePrice->name }}</h6>
                    <p class="text-muted small mb-2">{{ Str::limit($servicePrice->description, 50) }}</p>
                    <p class="fw-semibold mb-3" style="color: #4A3B32;">Rp{{ number_format($servicePrice->price, 0, ',', '.') }}</p>

                    @if (auth()->user()->isAdmin())
                        <div class="d-flex gap-2">
                            <a href="{{ route('service_prices.edit', $servicePrice) }}" class="btn btn-sm btn-outline-secondary flex-fill">Edit</a>
                            <form action="{{ route('service_prices.destroy', $servicePrice) }}" method="POST" onsubmit="return confirm('Yakin hapus?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
                            </form>
                        </div>
                    @else
                        <a href="{{ route('orders.create', ['service_price_id' => $servicePrice->id]) }}"
                           class="btn w-100 text-white d-flex align-items-center justify-content-center gap-2"
                           style="background-color: #6B4F3F; border-radius: 24px;">
                            Pilih Jasa Ini <i class="bi bi-arrow-right"></i>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    @empty
        <p class="text-muted">Belum ada data harga jasa.</p>
    @endforelse
</div>

<div class="mt-4">
    {{ $servicePrices->links() }}
</div>
@endsection