@extends('layouts.dashboard')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-semibold mb-0">Detail Pesanan #{{ $order->id }}</h4>
    <span class="badge px-3 py-2" style="background-color: #C9AF9A; color: #4A3B32; font-size: 0.9rem;">
        {{ $order->status }}
    </span>
</div>

@php
    $steps = ['pending' => 'Dipesan', 'in_progress' => 'Diproses', 'shipped' => 'Dikirim', 'completed' => 'Selesai'];
    $statusOrder = array_keys($steps);
    $currentIndex = array_search($order->status, $statusOrder);
@endphp

<div class="card border-0 shadow-sm p-4 mb-3" style="border-radius: 16px;">
    <div class="d-flex justify-content-between align-items-center">
        @foreach ($steps as $key => $label)
        @php $isActive = array_search($key, $statusOrder) <= $currentIndex; @endphp
        <div class="text-center flex-fill position-relative">
            @if (!$loop->first)
            <div style="position: absolute; top:20px; left: -50%; width:100%; height: 2px; background-color:{{ $isActive ? '#8B6F5B' : '#E3D2BA' }}; z-index: 0;"></div>
            @endif
            <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-2 fw-semibold position-relative"
            style="width: 40px; height: 40px; z-index: 1; background-color: {{ $isActive ? '#6B4F3F' : '#fff' }}; color:{{ $isActive ? '#fff' : '#6B4F3F' }}; border: 2px solid #6B4F3F;">
        {{ $loop->iteration }}
        </div>
        <div class="small {{ $isActive ? 'fw-semibold' : 'text-muted' }}">{{ $label }}</div>
    </div>
    @endforeach
</div>
</div>

<div class="row g-3">
    <div class="col-md-7">
        <div class="card border-0 shadow-sm p-4" style="border-radius: 16px;">
            <h6 class="mb-3">Informasi Pesanan</h6>
            <table class="table table-borderless mb-0">
                <tr><th width="160" class="text-muted fw-normal">Customer</th><td>{{ $order->user->name }}</td></tr>
                <tr><th class="text-muted fw-normal">Jasa</th><td>{{ $order->servicePrice->name }}</td></tr>
                <tr><th class="text-muted fw-normal">Deskripsi</th><td>{{ $order->description }}</td></tr>
                <tr><th class="text-muted fw-normal">Total Harga</th><td class="fw-semibold">Rp{{ number_format($order->total_price, 0, ',', '.') }}</td></tr>
                <tr><th class="text-muted fw-normal">Dikirim Pada</th><td>{{ $order->shipped_at ?? '-' }}</td></tr>
            </table>

            <hr>
            <h6 class="mb-3">Data Penerima</h6>
            <table class="table table-borderless mb-0">
                <tr><th width="160" class="text-muted fw-normal">Nama Penerima</th><td>{{ $order->recipient_name }}</td></tr>
                <tr><th class="text-muted fw-normal">No. Telepon</th><td>{{ $order->recipient_phone }}</td></tr>
                <tr><th class="text-muted fw-normal">Alamat</th><td>{{ $order->shipping_address }}</td></tr>
            </table>
        </div>
    </div>

    <div class="col-md-5">
        <div class="card border-0 shadow-sm p-4 text-center" style="border-radius: 16px;">
            <h6 class="mb-3 text-start">Referensi Gambar</h6>
            @if ($order->reference_image)
                <img src="{{ Storage::url($order->reference_image) }}" class="rounded-3 w-100" style="object-fit: cover; max-height: 320px;">
            @else
                <div class="d-flex align-items-center justify-content-center text-muted" style="height: 200px; background-color: #F5EAD8; border-radius: 12px;">
                    Tidak ada gambar referensi
                </div>
            @endif
        </div>
    </div>
</div>

<a href="{{ route('orders.index') }}" class="btn btn-outline-secondary mt-3">Kembali</a>
@endsection