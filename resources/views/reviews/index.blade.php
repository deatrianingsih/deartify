@extends('layouts.dashboard')

@push('styles')
<style>
   .rv-wrap {
    max-width: 1100px;
    margin: 0 auto;
}

.rv-head {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    gap: 1rem;
    flex-wrap: wrap;
    margin-bottom: 1.3rem;
}

.rv-head h3 {
    margin: 0 0 .2rem;
    font-weight: 800;
    color: var(--c-text, #4A3B32);
    display: flex;
    align-items: center;
    gap: .6rem;
}

.rv-head h3 i {
    color: #E0A21B;
}

.rv-head p {
    margin: 0;
    color: #85766B;
}

.rv-stats {
    display: flex;
    gap: .8rem;
    flex-wrap: wrap;
}

.rv-stat {
    background: #fff;
    border: 1px solid var(--c-line, #EFE3D3);
    border-radius: 16px;
    padding: .7rem 1.2rem;
    box-shadow: 0 2px 12px rgba(74, 59, 50, .06);
    text-align: center;
    min-width: 110px;
}

.rv-stat strong {
    display: block;
    font-size: 1.4rem;
    color: var(--c-dark, #6B4F3F);
    line-height: 1.2;
}

.rv-stat strong i {
    color: #E0A21B;
    font-size: 1.1rem;
}

.rv-stat small {
    color: #85766B;
    font-weight: 600;
}

.rv-card {
    background: #fff;
    border: 1px solid var(--c-line, #EFE3D3);
    border-radius: 20px;
    box-shadow: 0 2px 12px rgba(74, 59, 50, .06);
    padding: 1.2rem 1.4rem;
    margin-bottom: 1rem;
    display: flex;
    gap: 1.1rem;
    transition: transform .2s, box-shadow .2s;
}

.rv-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 26px rgba(74, 59, 50, .13);
}

.rv-ava {
    flex: 0 0 auto;
    width: 48px;
    height: 48px;
    border-radius: 50%;
    background: var(--c-primary, #8B6F5B);
    color: #fff;
    font-weight: 800;
    font-size: 1.15rem;
    display: flex;
    align-items: center;
    justify-content: center;
}

.rv-main {
    flex: 1;
    min-width: 0;
}

.rv-top {
    display: flex;
    justify-content: space-between;
    gap: .8rem;
    flex-wrap: wrap;
    align-items: center;
}

.rv-name {
    font-weight: 800;
    color: var(--c-text, #4A3B32);
}

.rv-date {
    color: #9A8B80;
    font-size: .82rem;
}

.rv-stars {
    color: #E0A21B;
    letter-spacing: 2px;
    font-size: 1rem;
    margin: .15rem 0 .45rem;
}

.rv-stars .off {
    color: #E3D6C6;
}

.rv-service {
    display: inline-flex;
    align-items: center;
    gap: .4rem;
    background: var(--c-tint, #F5EAD8);
    color: var(--c-dark, #6B4F3F);
    font-weight: 700;
    font-size: .82rem;
    padding: .25rem .8rem;
    border-radius: 999px;
}

.rv-comment {
    margin: .7rem 0 0;
    color: #5C4E44;
    line-height: 1.55;
    background: #FDFAF6;
    border-left: 3px solid var(--c-mid, #C9AF9A);
    border-radius: 0 12px 12px 0;
    padding: .65rem .9rem;
    word-break: break-word;
}

.rv-comment.empty {
    color: #9A8B80;
    font-style: italic;
}

.rv-empty {
    text-align: center;
    background: #fff;
    border-radius: 20px;
    padding: 3rem 1rem;
    color: #85766B;
    box-shadow: 0 2px 12px rgba(74, 59, 50, .07);
}

.rv-empty i {
    font-size: 3rem;
    color: var(--c-mid, #C9AF9A);
    display: block;
    margin-bottom: .5rem;
}

.rv-empty a {
    display: inline-block;
    margin-top: .9rem;
    background: var(--c-primary, #8B6F5B);
    color: #fff;
    font-weight: 800;
    padding: .65rem 1.3rem;
    border-radius: 12px;
    text-decoration: none;
}

.rv-empty a:hover {
    background: var(--c-dark, #6B4F3F);
}

@media (max-width: 575.98px) {
    .rv-card {
        padding: 1rem;
        gap: .8rem;
    }

    .rv-ava {
        width: 40px;
        height: 40px;
    }
}
</style>
@endpush

@section('content')
@php
    $items = $reviews instanceof \Illuminate\Pagination\AbstractPaginator ? $reviews->getCollection() : collect($reviews);
    $total = $reviews instanceof \Illuminate\Pagination\AbstractPaginator ? $reviews->total() : $items->count();
    $avg = $items->count() ? round($items->avg('rating'), 1) : 0;
    $isAdmin = auth()->user()->isAdmin();
@endphp

<div class="rv-wrap">
    <div class="rv-head">
        <div>
            <h3><i class="bi bi-star-fill"></i>{{ $isAdmin ? 'Ulasan Customer' : 'Ulasan Saya' }}</h3>
            <p>{{ $isAdmin ? 'Semua ulasan yang diberikan customer.' : 'Riwayat ulasan yang sudah kamu berikan.' }}</p>
        </div>
        @if ($total > 0)
            <div class="rv-stats">
                <div class="rv-stat"><strong>{{ $total }}</strong><small>Ulasan</small></div>
                <div class="rv-stat"><strong><i class="bi bi-star-fill"></i> {{ number_format($avg, 1) }}</strong><small>Rata-rata</small></div>
            </div>
        @endif
    </div>

    @forelse ($items as $review)
        @php
            $name = $review->user->name ?? 'Customer';
            $service = $review->order->servicePrice->name ?? $review->servicePrice->name ?? '-';
            $rating = (int) $review->rating;
        @endphp
        <div class="rv-card">
            <div class="rv-ava">{{ strtoupper(mb_substr($name, 0, 1)) }}</div>
            <div class="rv-main">
                <div class="rv-top">
                    <span class="rv-name">{{ $name }}</span>
                    <span class="rv-date">{{ optional($review->created_at)->format('d M Y') }}</span>
                </div>
                <div class="rv-stars" aria-label="Rating {{ $rating }} dari 5">
                    @for ($i = 1; $i <= 5; $i++)
                        <i class="bi bi-star-fill {{ $i <= $rating ? '' : 'off' }}"></i>
                    @endfor
                </div>
                <span class="rv-service"><i class="bi bi-palette"></i>{{ $service }}</span>
                @if ($review->comment)
                    <p class="rv-comment">{{ $review->comment }}</p>
                @else
                    <p class="rv-comment empty">Tidak ada komentar.</p>
                @endif
            </div>
        </div>
    @empty
        <div class="rv-empty">
            <i class="bi bi-chat-heart"></i>
            Belum ada ulasan.
            @unless ($isAdmin)
                <br><a href="{{ route('orders.index') }}">Lihat Pesanan Saya</a>
            @endunless
        </div>
    @endforelse

    @if ($reviews instanceof \Illuminate\Pagination\AbstractPaginator)
        <div class="mt-4">{{ $reviews->links('pagination::bootstrap-5') }}</div>
    @endif
</div>
@endsection