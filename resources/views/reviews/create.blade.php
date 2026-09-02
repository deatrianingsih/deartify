@extends('layouts.dashboard')

@section('content')
    <h4 class="fw-semibold mb-4">Beri Ulasan untuk Pesann #{{ $order->id }}</h4>

    <div class="card border-0 shadow-sm p-4" style="border-radius: 16px; max-width: 500px;">
    <form action="{{ route('reviews.store', $order) }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Rating</label>
            <select name="rating" class="form-select @error('rating') is-invalid @enderror">
                @for ($i = 5; $i >= 1; $i--)
                <option value="{{ $i }}">{{ $i }} {{ "\u{2B50}" }}</option>
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