@extends('layouts.dashboard')

@section('content')
<div class="card border-0 p-4 mb-4 text-white" style="border-radius: 16px; background-color: #8B6F5B;">
    <h5 class="fw-semibold mb-1">Selamat datang, {{ auth()->user()->name }}!</h5>
    <p class="mb-0" style="opacity: 0.9;">Berikut ringkasan pesanan kamu di DeArtify</p>
</div>

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
        <div class="card border-0 shadow-sm text-center p-3" style="border-radius: 16px;">
            <div class="fs-4 fw-semibold">{{ $avgRating ? number_format($avgRating, 1) : '-' }} ★</div>
            <div class="text-muted small">Rating Ulasan</div>
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
                        <td>{{ $order->servicePrice->name }}</td>
                        <td>{{ $order->created_at->format('d M Y') }}</td>
                        <td><span class="badge" style="background-color: #C9AF9A; color: #4A3B32;">{{ $order->status }}</span></td>
                        <td>Rp{{ number_format($order->total_price, 0, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center text-muted py-3">Belum ada pesanan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection