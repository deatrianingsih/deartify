@extends('layouts.dashboard')

@push('styles')
<style>
   .rv-wrap {
    max-width: 1020px;
    margin: 1rem auto 2rem;
}

.rv-card {
    background: #fff;
    border-radius: 20px;
    box-shadow: 0 8px 30px rgba(74, 59, 50, .08);
    padding: 2.2rem 2.4rem;
}

.rv-title {
    text-align: center;
    font-weight: 800;
    font-size: 2.1rem;
    color: var(--c-text, #4A3B32);
    margin: 0;
}

.rv-sub {
    text-align: center;
    color: #85766B;
    margin: .25rem 0 1.6rem;
}

.rv-order {
    display: flex;
    align-items: center;
    gap: 1rem;
    background: var(--c-tint, #F5EAD8);
    border-radius: 14px;
    padding: .8rem 1rem;
}

.rv-thumb {
    width: 74px;
    height: 74px;
    border-radius: 12px;
    overflow: hidden;
    background: var(--c-soft, #EDDECA);
    flex-shrink: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--c-mid, #C9AF9A);
    font-size: 1.6rem;
}

.rv-thumb img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.rv-order h6 {
    margin: 0 0 .15rem;
    font-weight: 800;
    font-size: 1.08rem;
    color: var(--c-text, #4A3B32);
}

.rv-order small {
    color: #85766B;
    font-size: .95rem;
}

.rv-hr {
    border: 0;
    border-top: 1px solid var(--c-line, #EFE3D3);
    margin: 1.4rem 0;
}

.rv-label {
    font-weight: 800;
    font-size: 1.05rem;
    color: var(--c-text, #4A3B32);
    margin-bottom: .6rem;
    display: block;
}

.rv-label span {
    color: #C0392B;
}

/* Bintang: radio tersembunyi, bintang menyala sampai yang dipilih */
.rv-stars {
    display: flex;
    justify-content: center;
    gap: 2.2rem;
    flex-wrap: wrap;
    margin-bottom: 1.4rem;
}

.rv-star {
    text-align: center;
    cursor: pointer;
    width: 110px;
}

.rv-star input {
    position: absolute;
    opacity: 0;
    pointer-events: none;
}

.rv-star i {
    display: block;
    font-size: 2.4rem;
    line-height: 1;
    color: #E6D8C6;
    transition: color .15s, transform .15s;
}

.rv-star span {
    display: block;
    margin-top: .45rem;
    font-size: .92rem;
    color: #6F6258;
}

.rv-star.on i {
    color: #F0B33C;
}

.rv-star:hover i {
    transform: scale(1.12);
}

.rv-star input:focus-visible ~ i {
    outline: 2px solid var(--c-primary, #8B6F5B);
    outline-offset: 4px;
    border-radius: 6px;
}

.rv-star.on span {
    color: var(--c-dark, #6B4F3F);
    font-weight: 700;
}

.rv-text {
    width: 100%;
    min-height: 130px;
    border: 1.5px solid var(--c-line, #EFE3D3);
    border-radius: 12px;
    padding: .85rem 1rem;
    font-size: .98rem;
    resize: vertical;
    background: #fff;
}

.rv-text:focus {
    outline: none;
    border-color: var(--c-primary, #8B6F5B);
    box-shadow: 0 0 0 .2rem rgba(139, 111, 91, .15);
}

.rv-count {
    text-align: right;
    color: #85766B;
    font-size: .88rem;
    margin-top: .3rem;
}

.rv-actions {
    display: flex;
    justify-content: center;
    gap: .9rem;
    margin-top: 1.4rem;
    flex-wrap: wrap;
}

.rv-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: .5rem;
    min-width: 190px;
    padding: .8rem 1.6rem;
    border-radius: 10px;
    font-weight: 800;
    font-size: 1rem;
    text-decoration: none;
    cursor: pointer;
    border: 1.5px solid var(--c-primary, #8B6F5B);
    transition: *background* .2s;
}

.rv-btn.primary {
    background: var(--c-primary, #8B6F5B);
    color: #fff;
}

.rv-btn.primary:hover {
    background: var(--c-dark, #6B4F3F);
    color: #fff;
}

.rv-btn.ghost {
    background: #fff;
    color: var(--c-dark, #6B4F3F);
    border-color: var(--c-mid, #C9AF9A);
    min-width: 150px;
}

.rv-btn.ghost:hover {
    background: var(--c-tint, #F5EAD8);
    color: var(--c-dark, #6B4F3F);
}

.rv-err {
    color: #B3402F;
    font-size: .88rem;
    margin-top: .3rem;
}

@media (max-width: 575.98px) {
    .rv-card {
        padding: 1.4rem 1.1rem;
    }

    .rv-title {
        font-size: 1.7rem;
    }

    .rv-stars {
        gap: .6rem;
    }

    .rv-star {
        width: 62px;
    }

    .rv-star i {
        font-size: 1.9rem;
    }

    .rv-star span {
        font-size: .72rem;
    }

    .rv-btn {
        width: 100%;
    }
}
</style>
@endpush

@section('content')
@php
    $labels = [1 => 'Sangat buruk', 2 => 'Buruk', 3 => 'Cukup', 4 => 'Baik', 5 => 'Sangat baik'];
    $current = (int) old('rating', 0);
    $service = $order->servicePrice;
@endphp

<div class="rv-wrap">
    <div class="rv-card">
        <h1 class="rv-title">Beri Ulasan</h1>
        <p class="rv-sub">Pendapat kamu sangat berarti bagi kami</p>

        <div class="rv-order">
            <div class="rv-thumb">
                @if ($service?->image)
                    <img src="{{ Storage::url($service->image) }}" alt="{{ $service->name }}">
                @else
                    <i class="bi bi-image"></i>
                @endif
            </div>
            <div>
                <h6>{{ $service?->name ?? 'Layanan' }}</h6>
                <small>Pesanan #{{ $order->id }} · Rp{{ number_format($order->total_price, 0, ',', '.') }}</small>
            </div>
        </div>

        <hr class="rv-hr">

        <form action="{{ route('reviews.store', $order) }}" method="POST" id="rvForm">
            @csrf

            <label class="rv-label">Rating <span>*</span></label>
            <div class="rv-stars" id="rvStars">
                @foreach ($labels as $value => $text)
                    <label class="rv-star {{ $value <= $current ? 'on' : '' }}" data-value="{{ $value }}">
                        <input type="radio" name="rating" value="{{ $value }}" {{ $current === $value ? 'checked' : '' }} required>
                        <i class="bi bi-star-fill"></i>
                        <span>{{ $text }}</span>
                    </label>
                @endforeach
            </div>
            @error('rating') <div class="rv-err text-center">{{ $message }}</div> @enderror

            <label class="rv-label" for="rvComment">Komentar <span>*</span></label>
            <textarea id="rvComment" name="comment" class="rv-text" maxlength="500" required
                      placeholder="Ceritakan pengalaman kamu dengan layanan ini...">{{ old('comment') }}</textarea>
            <div class="rv-count"><span id="rvCount">{{ mb_strlen(old('comment', '')) }}</span>/500</div>
            @error('comment') <div class="rv-err">{{ $message }}</div> @enderror

            <div class="rv-actions">
                <button type="submit" class="rv-btn primary"><i class="bi bi-send-fill"></i>Kirim Ulasan</button>
                <a href="{{ route('orders.index') }}" class="rv-btn ghost">Batal</a>
            </div>
        </form>
    </div>
</div>

<script>
    (function () {
        var stars = document.querySelectorAll('#rvStars .rv-star');
        function paint(n) {
            stars.forEach(function (s) { s.classList.toggle('on', parseInt(s.dataset.value, 10) <= n); });
        }
        function selected() {
            var c = document.querySelector('#rvStars input:checked');
            return c ? parseInt(c.value, 10) : 0;
        }
        stars.forEach(function (s) {
            s.addEventListener('mouseenter', function () { paint(parseInt(s.dataset.value, 10)); });
            s.addEventListener('click', function () { setTimeout(function () { paint(selected()); }, 0); });
        });
        document.getElementById('rvStars').addEventListener('mouseleave', function () { paint(selected()); });

        var box = document.getElementById('rvComment'), count = document.getElementById('rvCount');
        box.addEventListener('input', function () { count.textContent = box.value.length; });
    })();
</script>
@endsection