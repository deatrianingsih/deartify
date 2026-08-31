@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-3">Detail Pelanggan: {{ $customer->nama }}</h4>

    <table class="table table-bordered mb-4">
        <tr><th width="200">Nama</th><td>{{ $customer->nama }}</td></tr>
        <tr><th>Email</th><td>{{ $customer->email }}</td></tr>
        <tr><th>No. Telepon</th><td>{{ $customer->phone ?? '-' }}</td></tr>
    </table>

    <h5>Riwayat Pesanan</h5>
    <table class="table table-bordered">
        <thead>
            <tr>
            <th>Jasa</th>
            <th>Status</th>
            <th>Total</th>
        </tr>
        </thead>
        <tbody>
            @forelse ($customer->order as $order)
                <tr>
                    <td>{{ $order->servicePrice->name }}</td>
                    <td>{{ $order->status }}</td>
                    <td>Rp{{ number_format($order->total_price, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr><td colspan="3" class="text-center">Belum pernah pesan.</tr>
            @endforelse
        </tbody>
    </table>

    <a href="{{ route('customers.index') }}" class="btn btn-secondary">Kembali</a>
</div>