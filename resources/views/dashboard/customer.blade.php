@extends('layouts.dashboard')

@section('content')
<h4 class="fw-semibold mb-1">Selamat datang, {{ auth()->user()->name }}!</h4>
<p class="text-muted mb-4">Temukan berbagai layanan ilustrasi sesuai kebutuhanmu</p>

<div class="row g-3 mb-4">
    <div class="col">
        <div class="card border-0 shadow-sm text-center p-3" style="border-radius: 16px;">
            <div class="fs-4 fw-semibold">{{ $totalMyOrders }}</div>
            <div class="text-muted small">Total Pesanan</div>
        </div>
    </div>
    <div class="col">
        <div class="card border-0 shadow-sm text-center p-3" style="border-radius: 16px;">
            <div class="fs-4 fw-semibold">{{ $inProgressOrders }}</div>
            <div class="text-muted small">Pesanan Diproses</div>
        </div>
    </div>
    <div class="col">
        <div class="card border-0 shadow-sm text-center p-3" style="border-radius: 16px;">
            <div class="fs-4 fw-semibold">{{ $completedOrders }}</div>
            <div class="text-muted small">Pesanan Selesai</div>
        </div>
    </div>
    <div class="col">
        <div class="card border-0 shadow-sm text-center p-3" style="border-radius: 16px; background-color: #8B6F5B;">
            <div class="fs-4 fw-semibold text-white">{{ $avgRating ? number_format($avgRating, 1) : '-' }} ★</div>
            <div class="small text-white" style="opacity: 0.85;">Rating Saya</div>
        </div>
    </div>
</div>

<h6 class="mb-3">Kategori Layanan</h6>
<div class="row g-3 mb-4">
    @forelse ($popularServices as $service)
        <div class="col-md-3">
            <a href="{{ route('orders.create') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm h-100" style="border-radius: 16px;">
                    @if ($service->image)
                        <img src="{{ Storage::url($service->image) }}" class="card-img-top" style="height: 120px; object-fit: cover; border-radius: 16px 16px 0 0;">
                    @else
                        <div style="height: 120px; background-color: #F5EAD8; border-radius: 16px 16px 0 0;"></div>
                    @endif
                    <div class="card-body text-center py-2">
                        <div class="small fw-medium text-dark">{{ $service->name }}</div>
                    </div>
                </div>
            </a>
        </div>
    @empty
        <p class="text-muted">Belum ada layanan tersedia.</p>
    @endforelse
</div>

<div class="card border-0 shadow-sm" style="border-radius: 16px;">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="mb-0">Pesanan Terbaru</h6>
            <a href="{{ route('orders.index') }}" class="small" style="color: #6B4F3F;">Lihat semua</a>
        </div>
        <table class="table mb-0">
            <thead>
                <tr class="text-muted">
                    <th>Layanan</th>
                    <th>Status</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($myOrders as $order)
                    <tr>
                        <td>{{ $order->servicePrice->name }}</td>
                        <td><span class="badge" style="background-color: #C9AF9A; color: #4A3B32;">{{ $order->status }}</span></td>
                        <td>Rp{{ number_format($order->total_price, 0, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="text-center text-muted py-3">Belum ada pesanan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">
    <a href="{{ route('orders.create') }}" class="btn text-white" style="background-color: #8B6F5B;">+ Buat Pesanan Baru</a>
</div>
@endsection