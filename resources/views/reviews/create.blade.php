@extends('layouts.dashboard')

@section('content')
<h4 class="fw-semibold mb-4">Beri Ulasan</h4>

<div class="card border-0 shadow-sm p-4" style="border-radius: 16px; max-width: 500px;">
    <div class="d-flex align-items-center gap-3 mb-4 pb-3 border-bottom">
        @if ($order->reference_image)
            <img src="{{ Storage::url($order->reference_image) }}" class="rounded-circle" width="56" height="56" style="object-fit: cover;">
        @else
            <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 56px; height: 56px; background-color: #F5EAD8;"></div>
        @endif
        <div>
            <div class="fw-medium">{{ $order->servicePrice->name }}</div>
            <div class="small text-muted">Pesanan #{{ $order->id }} - Rp{{ number_format($order->total_price, 0, ',', '.') }}</div>
        </div>
    </div>

    <form action="{{ route('reviews.store', $order) }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Rating</label>
            <select name="rating" class="form-select @error('rating') is-invalid @enderror">
                @for ($i = 5; $i >= 1; $i--)
                    <option value="{{ $i }}">{{ $i }} ★</option>
                @endfor
            </select>
            @error('rating')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Komentar</label>
            <textarea name="comment" class="form-control @error('comment') is-invalid @enderror">{{ old('comment') }}</textarea>
            @error('comment')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn text-white" style="background-color: #8B6F5B">Kirim Ulasan</button>
        <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary">Batal</a>
    </form>
</div>
@endsection