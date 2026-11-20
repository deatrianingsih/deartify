@extends('layouts.dashboard')

@push('styles')
<style>
    
.cd-wrap {
    max-width: 1100px;
    margin: 0 auto;
}

.cd-back {
    display: inline-flex;
    align-items: center;
    gap: .4rem;
    color: #8B6F5B;
    font-weight: 800;
    text-decoration: none;
    margin-bottom: .8rem;
}

.cd-back:hover {
    color: #5E4334;
}


.cd-profile {
    background: linear-gradient(135deg, #8B6F5B, #5E4334);
    color: #fff;
    border-radius: 24px;
    padding: 1.6rem 1.8rem;
    display: flex;
    align-items: center;
    gap: 1.3rem;
    flex-wrap: wrap;
    box-shadow: 0 14px 30px rgba(94, 67, 52, .3);
    margin-bottom: 1.1rem;
}

.cd-ava {
    width: 84px;
    height: 84px;
    border-radius: 50%;
    background: #FFF3E0;
    color: #5E4334;
    font-weight: 800;
    font-size: 2.2rem;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 4px solid rgba(255, 243, 224, .4);
    flex-shrink: 0;
}

.cd-who {
    flex: 1;
    min-width: 220px;
}

.cd-who h3 {
    margin: 0 0 .25rem;
    font-weight: 800;
}

.cd-who .since {
    color: #F1D9B8;
    font-size: .9rem;
}

.cd-contact {
    display: flex;
    gap: .6rem;
    flex-wrap: wrap;
    margin-top: .8rem;
}

.cd-chip {
    display: inline-flex;
    align-items: center;
    gap: .45rem;
    background: rgba(255, 243, 224, .16);
    border: 1px solid rgba(255, 243, 224, .3);
    color: #FFF3E0;
    padding: .4rem .95rem;
    border-radius: 999px;
    font-size: .88rem;
    font-weight: 700;
    text-decoration: none;
}

a.cd-chip:hover {
    background: rgba(255, 243, 224, .28);
    color: #fff;
}

/* STATISTICS */
.cd-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: .9rem;
    margin-bottom: 1.1rem;
}

.cd-stat {
    background: #fff;
    border: 1px solid #EFE3D3;
    border-radius: 18px;
    padding: 1rem 1.2rem;
    display: flex;
    align-items: center;
    gap: .9rem;
    box-shadow: 0 2px 12px rgba(74, 59, 50, .06);
}

.cd-stat .ic {
    width: 46px;
    height: 46px;
    border-radius: 14px;
    background: #F5EAD8;
    color: #8B6F5B;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.3rem;
    flex-shrink: 0;
}

.cd-stat strong {
    display: block;
    font-size: 1.3rem;
    color: #4A3B32;
    line-height: 1.15;
}

.cd-stat small {
    color: #85766B;
    font-weight: 600;
}

.cd-card {
    background: #fff;
    border: 1px solid #EFE3D3;
    border-radius: 22px;
    box-shadow: 0 2px 14px rgba(74, 59, 50, .07);
    overflow: hidden;
}

.cd-title {
    padding: 1.1rem 1.4rem;
    font-weight: 800;
    color: #4A3B32;
    display: flex;
    align-items: center;
    gap: .6rem;
    border-bottom: 1px solid #F3E9DA;
}

.cd-title i {
    color: #8B6F5B;
}

.cd-title span {
    margin-left: auto;
    background: #F5EAD8;
    color: #6B4F3F;
    font-size: .8rem;
    padding: .15rem .7rem;
    border-radius: 999px;
}

.cd-table {
    width: 100%;
    border-collapse: collapse;
}

.cd-table th {
    background: #FBF3E8;
    color: #85766B;
    font-size: .76rem;
    font-weight: 800;
    letter-spacing: .07em;
    text-transform: uppercase;
    padding: .8rem 1.2rem;
    text-align: left;
}

.cd-table td {
    padding: .85rem 1.2rem;
    border-bottom: 1px solid #F3E9DA;
    vertical-align: middle;
}

.cd-table tbody tr:last-child td {
    border-bottom: 0;
}

.cd-table tbody tr:hover {
    background: #FDF6EA;
}

/* SERVICE */
.cd-svc {
    display: flex;
    align-items: center;
    gap: .8rem;
}

.cd-thumb {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    background: #EDDECA;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #C9AF9A;
    flex-shrink: 0;
}

.cd-thumb img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.cd-svc b {
    color: #4A3B32;
    display: block;
}

.cd-svc small {
    color: #9A8B80;
}

/* STATUS */
.cd-st {
    display: inline-flex;
    align-items: center;
    gap: .35rem;
    padding: .3rem .8rem;
    border-radius: 999px;
    font-size: .8rem;
    font-weight: 800;
}

.st-pending {
    background: #FFF1D6;
    color: #9A6A0B;
}

.st-in_progress {
    background: #E4EEFB;
    color: #2F5FA3;
}

.st-shipped {
    background: #EDE4FA;
    color: #5B3FA3;
}

.st-completed {
    background: #E3F4E6;
    color: #2F7A3D;
}

.st-cancelled {
    background: #FBEAEA;
    color: #B3402F;
}

/* LINKS & EMPTY STATE */
.cd-link {
    color: #8B6F5B;
    font-weight: 800;
    text-decoration: none;
    white-space: nowrap;
}

.cd-link:hover {
    color: #5E4334;
    text-decoration: underline;
}

.cd-empty {
    text-align: center;
    padding: 2.6rem 1rem;
    color: #85766B;
}

.cd-empty i {
    font-size: 2.6rem;
    color: #C9AF9A;
    display: block;
    margin-bottom: .4rem;
}

</style>
@endpush

@section('content')
@php
    $orders = $customer->orders()->with('servicePrice')->latest()->get();
    $done = $orders->where('status', 'completed');
    $labels = ['pending' => ['Menunggu', 'bi-hourglass-split'], 'in_progress' => ['Diproses', 'bi-brush'], 'shipped' => ['Dikirim', 'bi-truck'], 'completed' => ['Selesai', 'bi-check-circle'], 'cancelled' => ['Dibatalkan', 'bi-x-circle']];
    $phone = $customer->phone ?? $customer->no_telepon ?? $customer->telepon ?? null;
    $wa = $phone ? preg_replace('/^0/', '62', preg_replace('/\D/', '', $phone)) : null;
@endphp

<div class="cd-wrap">
    <a href="{{ route('customers.index') }}" class="cd-back"><i class="bi bi-arrow-left"></i>Kembali ke Data Pelanggan</a>

    <div class="cd-profile">
        <div class="cd-ava">{{ strtoupper(mb_substr($customer->name, 0, 1)) }}</div>
        <div class="cd-who">
            <h3>{{ $customer->name }}</h3>
            <div class="since">Bergabung sejak {{ $customer->created_at?->timezone('Asia/Jakarta')->locale('id')->translatedFormat('j F Y') }}</div>
            <div class="cd-contact">
                <span class="cd-chip"><i class="bi bi-envelope"></i>{{ $customer->email }}</span>
                @if ($phone)
                    <a href="https://wa.me/{{ $wa }}" target="_blank" rel="noopener" class="cd-chip"><i class="bi bi-whatsapp"></i>{{ $phone }}</a>
                @endif
            </div>
        </div>
    </div>

    <div class="cd-stats">
        <div class="cd-stat"><span class="ic"><i class="bi bi-bag"></i></span><div><strong>{{ $orders->count() }}</strong><small>Total Pesanan</small></div></div>
        <div class="cd-stat"><span class="ic"><i class="bi bi-check-circle"></i></span><div><strong>{{ $done->count() }}</strong><small>Pesanan Selesai</small></div></div>
        <div class="cd-stat"><span class="ic"><i class="bi bi-wallet2"></i></span><div><strong>Rp{{ number_format($done->sum('total_price'), 0, ',', '.') }}</strong><small>Total Belanja</small></div></div>
    </div>

    <div class="cd-card">
        <div class="cd-title"><i class="bi bi-clock-history"></i>Riwayat Pesanan<span>{{ $orders->count() }}</span></div>
        @if ($orders->isEmpty())
            <div class="cd-empty"><i class="bi bi-bag-x"></i>Belum pernah pesan.</div>
        @else
            <div class="table-responsive">
                <table class="cd-table">
                    <thead><tr><th>Jasa</th><th>Tanggal</th><th>Status</th><th style="text-align:right;">Total</th><th></th></tr></thead>
                    <tbody>
                        @foreach ($orders as $order)
                            @php [$lbl, $ico] = $labels[$order->status] ?? [$order->status, 'bi-circle']; @endphp
                            <tr>
                                <td>
                                    <div class="cd-svc">
                                        <span class="cd-thumb">@if ($order->servicePrice?->image)<img src="{{ Storage::url($order->servicePrice->image) }}" alt="">@else<i class="bi bi-image"></i>@endif</span>
                                        <div><b>{{ $order->servicePrice?->name ?? 'Layanan dihapus' }}</b><small>Pesanan #{{ $order->id }}</small></div>
                                    </div>
                                </td>
                                <td style="white-space:nowrap;">{{ $order->created_at->timezone('Asia/Jakarta')->format('d M Y') }}</td>
                                <td><span class="cd-st st-{{ $order->status }}"><i class="bi {{ $ico }}"></i>{{ $lbl }}</span></td>
                                <td style="text-align:right;font-weight:800;color:#5E4334;">Rp{{ number_format($order->total_price, 0, ',', '.') }}</td>
                                <td style="text-align:right;"><a href="{{ route('orders.show', $order) }}" class="cd-link">Detail <i class="bi bi-arrow-right"></i></a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection