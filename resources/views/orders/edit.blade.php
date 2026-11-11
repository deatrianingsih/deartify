@extends('layouts.dashboard')

@push('styles')
<style>
    .ed-wrap { max-width: 860px; margin: 0 auto; }
    .ed-back { display: inline-flex; align-items: center; gap: .4rem; color: #8B6F5B; font-weight: 800; text-decoration: none; margin-bottom: .8rem; }
    .ed-back:hover { color: #5E4334; }
    .ed-head h3 { margin: 0 0 .2rem; font-weight: 800; color: #4A3B32; display: flex; align-items: center; gap: .6rem; }
    .ed-head h3 i { color: #8B6F5B; }
    .ed-head p { margin: 0 0 1.3rem; color: #85766B; }

    .ed-card { background: #fff; border: 1px solid #EFE3D3; border-radius: 22px; box-shadow: 0 2px 14px rgba(74, 59, 50, .07); padding: 1.5rem; margin-bottom: 1.1rem; }
    .ed-sum { display: flex; gap: 1.1rem; align-items: center; flex-wrap: wrap; }
    .ed-img { width: 84px; height: 84px; border-radius: 16px; background: #EDDECA; overflow: hidden; display: flex; align-items: center; justify-content: center; color: #C9AF9A; font-size: 1.8rem; flex-shrink: 0; }
    .ed-img img { width: 100%; height: 100%; object-fit: cover; }
    .ed-info { flex: 1; min-width: 200px; }
    .ed-info h5 { margin: 0 0 .2rem; font-weight: 800; color: #4A3B32; }
    .ed-info div { color: #85766B; font-size: .9rem; }
    .ed-info b { color: #4A3B32; }
    .ed-price { text-align: right; }
    .ed-price small { display: block; color: #9A8B80; font-weight: 600; }
    .ed-price strong { font-size: 1.4rem; color: #5E4334; }

    .ed-lbl { font-size: .74rem; font-weight: 800; letter-spacing: .1em; text-transform: uppercase; color: #9A7B66; margin-bottom: .8rem; }
    .ed-opts { display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: .8rem; }
    .ed-opt { position: relative; display: block; margin: 0; }
    .ed-opt input { position: absolute; opacity: 0; inset: 0; cursor: pointer; z-index: 2; }
    .ed-opt .box { display: block; height: 100%; border: 2px solid #EFE3D3; border-radius: 16px; padding: 1rem .8rem; text-align: center; background: #FDFAF6; transition: all .2s; }
    .ed-opt .box i { display: block; font-size: 1.7rem; margin-bottom: .35rem; color: #B59A85; transition: color .2s; }
    .ed-opt .box b { display: block; color: #4A3B32; }
    .ed-opt .box small { display: block; color: #9A8B80; font-size: .76rem; margin-top: .1rem; }
    .ed-opt:hover .box { border-color: #C9AF9A; transform: translateY(-2px); }
    .ed-opt input:checked + .box { border-color: #8B6F5B; background: #F5EAD8; box-shadow: 0 8px 18px rgba(139, 111, 91, .22); }
    .ed-opt input:checked + .box i { color: #8B6F5B; }
    .ed-opt.danger input:checked + .box { border-color: #C9503F; background: #FBEAEA; box-shadow: 0 8px 18px rgba(179, 64, 47, .2); }
    .ed-opt.danger input:checked + .box i { color: #B3402F; }
    .ed-opt .now { position: absolute; top: -9px; right: 10px; background: #E0A21B; color: #fff; font-size: .66rem; font-weight: 800; padding: .12rem .6rem; border-radius: 999px; z-index: 1; }
    .ed-err { color: #B3402F; font-weight: 700; margin-top: .6rem; }

    .ed-warn { display: none; margin-top: 1rem; background: #FBEAEA; color: #A8392A; border-radius: 14px; padding: .8rem 1rem; font-size: .9rem; gap: .6rem; align-items: flex-start; }
    .ed-card:has(.danger input:checked) .ed-warn { display: flex; }

    .ed-actions { display: flex; gap: .7rem; margin-top: 1.4rem; }
    .ed-save { flex: 1; border: 0; border-radius: 14px; padding: .9rem 1rem; background: linear-gradient(135deg, #8B6F5B, #5E4334); color: #fff; font-weight: 800; display: flex; align-items: center; justify-content: center; gap: .5rem; box-shadow: 0 10px 22px rgba(94, 67, 52, .3); transition: transform .2s; }
    .ed-save:hover { transform: translateY(-2px); }
    .ed-cancel { padding: .9rem 1.5rem; border-radius: 14px; border: 2px solid #D9C3A8; background: #fff; color: #6B4F3F; font-weight: 800; text-decoration: none; }
    .ed-cancel:hover { background: #F5EAD8; color: #5E4334; }
    @media (max-width: 575.98px) { .ed-price { text-align: left; } .ed-actions { flex-direction: column-reverse; } }
</style>
@endpush

@section('content')
@php
    $options = [
        'pending'     => ['Menunggu', 'bi-hourglass-split', 'Belum diproses'],
        'in_progress' => ['Diproses',  'bi-brush',           'Sedang digambar'],
        'shipped'     => ['Dikirim',   'bi-truck',           'Dalam pengiriman'],
        'completed'   => ['Selesai',   'bi-check-circle',    'Pesanan tuntas'],
        'cancelled'   => ['Dibatalkan', 'bi-x-circle',       'Batalkan pesanan'],
    ];
    $current = old('status', $order->status);
@endphp

<div class="ed-wrap">
    <a href="{{ route('orders.index') }}" class="ed-back"><i class="bi bi-arrow-left"></i>Kembali ke Pesanan</a>

    <div class="ed-head">
        <h3><i class="bi bi-arrow-repeat"></i>Ubah Status Pesanan #{{ $order->id }}</h3>
        <p>Pilih status terbaru supaya customer bisa memantau pesanannya.</p>
    </div>

    {{-- Ringkasan pesanan --}}
    <div class="ed-card">
        <div class="ed-sum">
            <div class="ed-img">
                @if ($order->servicePrice?->image)
                    <img src="{{ Storage::url($order->servicePrice->image) }}" alt="">
                @else
                    <i class="bi bi-image"></i>
                @endif
            </div>
            <div class="ed-info">
                <h5>{{ $order->servicePrice?->name ?? 'Layanan' }}</h5>
                <div>Customer: <b>{{ $order->user->name ?? '-' }}</b></div>
                <div>Dipesan: {{ $order->created_at->timezone('Asia/Jakarta')->format('d M Y, H:i') }}</div>
            </div>
            <div class="ed-price"><small>Total</small><strong>Rp{{ number_format($order->total_price, 0, ',', '.') }}</strong></div>
        </div>
    </div>

    {{-- Pilih status --}}
    <form action="{{ route('orders.update', $order) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="ed-card">
            <div class="ed-lbl">Pilih Status</div>
            <div class="ed-opts">
                @foreach ($options as $value => [$label, $icon, $hint])
                    <label class="ed-opt {{ $value === 'cancelled' ? 'danger' : '' }}">
                        <input type="radio" name="status" value="{{ $value }}" {{ $current === $value ? 'checked' : '' }}>
                        <span class="box"><i class="bi {{ $icon }}"></i><b>{{ $label }}</b><small>{{ $hint }}</small></span>
                        @if ($order->status === $value)<span class="now">Saat ini</span>@endif
                    </label>
                @endforeach
            </div>
            @error('status')<div class="ed-err">{{ $message }}</div>@enderror

            <div class="ed-warn"><i class="bi bi-exclamation-triangle"></i><div>Pesanan yang dibatalkan tidak bisa dilanjutkan. Tagihan pembayaran yang belum dibayar akan ikut dihapus.</div></div>

            <div class="ed-actions">
                <a href="{{ route('orders.index') }}" class="ed-cancel">Batal</a>
                <button type="submit" class="ed-save"><i class="bi bi-check2-circle"></i>Simpan Status</button>
            </div>
        </div>
    </form>
</div>
@endsection