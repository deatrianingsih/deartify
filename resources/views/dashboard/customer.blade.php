@extends('layouts.dashboard')

@section('content')
<h4 class="fw-semibold mb-1">Selamat datang, {{ auth()->user()->name }}!</h4>
<p class="text-muted mb-4">Temukan berbagai layanan ilustrasi sesuai kebutuhanmu</p>

<div class="card border-0 shadow-sm p-3 mb-4" style="border-radius: 16px; max-width: 300px;">
    <div class="fs-4 fw-semibold">{{ $totalMyOrders }}</div>
    <div class="text-muted small">Total Pesanan Saya</div>
</div>

<div class="card border-0 shadow-sm p-3 mb-4" style="border-radius: 16px;">
    <div class="card-body">
        <h6 class="mb-3">Pesanan Terbaru Saya</h6>
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
                    <tr>
                        <td colspan="3" class="text-center text-muted py-3">Belum ada pesanan</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        <a href="{{ route('orders.create') }}" class="btn text-white" style="background-color: #8B6F5B;">+ Buat Pesanan Baru</a>
    </div>
    @endsection