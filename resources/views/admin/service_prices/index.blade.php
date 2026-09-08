@extends('layouts.dashboard')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-semibold mb-0">Layanan & Harga Jasa</h4>
    @if (auth()->user()->isAdmin())
        <a href="{{ route('service_prices.create') }}" class="btn text-white" style="background-color: #8B6F5B;">
            + Tambah Harga Jasa
        </a>
    @endif
</div>

<div class="row g-3">
    @forelse ($servicePrices as $servicePrice)
        <div class="col-md-4 col-lg-3">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 16px;">
                @if ($servicePrice->image)
                    <img src="{{ Storage::url($servicePrice->image) }}" class="card-img-top" style="height: 160px; object-fit: cover; border-radius: 16px 16px 0 0;">
                @else
                    <div class="d-flex align-items-center justify-content-center" style="height: 160px; background-color: #F5EAD8; border-radius: 16px 16px 0 0;">
                        <span class="text-muted small">Tidak ada gambar</span>
                    </div>
                @endif
                <div class="card-body">
                    <h6 class="fw-semibold mb-1">{{ $servicePrice->name }}</h6>
                    <p class="text-muted small mb-2">{{ Str::limit($servicePrice->description, 60) }}</p>
                    <p class="fw-semibold mb-3" style="color: #6B4F3F;">Rp{{ number_format($servicePrice->price, 0, ',', '.') }}</p>

                    @if (auth()->user()->isAdmin())
                        <a href="{{ route('service_prices.edit', $servicePrice) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                        <form action="{{ route('service_prices.destroy', $servicePrice) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
                        </form>
                    @else
                        <a href="{{ route('orders.create', ['service_price_id' => $servicePrice->id]) }}" class="btn btn-sm text-white" style="background-color: #8B6F5B;">
                            Pilih Jasa Ini
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