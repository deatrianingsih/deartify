@extends('layouts.dashboard')

@section('content')
<div class="d-flex justify-content-end align-items-center gap-3 mb-3">
    <i class="bi bi-bell fs-5 text-muted"></i>
    <div class="d-flex align-items-center gap-2">
        <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-semibold"
             style="width: 36px; height: 36px; background-color: #8B6F5B; font-size: 0.85rem;">
            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
        </div>
        <span class="small fw-medium">Halo, {{ auth()->user()->name }}</span>
        <i class="bi bi-chevron-down small text-muted"></i>
    </div>
</div>
<div class="card border-0 shadow-sm p-5 mb-4 overflow-hidden" style="
    border-radius: 16px;
    min-height: 190px;
    background-image: linear-gradient(to right, #F5EAD8 0%, rgba(245,234,216,0.85) 35%, rgba(245,234,216,0.4) 60%, rgba(245,234,216,0) 100%), url('{{ asset('images/lukis.jpg') }}');
    background-size: cover;
    background-position: center right;
    background-repeat: no-repeat;
">
    <div style="max-width: 55%;">
        <h5 class="fw-semibold mb-1">Selamat datang, {{ auth()->user()->name }}!</h5>
        <p class="mb-0 text-muted">Yuk, pesan ilustrasi impianmu sekarang dan wujudkan ide kreatifmu bersama DeArtify!</p>
    </div>
</div>
<div class="row g-3 mb-4">
    <div class="col">
        <div class="card border-0 shadow-sm text-center p-4" style="border-radius: 16px; background-color: #F5EAD8;">
            <div class="fs-4 fw-semibold">{{ $totalMyOrders }}</div>
            <div class="text-muted small">Total Pesanan</div>
        </div>
    </div>
    <div class="col">
        <div class="card border-0 shadow-sm text-center p-4" style="border-radius: 16px; background-color: #F5EAD8;">
            <div class="fs-4 fw-semibold">{{ $inProgressOrders }}</div>
            <div class="text-muted small">Pesanan Diproses</div>
        </div>
    </div>
    <div class="col">
        <div class="card border-0 shadow-sm text-center p-4" style="border-radius: 16px; background-color: #F5EAD8;">
            <div class="fs-4 fw-semibold">{{ $completedOrders }}</div>
            <div class="text-muted small">Pesanan Selesai</div>
        </div>
    </div>
    <div class="col">
        <div class="card border-0 shadow-sm text-center p-4 text-white" style="border-radius: 16px; background-color: #8B6F5B;">
            <div class="fs-4 fw-semibold">{{ $avgRating ? number_format($avgRating, 1) : '-' }} ★</div>
            <div class="small" style="opacity: 0.9;">Rating Ulasan</div>
        </div>
    </div>
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
                    <th>Judul Pesanan</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($myOrders as $order)
                    <tr>
                        <td class="py-3">
                            <div class="d-flex align-items-center gap-2">
                                @if ($order->servicePrice->image)
                                <img src="{{ Storage::url($order->servicePrice->image) }}" width="32" height="32" class="rounded" style="object-fit: cover;">
                                @else
                                <div class="rounded" style="width: 32px; height: 32px; background-color: #F5EAD8;"></div>
                                @endif
                                 {{ $order->servicePrice->name }}
                            </div>
                        </td>
                        <td class="py-3">{{ $order->created_at->format('d M Y') }}</td>
                        <td class="py-3"><span class="badge" style="background-color: #C9AF9A; color: #4A3B32;">{{ $order->status }}</span></td>
                        <td class="py-3">Rp{{ number_format($order->total_price, 0, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center text-muted py-3">Belum ada pesanan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection