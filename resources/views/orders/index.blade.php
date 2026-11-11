@extends('layouts.dashboard')

@push('styles')
<style>
    .od-head { display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: .75rem; margin-bottom: 1.1rem; }
    .od-head h4 { margin: 0 0 .2rem; font-weight: 700; display: flex; align-items: center; gap: .6rem; }
    .od-head h4 i { color: var(--c-primary, #8B6F5B); }
    .od-btn-new { display: inline-flex; align-items: center; gap: .4rem; background: var(--c-primary, #8B6F5B); color: #fff; border-radius: 12px; padding: .6rem 1.1rem; font-weight: 700; font-size: .9rem; text-decoration: none; }
    .od-btn-new:hover { background: var(--c-dark, #6B4F3F); color: #fff; }

    /* Tab status ala marketplace */
    .od-tabs { display: flex; background: #fff; border-radius: 16px; box-shadow: 0 2px 12px rgba(74, 59, 50, .07); overflow-x: auto; scrollbar-width: none; }
    .od-tabs::-webkit-scrollbar { display: none; }
    .od-tab { flex: 1 0 auto; display: flex; align-items: center; justify-content: center; gap: .45rem; padding: 1rem 1.2rem; color: #85766B; font-weight: 700; font-size: .92rem; text-decoration: none; white-space: nowrap; border-bottom: 3px solid transparent; transition: color .2s, background .2s; }
    .od-tab:hover { color: var(--c-primary, #8B6F5B); background: #FDFAF6; }
    .od-tab.active { color: var(--c-dark, #6B4F3F); border-bottom-color: var(--c-primary, #8B6F5B); }
    .od-count { min-width: 20px; height: 20px; padding: 0 .4rem; border-radius: 999px; background: var(--c-soft, #EDDECA); color: var(--c-dark, #6B4F3F); font-size: .72rem; display: inline-flex; align-items: center; justify-content: center; }
    .od-tab.active .od-count { background: var(--c-primary, #8B6F5B); color: #fff; }

    .od-search { position: relative; margin: 1rem 0 1.1rem; }
    .od-search i { position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: #9A8B80; }
    .od-search input { width: 100%; border: 1.5px solid var(--c-line, #EFE3D3); border-radius: 12px; padding: .7rem 1rem .7rem 2.6rem; background: #fff; font-size: .92rem; }
    .od-search input:focus { outline: none; border-color: var(--c-primary, #8B6F5B); box-shadow: 0 0 0 .2rem rgba(139, 111, 91, .15); }

    /* Kartu pesanan */
    .od-card { background: #fff; border-radius: 16px; box-shadow: 0 2px 12px rgba(74, 59, 50, .07); margin-bottom: 1rem; overflow: hidden; }
    .od-card-head { display: flex; justify-content: space-between; align-items: center; gap: 1rem; padding: .85rem 1.2rem; border-bottom: 1px solid var(--c-line, #EFE3D3); flex-wrap: wrap; }
    .od-meta { display: flex; align-items: center; gap: .6rem; flex-wrap: wrap; font-size: .85rem; color: #85766B; }
    .od-meta strong { color: var(--c-text, #4A3B32); }
    .od-avatar { width: 26px; height: 26px; border-radius: 50%; background: var(--c-primary, #8B6F5B); color: #fff; font-size: .75rem; font-weight: 700; display: inline-flex; align-items: center; justify-content: center; }
    .od-dot { width: 4px; height: 4px; border-radius: 50%; background: #C9B8A8; }
    .od-status { display: inline-flex; align-items: center; gap: .35rem; font-size: .78rem; font-weight: 800; letter-spacing: .03em; text-transform: uppercase; padding: .3rem .75rem; border-radius: 999px; white-space: nowrap; }
    .od-st-pending { background: #EDDECA; color: #6B4F3F; }
    .od-st-progress { background: #FCE9C4; color: #9A6A12; }
    .od-st-shipped { background: #DCEBFA; color: #2F6597; }
    .od-st-done { background: #DDF1E3; color: #2E7D4F; }
    .od-st-cancel { background: #F8D7DA; color: #842029; }

    .od-body { display: flex; gap: 1rem; padding: 1.1rem 1.2rem; text-decoration: none; color: inherit; align-items: center; }
    .od-body:hover { background: #FDFAF6; color: inherit; }
    .od-thumb { width: 88px; height: 88px; border-radius: 12px; overflow: hidden; background: var(--c-tint, #F5EAD8); flex-shrink: 0; border: 1px solid var(--c-line, #EFE3D3); }
    .od-thumb img { width: 100%; height: 100%; object-fit: cover; display: block; }
    .od-thumb .ph { height: 100%; display: flex; align-items: center; justify-content: center; color: var(--c-mid, #C9AF9A); font-size: 1.6rem; }
    .od-info { flex: 1; min-width: 0; }
    .od-name { font-weight: 800; font-size: 1rem; color: var(--c-text, #4A3B32); margin: 0 0 .2rem; }
    .od-desc { color: #85766B; font-size: .86rem; margin: 0 0 .35rem; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
    .od-tag { display: inline-flex; align-items: center; gap: .3rem; font-size: .74rem; font-weight: 700; color: var(--c-primary, #8B6F5B); border: 1px solid var(--c-mid, #C9AF9A); border-radius: 6px; padding: .1rem .5rem; }
    .od-price { font-weight: 700; color: var(--c-dark, #6B4F3F); white-space: nowrap; align-self: flex-start; }

    .od-foot { display: flex; justify-content: space-between; align-items: center; gap: 1rem; flex-wrap: wrap; padding: .9rem 1.2rem 1.1rem; background: #FDFAF6; border-top: 1px solid var(--c-line, #EFE3D3); }
    .od-note { font-size: .82rem; color: #9A8B80; display: flex; align-items: center; gap: .4rem; }
    .od-total { text-align: right; }
    .od-total small { color: #85766B; font-size: .82rem; margin-right: .4rem; }
    .od-total strong { font-size: 1.25rem; color: var(--c-dark, #6B4F3F); }
    .od-actions { display: flex; gap: .6rem; flex-wrap: wrap; justify-content: flex-end; width: 100%; }
    .od-actions form { margin: 0; }
    .od-act { display: inline-flex; align-items: center; gap: .4rem; padding: .55rem 1.1rem; border-radius: 10px; font-weight: 700; font-size: .87rem; text-decoration: none; cursor: pointer; border: 1.5px solid var(--c-mid, #C9AF9A); background: #fff; color: var(--c-dark, #6B4F3F); transition: background .2s, color .2s; }
    .od-act:hover { background: var(--c-soft, #EDDECA); color: var(--c-dark, #6B4F3F); }
    .od-act.primary { background: var(--c-primary, #8B6F5B); border-color: var(--c-primary, #8B6F5B); color: #fff; }
    .od-act.primary:hover { background: var(--c-dark, #6B4F3F); color: #fff; }
    .od-act.danger { border-color: #E3A9A9; color: #B3402F; }
    .od-act.danger:hover { background: #FBEAEA; color: #B3402F; }

    .od-card.is-cancelled .od-thumb, .od-card.is-cancelled .od-name { opacity: .6; }
    .od-card.is-cancelled .od-thumb img { filter: grayscale(1); }

    .od-empty { background: #fff; border-radius: 16px; box-shadow: 0 2px 12px rgba(74, 59, 50, .07); text-align: center; padding: 3.2rem 1rem; color: #85766B; }
    .od-empty i { font-size: 3rem; color: var(--c-mid, #C9AF9A); display: block; margin-bottom: .6rem; }

    @media (max-width: 575.98px) {
        .od-body { align-items: flex-start; flex-wrap: wrap; }
        .od-thumb { width: 72px; height: 72px; }
        .od-price { width: 100%; }
        .od-total { width: 100%; text-align: left; }
        .od-actions { justify-content: stretch; }
        .od-actions .od-act, .od-actions form { flex: 1; }
        .od-actions .od-act { justify-content: center; width: 100%; }
    }
</style>
@endpush

@section('content')
@php
    $isAdmin = auth()->user()->isAdmin();

    $tabs = [
        '' => ['label' => 'Semua', 'icon' => 'bi-grid'],
        'pending' => ['label' => 'Menunggu', 'icon' => 'bi-clock'],
        'in_progress' => ['label' => 'Diproses', 'icon' => 'bi-hourglass-split'],
        'shipped' => ['label' => 'Dikirim', 'icon' => 'bi-truck'],
        'completed' => ['label' => 'Selesai', 'icon' => 'bi-check-circle'],
        'cancelled' => ['label' => 'Dibatalkan', 'icon' => 'bi-x-circle'],
    ];

    $statusMeta = [
        'pending' => ['label' => 'Menunggu', 'icon' => 'bi-clock', 'class' => 'od-st-pending'],
        'in_progress' => ['label' => 'Diproses', 'icon' => 'bi-hourglass-split', 'class' => 'od-st-progress'],
        'shipped' => ['label' => 'Dikirim', 'icon' => 'bi-truck', 'class' => 'od-st-shipped'],
        'completed' => ['label' => 'Selesai', 'icon' => 'bi-check-circle-fill', 'class' => 'od-st-done'],
        'cancelled' => ['label' => 'Dibatalkan', 'icon' => 'bi-x-circle-fill', 'class' => 'od-st-cancel'],
    ];

    // Jumlah pesanan per status (dikirim controller; kalau belum ada, angka tidak ditampilkan)
    $counts = $counts ?? null;
    $currentStatus = $status ?? '';
@endphp

<div class="od-head">
    <div>
        <h4><i class="bi bi-clipboard-check"></i>{{ $isAdmin ? 'Pesanan' : 'Pesanan Saya' }}</h4>
        <p class="text-muted small mb-0">{{ $isAdmin ? 'Kelola semua pesanan customer di sini' : 'Lihat dan pantau semua pesanan ilustrasi kamu di sini' }}</p>
    </div>
    @unless ($isAdmin)
        <a href="{{ route('orders.create') }}" class="od-btn-new"><i class="bi bi-plus-lg"></i>Buat Pesanan Baru</a>
    @endunless
</div>

{{-- Tab status --}}
<nav class="od-tabs" aria-label="Filter status pesanan">
    @foreach ($tabs as $value => $tab)
        @php $count = $counts === null ? null : ($value === '' ? $counts->sum() : ($counts[$value] ?? 0)); @endphp
        <a href="{{ route('orders.index', array_filter(['status' => $value, 'search' => $search ?? null])) }}"
           class="od-tab {{ $currentStatus === $value || ($value === '' && $currentStatus === 'all') ? 'active' : '' }}">
            <i class="bi {{ $tab['icon'] }}"></i>{{ $tab['label'] }}
            @if ($count !== null && $count > 0)
                <span class="od-count">{{ $count }}</span>
            @endif
        </a>
    @endforeach
</nav>

{{-- Pencarian --}}
<form method="GET" action="{{ route('orders.index') }}" class="od-search">
    <input type="hidden" name="status" value="{{ $currentStatus }}">
    <i class="bi bi-search"></i>
    <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari pesanan berdasarkan nama jasa...">
</form>

{{-- Daftar pesanan --}}
@forelse ($orders as $order)
    @php
        $meta = $statusMeta[$order->status] ?? ['label' => ucfirst(str_replace('_', ' ', $order->status)), 'icon' => 'bi-circle', 'class' => 'od-st-pending'];
        $service = $order->servicePrice;
        $code = '#ORD-' . $order->created_at->format('Ymd') . '-' . str_pad($order->id, 3, '0', STR_PAD_LEFT);
    @endphp
    <div class="od-card {{ $order->status === 'cancelled' ? 'is-cancelled' : '' }}">
        <div class="od-card-head">
            <div class="od-meta">
                @if ($isAdmin)
                    <span class="od-avatar">{{ strtoupper(mb_substr($order->user->name, 0, 1)) }}</span>
                    <strong>{{ $order->user->name }}</strong>
                    <span class="od-dot"></span>
                @endif
                <strong>{{ $code }}</strong>
                <span class="od-dot"></span>
                <span>{{ $order->created_at->copy()->timezone('Asia/Jakarta')->locale('id')->translatedFormat('j F Y • H:i') }}</span>
            </div>
            <span class="od-status {{ $meta['class'] }}"><i class="bi {{ $meta['icon'] }}"></i>{{ $meta['label'] }}</span>
        </div>

        <a href="{{ route('orders.show', $order) }}" class="od-body">
            <div class="od-thumb">
                @if ($service?->image)
                    <img src="{{ Storage::url($service->image) }}" alt="{{ $service->name }}">
                @else
                    <div class="ph"><i class="bi bi-image"></i></div>
                @endif
            </div>
            <div class="od-info">
                <h6 class="od-name">{{ $service?->name ?? 'Layanan dihapus' }}</h6>
                <p class="od-desc">{{ $order->description }}</p>
                <span class="od-tag"><i class="bi bi-cash-coin"></i>COD (bayar di tempat)</span>
            </div>
            <div class="od-price">Rp{{ number_format($order->total_price, 0, ',', '.') }}</div>
        </a>

        <div class="od-foot">
            <div class="od-note">
                @if ($order->status === 'shipped' && $order->shipped_at)
                    <i class="bi bi-truck"></i>Dikirim {{ \Illuminate\Support\Carbon::parse($order->shipped_at)->copy()->timezone('Asia/Jakarta')->locale('id')->translatedFormat('j F Y') }}
                @elseif ($order->status === 'pending')
                    <i class="bi bi-info-circle"></i>Menunggu konfirmasi dari kami
                @elseif ($order->status === 'in_progress')
                    <i class="bi bi-hourglass-split"></i>Pesananmu sedang dikerjakan
                @elseif ($order->status === 'cancelled')
                    <i class="bi bi-x-circle"></i>Dibatalkan{{ $order->cancel_reason ? ': ' . \Illuminate\Support\Str::limit($order->cancel_reason, 45) : '' }}
                @endif
            </div>
            <div class="od-total">
                <small>Total Pesanan:</small><strong>Rp{{ number_format($order->total_price, 0, ',', '.') }}</strong>
            </div>

            <div class="od-actions">
                @if (!$isAdmin && $order->status === 'completed')
                    <a href="{{ route('reviews.create', $order) }}" class="od-act primary"><i class="bi bi-star"></i>Beri Ulasan</a>
                @endif

                @if (!$isAdmin && in_array($order->status, ['pending', 'in_progress'], true))
                    <a href="{{ route('orders.cancel.form', $order) }}" class="od-act danger"><i class="bi bi-x-circle"></i>Batalkan Pesanan</a>
                @endif

                @if ($isAdmin)
                    <a href="{{ route('orders.edit', $order) }}" class="od-act"><i class="bi bi-pencil-square"></i>Ubah Status</a>
                @endif

                <a href="{{ route('orders.show', $order) }}" class="od-act {{ ($isAdmin || $order->status !== 'completed') ? 'primary' : '' }}"><i class="bi bi-eye"></i>Lihat Detail</a>
            </div>
        </div>
    </div>
@empty
    <div class="od-empty">
        <i class="bi bi-bag-heart"></i>
        <p class="mb-3">{{ ($search ?? null) || $currentStatus ? 'Tidak ada pesanan yang cocok dengan filter ini.' : 'Belum ada pesanan.' }}</p>
        @unless ($isAdmin)
            <a href="{{ route('orders.create') }}" class="od-btn-new"><i class="bi bi-plus-lg"></i>Pesan Sekarang</a>
        @endunless
    </div>
@endforelse

<div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mt-3">
    <span class="small text-muted">Menampilkan {{ $orders->count() }} dari {{ $orders->total() }} pesanan</span>
    {{ $orders->links('pagination::bootstrap-5') }}
</div>
@endsection