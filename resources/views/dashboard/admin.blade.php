@extends('layouts.dashboard')

@section('content')
<h4 class="fw-semibold mb-1">Selamat datang, {{ auth()->user()->name }}!</h4>
<p class="text-muted mb-4">Berikut ringkasan data DeArtify</p>

<div class="row g-3 mb-4">
    <div class="col">
        <div class="card border-0 shadow-sm text-center p-3" style="border-radius: 16px;">
            <div class="fs-4 fw-semibold">{{ $totalCustomers }}</div>
            <div class="text-muted small">Total Customers</div>
        </div>
    </div>
    <div class="col">
        <div class="card border-0 shadow-sm text-center p-3" style="border-radius: 16px;">
            <div class="fs-4 fw-semibold">{{ $totalOrders }}</div>
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
            <div class="fs-5 fw-semibold">Rp{{ number_format($totalRevenue, 0, ',', '.') }}</div>
            <div class="text-muted small" style="opacity: 0.85;">Total Pendapatan</div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm" style="border-radius: 16px;">
    <div class="card-body">
        <h6 class="mb-3">Pesanan Terbaru</h6>
        <table class="table mb-0">
            <thead>
                <tr class="text-muted">
                    <th>Customer</th>
                    <th>Layanan</th>
                    <th>Status</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($recentOrders as $order)
                    <tr>
                        <td>{{ $order->user->name }}</td>
                        <td>{{ $order->servicePrice->name }}</td>
                        <td><span class="badge" style="background-color: #C9AF9A; color: #4A3B32;">{{ $order->status }}</span></td>
                        <td>Rp{{ number_format($order->total_price, 0, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted py-3">Belum ada pesanan terbaru.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection