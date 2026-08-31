@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-3">Beri Ulasan untuk Pesann #{{ $order->id }}</h4>

    <form action="{{ route('reviews.store', $order) }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Rating</label>
            <select name="rating" class="form-select @error('rating') is-invalid @enderror">
                @for ($i = 5; $i >= 1; $i--)
                <option value="{{ $i }}">{{ $i }} {{ "\u{2B50}" }}</option>
                @endfor
            </select>
            @error('rating') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Komentar</label>
            <textarea name="comment" class="form-control @error('comment') is-invalid @enderror">{{ old('comment') }}</textarea>
            @error('comment') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <button type="submit" class="btn btn-primary">Kirim Ulasan</button>
        <a href="{{ route('orders.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection