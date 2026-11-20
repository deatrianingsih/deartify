@extends('layouts.dashboard')

@push('styles')
<style>
   .dt-wrap {
    max-width: 1180px;
    margin: 0 auto;
}

/* Header */
.dt-top {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    gap: 1rem;
    flex-wrap: wrap;
    margin-bottom: 1.1rem;
}

.dt-back {
    display: inline-flex;
    align-items: center;
    gap: .4rem;
    color: #85766B;
    text-decoration: none;
    font-weight: 700;
    font-size: .9rem;
    margin-bottom: .4rem;
}

.dt-back:hover {
    color: var(--c-primary, #8B6F5B);
}

.dt-title {
    margin: 0;
    font-weight: 800;
    color: var(--c-text, #4A3B32);
    font-size: 1.6rem;
}

.dt-meta {
    color: #85766B;
    font-size: .9rem;
    margin-top: .15rem;
    display: flex;
    flex-wrap: wrap;
    gap: .4rem .9rem;
}

.dt-meta i {
    margin-right: .25rem;
}

.dt-pill {
    display: inline-flex;
    align-items: center;
    gap: .4rem;
    font-size: .8rem;
    font-weight: 800;
    letter-spacing: .04em;
    text-transform: uppercase;
    padding: .45rem .95rem;
    border-radius: 999px;
}

.dt-st-pending {
    background: #EDDECA;
    color: #6B4F3F;
}

.dt-st-in_progress {
    background: #FCE9C4;
    color: #9A6A12;
}

.dt-st-shipped {
    background: #DCEBFA;
    color: #2F6597;
}

.dt-st-completed {
    background: #DDF1E3;
    color: #2E7D4F;
}

.dt-st-cancelled {
    background: #F8D7DA;
    color: #842029;
}

.dt-card {
    background: #fff;
    border-radius: 18px;
    box-shadow: 0 2px 14px rgba(74, 59, 50, .08);
    padding: 1.4rem 1.5rem;
    margin-bottom: 1.1rem;
}

.dt-card h5 {
    font-size: 1rem;
    font-weight: 800;
    color: var(--c-text, #4A3B32);
    margin: 0 0 1rem;
    display: flex;
    align-items: center;
    gap: .55rem;
}

.dt-card h5 i {
    color: var(--c-primary, #8B6F5B);
    font-size: 1.15rem;
}

/* Stepper */
.dt-steps {
    display: flex;
    padding: .4rem 0 .2rem;
}

.dt-step {
    flex: 1;
    text-align: center;
    position: relative;
}

.dt-step::before {
    content: '';
    position: absolute;
    top: 22px;
    left: -50%;
    width: 100%;
    height: 3px;
    background: #E9DCCB;
    z-index: 0;
}

.dt-step:first-child::before {
    display: none;
}

.dt-step.done::before,
.dt-step.now::before {
    background: var(--c-primary, #8B6F5B);
}

.dt-dot {
    position: relative;
    z-index: 1;
    width: 46px;
    height: 46px;
    border-radius: 50%;
    margin: 0 auto .55rem;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    background: #fff;
    border: 3px solid #E9DCCB;
    color: #C9B8A8;
}

.dt-step.done .dt-dot {
    background: var(--c-primary, #8B6F5B);
    border-color: var(--c-primary, #8B6F5B);
    color: #fff;
}

.dt-step.now .dt-dot {
    background: var(--c-dark, #6B4F3F);
    border-color: var(--c-dark, #6B4F3F);
    color: #fff;
    box-shadow: 0 0 0 6px rgba(139, 111, 91, .18);
}

.dt-step .lbl {
    font-weight: 800;
    font-size: .9rem;
    color: #A89B90;
}

.dt-step.done .lbl,
.dt-step.now .lbl {
    color: var(--c-text, #4A3B32);
}

.dt-step .when {
    font-size: .78rem;
    color: #85766B;
    margin-top: .1rem;
}

/* Dibatalkan */
.dt-cancel {
    display: flex;
    gap: 1.1rem;
    align-items: flex-start;
    background: linear-gradient(135deg, #FFF3F2, #FDF8F6);
    border: 1px solid #F3D3CF;
}

.dt-cancel-ic {
    width: 54px;
    height: 54px;
    border-radius: 50%;
    background: #FBE1DE;
    color: #B3402F;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.7rem;
    flex-shrink: 0;
}

.dt-cancel h5 {
    margin: 0 0 .15rem;
    color: #B3402F;
}

.dt-cancel .when {
    color: #85766B;
    font-size: .88rem;
    margin-bottom: .8rem;
}

.dt-reason {
    background: #fff;
    border: 1px solid #F3D3CF;
    border-radius: 12px;
    padding: .7rem 1rem;
    display: inline-block;
    min-width: 260px;
}

.dt-reason small {
    display: block;
    color: #85766B;
    font-size: .78rem;
    text-transform: uppercase;
    letter-spacing: .04em;
    font-weight: 700;
}

.dt-reason strong {
    color: var(--c-text, #4A3B32);
}

/* Produk */
.dt-prod {
    display: flex;
    gap: 1rem;
    align-items: center;
}

.dt-thumb {
    width: 92px;
    height: 92px;
    border-radius: 14px;
    overflow: hidden;
    background: var(--c-soft, #EDDECA);
    flex-shrink: 0;
    border: 1px solid var(--c-line, #EFE3D3);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--c-mid, #C9AF9A);
    font-size: 1.8rem;
}

.dt-thumb img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.dt-prod h6 {
    font-weight: 800;
    font-size: 1.05rem;
    margin: 0 0 .2rem;
    color: var(--c-text, #4A3B32);
}

.dt-prod .price {
    margin-left: auto;
    font-weight: 800;
    color: var(--c-dark, #6B4F3F);
    white-space: nowrap;
    align-self: flex-start;
}

.dt-tag {
    display: inline-flex;
    align-items: center;
    gap: .3rem;
    font-size: .76rem;
    font-weight: 700;
    color: var(--c-primary, #8B6F5B);
    border: 1px solid var(--c-mid, #C9AF9A);
    border-radius: 6px;
    padding: .1rem .5rem;
}

.dt-note {
    margin-top: 1rem;
    background: var(--c-tint, #F5EAD8);
    border-radius: 12px;
    padding: .85rem 1rem;
}

.dt-note small {
    display: block;
    color: #85766B;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .04em;
    font-size: .74rem;
    margin-bottom: .2rem;
}

/* Baris info dengan ikon */
.dt-rows {
    display: flex;
    flex-direction: column;
}

.dt-row {
    display: flex;
    gap: .9rem;
    padding: .8rem 0;
    border-bottom: 1px solid var(--c-line, #EFE3D3);
}

.dt-row:last-child {
    border-bottom: 0;
    padding-bottom: 0;
}

.dt-row:first-child {
    padding-top: 0;
}

.dt-row .ic {
    width: 38px;
    height: 38px;
    border-radius: 11px;
    background: var(--c-tint, #F5EAD8);
    color: var(--c-primary, #8B6F5B);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    font-size: 1.1rem;
}

.dt-row small {
    display: block;
    color: #85766B;
    font-size: .8rem;
}

.dt-row .v {
    font-weight: 700;
    color: var(--c-text, #4A3B32);
}

/* Pembayaran */
.dt-qr {
    text-align: center;
    background: var(--c-tint, #F5EAD8);
    border-radius: 16px;
    padding: 1.1rem;
}

.dt-qr img {
    width: 100%;
    max-width: 230px;
    border-radius: 12px;
    background: #fff;
}

.dt-qr .cap {
    font-size: .85rem;
    color: #6F6258;
    margin-top: .5rem;
}

.dt-proof {
    max-height: 200px;
    border-radius: 12px;
    border: 1px solid var(--c-line, #EFE3D3);
}

.dt-upload {
    margin-top: 1rem;
}

.dt-upload label {
    font-weight: 700;
    font-size: .9rem;
    margin-bottom: .4rem;
    display: block;
}

.dt-upload .form-control {
    border-radius: 12px;
    border: 1.5px solid var(--c-line, #EFE3D3);
    background: #FDFAF6;
    padding: .6rem .9rem;
}

/* Ringkasan kanan */
.dt-ref {
    display: block;
    border-radius: 14px;
    overflow: hidden;
    border: 1px solid var(--c-line, #EFE3D3);
    background: var(--c-tint, #F5EAD8);
}

.dt-ref img {
    width: 100%;
    max-height: 320px;
    object-fit: cover;
    display: block;
    transition: transform .25s;
}

.dt-ref:hover img {
    transform: scale(1.03);
}

.dt-ref-empty {
    height: 150px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    color: #9A8B80;
    font-size: .9rem;
    gap: .3rem;
}

.dt-ref-empty i {
    font-size: 1.8rem;
    color: var(--c-mid, #C9AF9A);
}

.dt-sum {
    display: flex;
    justify-content: space-between;
    gap: 1rem;
    padding: .55rem 0;
    font-size: .93rem;
    border-bottom: 1px solid var(--c-line, #EFE3D3);
}

.dt-sum span:first-child {
    color: #85766B;
}

.dt-sum.total {
    border-bottom: 0;
    padding-top: .8rem;
}

.dt-sum.total strong {
    font-size: 1.3rem;
    color: var(--c-dark, #6B4F3F);
}

.dt-actions {
    display: flex;
    flex-direction: column;
    gap: .6rem;
    margin-top: 1.1rem;
}

.dt-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: .5rem;
    width: 100%;
    padding: .8rem 1rem;
    border-radius: 12px;
    font-weight: 800;
    font-size: .95rem;
    text-decoration: none;
    cursor: pointer;
    border: 1.5px solid var(--c-mid, #C9AF9A);
    background: #fff;
    color: var(--c-dark, #6B4F3F);
    transition: *background* .2s, color .2s;
}

.dt-btn:hover {
    background: var(--c-tint, #F5EAD8);
    color: var(--c-dark, #6B4F3F);
}

.dt-btn.primary {
    background: var(--c-primary, #8B6F5B);
    border-color: var(--c-primary, #8B6F5B);
    color: #fff;
}

.dt-btn.primary:hover {
    background: var(--c-dark, #6B4F3F);
    color: #fff;
}

.dt-btn.danger {
    border-color: #E3A9A9;
    color: #B3402F;
}

.dt-btn.danger:hover {
    background: #FBEAEA;
    color: #B3402F;
}

@media (max-width: 575.98px) {
    .dt-title {
        font-size: 1.35rem;
    }

    .dt-card {
        padding: 1.1rem;
    }

    .dt-dot {
        width: 38px;
        height: 38px;
        font-size: 1rem;
    }

    .dt-step::before {
        top: 18px;
    }

    .dt-step .lbl {
        font-size: .74rem;
    }

    .dt-step .when {
        display: none;
    }

    .dt-prod {
        flex-wrap: wrap;
    }

    .dt-prod .price {
        width: 100%;
        margin-left: 0;
    }

    .dt-cancel {
        flex-direction: column;
    }

    .dt-reason {
        min-width: 0;
        width: 100%;
    }
}
</style>
@endpush

@section('content')
@php
    $isAdmin = auth()->user()->isAdmin();
    $isOwner = $order->user_id === auth()->id();
    $isCancelled = $order->status === 'cancelled';
    $service = $order->servicePrice;
    $code = '#ORD-' . $order->created_at->format('Ymd') . '-' . str_pad($order->id, 3, '0', STR_PAD_LEFT);
    $fmt = fn ($d, $f = 'j F Y, H:i') => \Illuminate\Support\Carbon::parse($d)->copy()->timezone('Asia/Jakarta')->locale('id')->translatedFormat($f);

    $statusLabels = ['pending' => 'Menunggu', 'in_progress' => 'Diproses', 'shipped' => 'Dikirim', 'completed' => 'Selesai', 'cancelled' => 'Dibatalkan'];
    $statusIcons = ['pending' => 'bi-clock', 'in_progress' => 'bi-hourglass-split', 'shipped' => 'bi-truck', 'completed' => 'bi-check-circle-fill', 'cancelled' => 'bi-x-circle-fill'];

    $steps = [
        'pending' => ['label' => 'Dipesan', 'icon' => 'bi-bag-check'],
        'in_progress' => ['label' => 'Diproses', 'icon' => 'bi-brush'],
        'shipped' => ['label' => 'Dikirim', 'icon' => 'bi-truck'],
        'completed' => ['label' => 'Selesai', 'icon' => 'bi-patch-check'],
    ];
    $stepKeys = array_keys($steps);
    $currentIndex = array_search($order->status, $stepKeys);

    $wallet = $payment ? ($wallets[$payment->method] ?? null) : null;
    $payPaid = $payment && $payment->status !== 'pending';
    $canCancel = $isOwner && in_array($order->status, ['pending', 'in_progress'], true);
@endphp

<div class="dt-wrap">
    {{-- Header --}}
    <div class="dt-top">
        <div>
            <a href="{{ route('orders.index') }}" class="dt-back"><i class="bi bi-arrow-left"></i>Kembali ke daftar pesanan</a>
            <h3 class="dt-title">Detail Pesanan</h3>
            <div class="dt-meta">
                <span><i class="bi bi-hash"></i>{{ ltrim($code, '#') }}</span>
                <span><i class="bi bi-calendar3"></i>{{ $fmt($order->created_at) }}</span>
                @if ($isAdmin)
                    <span><i class="bi bi-person"></i>{{ $order->user->name }}</span>
                @endif
            </div>
        </div>
        <span class="dt-pill dt-st-{{ $order->status }}"><i class="bi {{ $statusIcons[$order->status] ?? 'bi-circle' }}"></i>{{ $statusLabels[$order->status] ?? $order->status }}</span>
    </div>

    {{-- Status / Progres --}}
    @if ($isCancelled)
        <div class="dt-card dt-cancel">
            <div class="dt-cancel-ic"><i class="bi bi-x-lg"></i></div>
            <div>
                <h5>Pesanan Dibatalkan</h5>
                @if ($order->cancelled_at)
                    <div class="when"><i class="bi bi-clock me-1"></i>{{ $fmt($order->cancelled_at) }}</div>
                @endif
                @if ($order->cancel_reason)
                    <div class="dt-reason">
                        <small>Alasan pembatalan</small>
                        <strong>{{ $order->cancel_reason }}</strong>
                    </div>
                @endif
            </div>
        </div>
    @else
        <div class="dt-card">
            <h5><i class="bi bi-signpost-split"></i>Progres Pesanan</h5>
            <div class="dt-steps">
                @foreach ($steps as $key => $step)
                    @php
                        $idx = array_search($key, $stepKeys);
                        $state = $idx < $currentIndex ? 'done' : ($idx === $currentIndex ? 'now' : '');
                    @endphp
                    <div class="dt-step {{ $state }}">
                        <div class="dt-dot"><i class="bi {{ $state === 'done' ? 'bi-check-lg' : $step['icon'] }}"></i></div>
                        <div class="lbl">{{ $step['label'] }}</div>
                        <div class="when">
                            @if ($key === 'pending')
                                {{ $fmt($order->created_at, 'j M, H:i') }}
                            @elseif ($key === 'shipped' && $order->shipped_at)
                                {{ $fmt($order->shipped_at, 'j M, H:i') }}
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <div class="row g-3">
        {{-- ============ KIRI ============ --}}
        <div class="col-lg-8">
            {{-- Pesanan --}}
            <div class="dt-card">
                <h5><i class="bi bi-bag"></i>Pesanan</h5>
                @if ($order->items->isNotEmpty())
                    @foreach ($order->items as $item)
                        <div class="dt-prod" style="{{ ! $loop->last ? 'margin-bottom:.8rem;' : '' }}">
                            <div class="dt-thumb">
                                @if ($item->image)
                                    <img src="{{ Storage::url($item->image) }}" alt="{{ $item->name }}">
                                @else
                                    <i class="bi bi-image"></i>
                                @endif
                            </div>
                            <div>
                                <h6>{{ $item->name }}</h6>
                                <span class="dt-tag"><i class="bi {{ $item->isProduct() ? 'bi-bag-heart' : 'bi-palette' }}"></i>{{ $item->isProduct() ? 'Produk' : 'Jasa ilustrasi digital' }} &bull; {{ $item->quantity }} x Rp{{ number_format($item->price, 0, ',', '.') }}</span>
                            </div>
                            <div class="price">Rp{{ number_format($item->subtotal, 0, ',', '.') }}</div>
                        </div>
                    @endforeach
                @else
                <div class="dt-prod">
                    <div class="dt-thumb">
                        @if ($service?->image)
                            <img src="{{ Storage::url($service->image) }}" alt="{{ $service->name }}">
                        @else
                            <i class="bi bi-image"></i>
                        @endif
                    </div>
                    <div>
                        <h6>{{ $service?->name ?? 'Layanan dihapus' }}</h6>
                        <span class="dt-tag"><i class="bi bi-palette"></i>Jasa ilustrasi digital</span>
                    </div>
                    <div class="price">Rp{{ number_format($order->total_price, 0, ',', '.') }}</div>
                </div>
                @endif
                <div class="dt-note">
                    <small>Deskripsi pesanan</small>
                    {{ $order->description }}
                </div>
            </div>

            {{-- Penerima --}}
            <div class="dt-card">
                <h5><i class="bi bi-geo-alt"></i>Informasi Penerima</h5>
                <div class="dt-rows">
                    <div class="dt-row">
                        <div class="ic"><i class="bi bi-person"></i></div>
                        <div><small>Nama penerima</small><div class="v">{{ $order->recipient_name }}</div></div>
                    </div>
                    <div class="dt-row">
                        <div class="ic"><i class="bi bi-telephone"></i></div>
                        <div><small>Nomor telepon</small><div class="v">{{ $order->recipient_phone }}</div></div>
                    </div>
                    <div class="dt-row">
                        <div class="ic"><i class="bi bi-house-door"></i></div>
                        <div><small>Alamat pengiriman</small><div class="v">{{ $order->shipping_address }}</div></div>
                    </div>
                    @if ($order->shipping_lat && $order->shipping_lng)
                        <div class="dt-row">
                            <div class="ic"><i class="bi bi-geo-alt"></i></div>
                            <div>
                                <small>Titik lokasi</small>
                                <div class="v">
                                    <a href="https://www.google.com/maps?q={{ $order->shipping_lat }},{{ $order->shipping_lng }}" target="_blank" rel="noopener" style="color:#8B6F5B;font-weight:800;text-decoration:none;"><i class="bi bi-map"></i> Buka di Google Maps</a>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if ($order->shipped_at)
                        <div class="dt-row">
                            <div class="ic"><i class="bi bi-truck"></i></div>
                            <div><small>Dikirim pada</small><div class="v">{{ $fmt($order->shipped_at) }}</div></div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Pembayaran --}}
            @if ($payment)
                <div class="dt-card">
                    <h5 class="justify-content-between">
                        <span class="d-flex align-items-center gap-2"><i class="bi bi-wallet2"></i>Pembayaran</span>
                        @if ($payPaid)
                            <span class="dt-pill dt-st-completed"><i class="bi bi-check-circle-fill"></i>Lunas</span>
                        @elseif ($isCancelled)
                            <span class="dt-pill dt-st-cancelled">Dibatalkan</span>
                        @elseif ($payment->isEwallet() && $payment->proof_path)
                            <span class="dt-pill dt-st-in_progress">Menunggu konfirmasi</span>
                        @else
                            <span class="dt-pill dt-st-pending">Belum dibayar</span>
                        @endif
                    </h5>

                    @if (! $payment->isEwallet())
                        <div class="dt-row" style="border:0; padding:0;">
                            <div class="ic"><i class="bi bi-cash-coin"></i></div>
                            <div>
                                <small>Metode pembayaran</small>
                                <div class="v">COD (bayar di tempat)</div>
                                <small class="mt-1">Bayar langsung saat pesanan diterima.</small>
                            </div>
                        </div>
                    @else
                        <div class="row g-3 align-items-start">
                            @if ($payment->status === 'pending' && ! $isCancelled && $wallet && ! empty($wallet['image']) && file_exists(public_path($wallet['image'])))
                                <div class="col-md-5">
                                    <div class="dt-qr">
                                        <img src="{{ asset($wallet['image']) }}" alt="QR {{ $wallet['label'] }}">
                                        <div class="cap">Scan QR, bayar sesuai total</div>
                                    </div>
                                </div>
                            @endif
                            <div class="col">
                                <div class="dt-rows">
                                    <div class="dt-row">
                                        <div class="ic"><i class="bi bi-qr-code-scan"></i></div>
                                        <div><small>Metode pembayaran</small><div class="v">{{ $payment->methodLabel() }}</div></div>
                                    </div>
                                    <div class="dt-row">
                                        <div class="ic"><i class="bi bi-cash-stack"></i></div>
                                        <div><small>Total bayar</small><div class="v fs-5">Rp{{ number_format($payment->amount, 0, ',', '.') }}</div></div>
                                    </div>
                                    @if ($wallet && ! empty($wallet['number']))
                                        <div class="dt-row">
                                            <div class="ic"><i class="bi bi-phone"></i></div>
                                            <div>
                                                <small>Nomor {{ $wallet['label'] }}</small>
                                                <div class="v">{{ $wallet['number'] }}@if (! empty($wallet['name'])) <span class="fw-normal text-muted">a.n. {{ $wallet['name'] }}</span>@endif</div>
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                @if (config('payment.note') && $payment->status === 'pending' && ! $isCancelled)
                                    <p class="small text-muted mt-3 mb-0"><i class="bi bi-info-circle me-1"></i>{{ ($wallet && ! empty($wallet['image']) && file_exists(public_path($wallet['image']))) ? config('payment.note') : 'Transfer sesuai total pesanan ke nomor di atas, lalu unggah bukti pembayaran.' }}</p>
                                @endif
                            </div>
                        </div>

                        @if ($payment->proof_path)
                            <div class="mt-3">
                                <small class="text-muted d-block mb-2">Bukti pembayaran</small>
                                <a href="{{ Storage::url($payment->proof_path) }}" target="_blank">
                                    <img src="{{ Storage::url($payment->proof_path) }}" class="dt-proof" alt="Bukti pembayaran">
                                </a>
                            </div>
                        @endif

                        {{-- Pesanan batal tapi sudah transfer -> arahkan refund lewat WhatsApp admin --}}
                        @if ($isCancelled && $payment->proof_path)
                            @php
                                $waAdmin = '6281574793771'; // GANTI dengan nomor WhatsApp admin (format 62..., tanpa 0 di depan & tanpa tanda +)
                                $waCode = '#ORD-' . $order->created_at->format('Ymd') . '-' . str_pad($order->id, 3, '0', STR_PAD_LEFT);
                                $waText = "Halo admin DeArtify, saya ingin mengajukan refund untuk pesanan {$waCode} (Rp" . number_format($payment->amount, 0, ',', '.') . ") yang sudah dibatalkan. Mohon diproses ya.";
                            @endphp
                            <div class="mt-3 p-3" style="background:#EAF4FF; border:1px solid #BBD8F5; border-radius:14px; color:#2F6597;">
                                <div class="fw-bold mb-1"><i class="bi bi-arrow-counterclockwise me-1"></i>Pengembalian dana (refund)</div>
                                <div class="small mb-2">Kamu sudah melakukan pembayaran. Refund diproses lewat WhatsApp admin: kirim kode pesanan <strong>{{ $waCode }}</strong>, nomor e-wallet tujuan, dan atas nama pemiliknya.</div>
                                @if (! $isAdmin)
                                    <a href="https://wa.me/{{ $waAdmin }}?text={{ urlencode($waText) }}" target="_blank" rel="noopener" class="dt-btn primary" style="width:auto; display:inline-flex; background:#25D366; border-color:#25D366; color:#fff;">
                                        <i class="bi bi-whatsapp"></i>Ajukan Refund via WhatsApp
                                    </a>
                                @endif
                            </div>
                        @endif

                        @if ($payment->status === 'pending' && ! $isCancelled && $payment->user_id === auth()->id())
                            <form action="{{ route('payments.proof', $payment) }}" method="POST" enctype="multipart/form-data" class="dt-upload">
                                @csrf
                                <label>{{ $payment->proof_path ? 'Ganti bukti pembayaran' : 'Unggah bukti pembayaran' }}</label>
                                <input type="file" name="proof" accept="image/*" class="form-control mb-2 @error('proof') is-invalid @enderror" required>
                                @error('proof') <div class="invalid-feedback d-block mb-2">{{ $message }}</div> @enderror
                                <button type="submit" class="dt-btn primary" style="width:auto;"><i class="bi bi-upload"></i>Kirim Bukti</button>
                            </form>
                        @endif
                    @endif
                </div>
            @endif
        </div>

        {{-- ============ KANAN ============ --}}
        <div class="col-lg-4">
            <div class="dt-card">
                <h5><i class="bi bi-image"></i>Referensi Gambar</h5>
                @if ($order->reference_image)
                    <a href="{{ Storage::url($order->reference_image) }}" target="_blank" class="dt-ref">
                        <img src="{{ Storage::url($order->reference_image) }}" alt="Referensi gambar">
                    </a>
                    <div class="small text-muted mt-2 text-center">Klik gambar untuk memperbesar</div>
                @else
                    <div class="dt-ref dt-ref-empty"><i class="bi bi-image"></i>Tidak ada gambar referensi</div>
                @endif
            </div>

            <div class="dt-card">
                <h5><i class="bi bi-receipt"></i>Rincian Biaya</h5>
                @php
                    $fee = (float) ($order->shipping_fee ?? 0);
                    $areaLabel = config('shipping.areas.'.($order->delivery_area ?? 'local').'.label');
                @endphp
                <div class="dt-sum"><span>{{ $order->items->isNotEmpty() ? 'Subtotal item' : 'Harga layanan' }}</span><span>Rp{{ number_format($order->total_price - $fee, 0, ',', '.') }}</span></div>
                <div class="dt-sum"><span>Ongkir @if ($areaLabel)<small class="text-muted">({{ $areaLabel }})</small>@endif</span><span>{{ $fee > 0 ? 'Rp' . number_format($fee, 0, ',', '.') : 'Gratis' }}</span></div>
                <div class="dt-sum"><span>Metode bayar</span><span>{{ $payment ? $payment->methodLabel() : 'COD' }}</span></div>
                <div class="dt-sum total"><span>Total</span><strong>Rp{{ number_format($order->total_price, 0, ',', '.') }}</strong></div>

                <div class="dt-actions">
                    @if (! $isAdmin && $order->status === 'completed')
                        <a href="{{ route('reviews.create', $order) }}" class="dt-btn primary"><i class="bi bi-star"></i>Beri Ulasan</a>
                    @endif
                    @if ($isAdmin)
                        <a href="{{ route('orders.edit', $order) }}" class="dt-btn primary"><i class="bi bi-pencil-square"></i>Ubah Status</a>
                    @endif
                    @if ($canCancel)
                        <a href="{{ route('orders.cancel.form', $order) }}" class="dt-btn danger"><i class="bi bi-x-circle"></i>Batalkan Pesanan</a>
                    @endif
                    <a href="{{ route('orders.index') }}" class="dt-btn"><i class="bi bi-arrow-left"></i>Kembali</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection