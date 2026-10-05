@extends('layouts.dashboard')

@push('styles')
<style>
    .dash-panel { background: #fff; border-radius: 20px; box-shadow: var(--c-shadow); padding: 1.1rem; }

    /* Hero */
    .hero { position: relative; overflow: hidden; border-radius: 18px; padding: 2.2rem; min-height: 290px; display: flex; align-items: center; background: linear-gradient(120deg, #F5EAD8 0%, #F8EFE2 55%, #EDDECA 100%); }
    .hero-copy { position: relative; z-index: 2; max-width: 52%; }
    .hero h1 { font-family: 'Caveat', cursive; font-size: 3.5rem; font-weight: 700; color: var(--c-dark); line-height: 1; margin: 0 0 .3rem; }
    .hero h2 { font-family: 'Caveat', cursive; font-size: 2.1rem; font-weight: 500; color: var(--c-text); margin: 0 0 .8rem; }
    .hero h2 b { color: var(--c-primary); font-weight: 700; }
    .hero p { color: #7A6A5E; margin-bottom: 1.3rem; max-width: 420px; }
    .hero-art { position: absolute; right: .75rem; top: 50%; transform: translateY(-50%); height: 115%; max-height: 330px; width: auto; z-index: 1; }

    /* Layanan Kami */
    .sec-head { display: flex; justify-content: space-between; align-items: center; margin: 1.7rem .25rem 1rem; }
    .sec-head h5 { margin: 0; font-weight: 700; display: flex; gap: .6rem; align-items: center; font-size: 1.05rem; }
    .sec-head h5 i { color: var(--c-primary); font-size: 1.25rem; }
    .sec-head a { color: var(--c-primary); font-weight: 700; text-decoration: none; font-size: .88rem; }

    .svc-card { display: block; background: #fff; border: 1px solid var(--c-line); border-radius: 16px; overflow: hidden; text-decoration: none; color: inherit; height: 100%; box-shadow: 0 1px 6px rgba(74, 59, 50, .06); transition: transform .2s, box-shadow .2s; }
    .svc-card:hover { transform: translateY(-3px); box-shadow: 0 8px 22px rgba(74, 59, 50, .15); color: inherit; }
    .svc-img { position: relative; height: 150px; background: var(--c-tint); }
    .svc-img img { width: 100%; height: 100%; object-fit: cover; display: block; }
    .svc-ph { height: 100%; display: flex; align-items: center; justify-content: center; color: var(--c-mid); font-size: 2.4rem; }
    .svc-chip { position: absolute; left: 10px; bottom: 10px; background: var(--c-soft); color: var(--c-dark); font-size: .72rem; font-weight: 700; padding: .2rem .65rem; border-radius: 999px; max-width: calc(100% - 20px); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .svc-body { padding: .85rem .95rem 1rem; display: flex; flex-direction: column; min-height: 165px; }
    .svc-body h6 { font-weight: 700; margin: 0 0 .3rem; }
    .svc-body p { font-size: .8rem; color: #85766B; margin: 0 0 .8rem; flex: 1; }
    .svc-foot { display: flex; justify-content: space-between; align-items: flex-end; }
    .svc-foot small { display: block; font-size: .68rem; color: #9A8B80; }
    .svc-foot strong { font-size: .98rem; }
    .svc-go { width: 32px; height: 32px; border-radius: 50%; background: var(--c-soft); color: var(--c-primary); display: inline-flex; align-items: center; justify-content: center; transition: background .2s, color .2s; }
    .svc-card:hover .svc-go { background: var(--c-primary); color: #fff; }

    /* Kolom kanan */
    .side-card { background: #fff; border-radius: 20px; box-shadow: var(--c-shadow); padding: 1.25rem; }
    .side-title { display: flex; align-items: center; gap: .65rem; font-weight: 700; font-size: 1.02rem; margin: 0 0 1rem; }
    .side-title i { color: var(--c-primary); font-size: 1.25rem; }

    .order-box { border: 1px solid var(--c-line); border-radius: 14px; padding: .9rem; }
    .order-thumb { width: 64px; height: 64px; border-radius: 12px; object-fit: cover; background: var(--c-tint); flex-shrink: 0; }
    .st { font-size: .7rem; font-weight: 700; padding: .15rem .6rem; border-radius: 999px; white-space: nowrap; }
    .st-pending { background: #EDDECA; color: #6B4F3F; }
    .st-progress { background: #FCE9C4; color: #9A6A12; }
    .st-shipped { background: #DCEBFA; color: #2F6597; }
    .st-done { background: #DDF1E3; color: #2E7D4F; }
    .order-link { display: flex; justify-content: flex-end; margin-top: .75rem; padding-top: .75rem; border-top: 1px solid var(--c-line); }
    .order-link a { color: var(--c-primary); font-weight: 700; font-size: .82rem; text-decoration: none; }

    .quick { border: 1px solid var(--c-line); border-radius: 14px; overflow: hidden; }
    .quick a { display: flex; align-items: center; gap: .9rem; padding: .85rem 1rem; text-decoration: none; color: inherit; border-bottom: 1px solid var(--c-line); transition: background .2s; }
    .quick a:last-child { border-bottom: 0; }
    .quick a:hover { background: var(--c-tint); }
    .quick-ico { width: 40px; height: 40px; border-radius: 50%; background: var(--c-soft); color: var(--c-primary); display: inline-flex; align-items: center; justify-content: center; font-size: 1.05rem; flex-shrink: 0; }
    .quick-ico.gold { background: #FDEBD0; color: #E39A2D; }
    .quick b { display: block; font-size: .9rem; }
    .quick small { color: #9A8B80; }
    .quick .bi-chevron-right { margin-left: auto; color: #B5A394; }

    .thanks { background: #EDDECA; border-radius: 16px; padding: 1.4rem; display: flex; align-items: center; gap: 1rem; color: var(--c-dark); }
    .thanks .font-hand { font-size: 1.75rem; line-height: 1.1; flex: 1; }
    .thanks .deco { font-size: 1.6rem; color: var(--c-primary); opacity: .8; }

    @media (max-width: 767.98px) {
        .hero { padding: 1.5rem; }
        .hero-copy { max-width: 100%; }
        .hero h1 { font-size: 2.9rem; }
        .hero-art { opacity: .15; right: -40px; }
    }
</style>
@endpush

@section('content')
@php
    $firstName = Str::of(auth()->user()->name)->trim()->before(' ');
    $statusMeta = [
        'pending' => ['label' => 'Menunggu', 'class' => 'st-pending'],
        'in_progress' => ['label' => 'Diproses', 'class' => 'st-progress'],
        'shipped' => ['label' => 'Dikirim', 'class' => 'st-shipped'],
        'completed' => ['label' => 'Selesai', 'class' => 'st-done'],
    ];
@endphp

<div class="row g-4">
    {{-- Kolom kiri: sambutan + layanan --}}
    <div class="col-xl-8">
        <div class="dash-panel">
            <div class="hero">
                <div class="hero-copy">
                    <h1>Hai, {{ $firstName }}! 👋</h1>
                    <h2>Selamat datang di <b>DeArtify</b></h2>
                    <p>Pesan jasa gambar favoritmu dengan mudah dan aman. Ubah ide dan ceritamu menjadi karya seni yang istimewa di sini!</p>
                    <a href="{{ route('service_prices.index') }}" class="btn-brand text-decoration-none d-inline-flex align-items-center gap-2">
                        Lihat Layanan <i class="bi bi-arrow-right"></i>
                    </a>
                </div>

                @include('layouts.sketch-art', ['class' => 'hero-art'])
            </div>

            <div class="sec-head">
                <h5><i class="bi bi-palette2"></i>Layanan Kami</h5>
                <a href="{{ route('service_prices.index') }}">Lihat Semua <i class="bi bi-arrow-right"></i></a>
            </div>

            <div class="row row-cols-2 row-cols-md-4 g-3">
                @forelse ($services as $service)
                    <div class="col">
                        <a href="{{ route('orders.create', ['service_price_id' => $service->id]) }}" class="svc-card">
                            <div class="svc-img">
                                @if ($service->image)
                                    <img src="{{ Storage::url($service->image) }}" alt="{{ $service->name }}">
                                @else
                                    <div class="svc-ph"><i class="bi bi-image"></i></div>
                                @endif
                                <span class="svc-chip">{{ $service->badge ?: $service->name }}</span>
                            </div>
                            <div class="svc-body">
                                <h6>{{ $service->name }}</h6>
                                <p>{{ Str::limit($service->description, 55) }}</p>
                                <div class="svc-foot">
                                    <div>
                                        <small>Mulai dari</small>
                                        <strong>Rp {{ number_format($service->price, 0, ',', '.') }}</strong>
                                    </div>
                                    <span class="svc-go"><i class="bi bi-arrow-right"></i></span>
                                </div>
                            </div>
                        </a>
                    </div>
                @empty
                    <div class="col-12">
                        <p class="text-muted text-center py-4 mb-0">Belum ada layanan yang tersedia.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Kolom kanan: status pesanan, menu cepat, ucapan --}}
    <div class="col-xl-4">
        <div class="d-flex flex-column gap-4">
            <div class="side-card">
                <h6 class="side-title"><i class="bi bi-clipboard-check"></i>Status Pesanan Terbaru</h6>

                @if ($latestOrder)
                    @php
                        $meta = $statusMeta[$latestOrder->status] ?? ['label' => ucfirst(str_replace('_', ' ', $latestOrder->status)), 'class' => 'st-pending'];
                        $latestService = $latestOrder->servicePrice;
                    @endphp
                    <div class="order-box">
                        <div class="d-flex gap-3 align-items-center">
                            @if ($latestService?->image)
                                <img src="{{ Storage::url($latestService->image) }}" alt="" class="order-thumb">
                            @else
                                <div class="order-thumb d-flex align-items-center justify-content-center" style="color: var(--c-mid);"><i class="bi bi-image fs-4"></i></div>
                            @endif
                            <div style="min-width: 0;">
                                <div class="d-flex flex-wrap align-items-center gap-2 mb-1">
                                    <strong>{{ $latestService?->name ?? 'Pesanan' }}</strong>
                                    <span class="st {{ $meta['class'] }}">{{ $meta['label'] }}</span>
                                </div>
                                <div class="small text-muted">#ORD-{{ $latestOrder->created_at->format('Ymd') }}-{{ str_pad($latestOrder->id, 3, '0', STR_PAD_LEFT) }}</div>
                                <div class="small text-muted">{{ $latestOrder->created_at->copy()->timezone('Asia/Jakarta')->locale('id')->translatedFormat('j F Y • H:i') }}</div>
                            </div>
                        </div>
                        <div class="order-link">
                            <a href="{{ route('orders.show', $latestOrder) }}">Lihat Detail <i class="bi bi-arrow-right"></i></a>
                        </div>
                    </div>
                @else
                    <div class="order-box text-center py-4">
                        <i class="bi bi-bag-heart fs-2" style="color: var(--c-mid);"></i>
                        <p class="text-muted small mb-3 mt-2">Kamu belum punya pesanan.</p>
                        <a href="{{ route('service_prices.index') }}" class="btn-brand btn-sm text-decoration-none">Pesan Sekarang</a>
                    </div>
                @endif
            </div>

            <div class="side-card">
                <h6 class="side-title"><i class="bi bi-lightning-charge"></i>Menu Cepat</h6>
                <div class="quick">
                    <a href="{{ route('service_prices.index') }}">
                        <span class="quick-ico"><i class="bi bi-bag"></i></span>
                        <span><b>Layanan & Harga</b><small>Lihat semua jasa yang tersedia</small></span>
                        <i class="bi bi-chevron-right"></i>
                    </a>
                    <a href="{{ route('orders.index') }}">
                        <span class="quick-ico"><i class="bi bi-card-checklist"></i></span>
                        <span><b>Pesanan Saya</b><small>Cek status pesanan kamu</small></span>
                        <i class="bi bi-chevron-right"></i>
                    </a>
                    <a href="{{ route('reviews.index') }}">
                        <span class="quick-ico gold"><i class="bi bi-star-fill"></i></span>
                        <span><b>Ulasan Saya</b><small>Lihat dan berikan ulasan</small></span>
                        <i class="bi bi-chevron-right"></i>
                    </a>
                    <a href="{{ route('profile.show') }}">
                        <span class="quick-ico"><i class="bi bi-person"></i></span>
                        <span><b>Profil</b><small>Atur data akun kamu</small></span>
                        <i class="bi bi-chevron-right"></i>
                    </a>
                </div>
            </div>

            <div class="thanks">
                <i class="bi bi-heart-fill deco"></i>
                <div class="font-hand">Terima kasih sudah percaya pada DeArtify</div>
                <i class="bi bi-pencil deco"></i>
            </div>
        </div>
    </div>
</div>
@endsection