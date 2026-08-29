@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-3">Detail Pesanan #{{ $order->id }}</h4>

    <table class="table table-bordered">
        <tr><th width="200">Customer</th><td>{{ $order->user->nama }}</td></tr>
        <tr><th>Jasa</th><td>{{ $order->servicePrice->name }}</td></tr>
        <tr><th>Deskripsi</th><td>{{ $order->description }}</td></tr>
        <tr>
            <th>Gambar Referensi</th>
            <td>
                @if ($order->reference_image)
                    <img src="{{ Storage::url($order->reference_image) }}" width="200">
                @else
                    -
                @endif
            </td>
        </tr>
        <tr><th>Nama Penerima</th><td>{{ $order->recipient_name }}</td></tr>
        <tr><th>No. Telepon Penerima</th><td>{{ $order->recipient_phone }}</td></tr>
        <tr><th>Alamat Pengiriman</th><td>{{ $order->shipping_address }}</td></tr>
        <tr><th>Status</th><td><span class="badge bg-secondary">{{ $order->status }}</span></td></tr>
        <tr><th>Total Harga</th><td>Rp{{ number_format($order->total_price, 0, ',', '.') }}</td></tr>
        <tr><th>Dikirim Pada</th><td>{{ $order->shipped_at ?? '-' }}</td></tr>
    </table>

    <a href="{{ route('orders.index') }}" class="btn btn-secondary">Kembali</a>
</div>
@endsection