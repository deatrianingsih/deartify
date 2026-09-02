@extends('layouts.dashboard')

@section('content')
<div class="container">
    <h4 class="fw-semibold mb-4">Detail Pesanan #{{ $order->id }}</h4>

    <div class="card border-0 shadow-sm" style="border-radius: 16px; max-width: 700px;">
        <div class="card-body">
            <table class="table table-borderless mb-0">
                <tr><th width="200">Customer</th><td>{{ $order->user->name }}</td></tr>
                <tr><th>Jasa</th><td>{{ $order->servicePrice->name }}</td></tr>
                <tr><th>Deskripsi</th><td>{{ $order->description }}</td></tr>
                <tr>
                    <th>Gambar Referensi</th>
                    <td>
                         @if ($order->reference_image)
                            <img src="{{ Storage::url($order->reference_image) }}" width="180" class="rounded">
                        @else
                            -
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Nama Penerima</th><td>{{ $order->recipient_name }}</td>
                </tr>
                <tr>
                    <th>No. Telepon Penerima</th><td>{{ $order->recipient_phone }}</td>
                </tr>
                <tr>
                    <th>Alamat Pengiriman</th><td>{{ $order->shipping_address }}</td>
                </tr>
                <tr>
                    <th>Status</th><td><span class="badge" style="background-color: #C9AF9A; color: #4A3B32">{{ $order->status }}</span></td>
                </tr>
                <tr>
                    <th>Total Harga</th><td>Rp{{ number_format($order->total_price, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <th>Dikirim Pada</th><td>{{ $order->shipped_at ?? '-' }}</td>
                </tr>
            </table>
        </div>
    </div>

    <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary">Kembali</a>
</div>
@endsection