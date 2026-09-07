@extends('layouts.dashboard')

@section('content')
<h4 class="fw-semibold mb-4">Edit Harga Jasa</h4>

<div class="card border-0 shadow-sm p-4" style="border-radius: 16px; max-width: 500px">
    @if ($servicePrice->image)
        <img src="{{ Storage::url($servicePrice->image) }}" class="rounded mb-3" width="150">
    @endif

    <form action="{{ route('service_prices.update', $servicePrice) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Ganti Gambar (opsional)</label>
            <input type="file" name="image" class="form-control @error('image') is-invalid @enderror">
            @error('image')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="mb-3">
            <label class="form-label">Nama Jasa</label>
            <input type="text" name="name" value="{{ old('name', $servicePrice->name) }}" class="form-control @error('name') is-invalid @enderror">
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Deskripsi</label>
            <textarea name="description" class="form-control @error('description') is-invalid @enderror">{{ old('description', $servicePrice->description) }}</textarea>
            @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Harga</label>
            <input type="number" step="0.01" name="price" value="{{ old('price', $servicePrice->price) }}" class="form-control @error('price') is-invalid @enderror">
            @error('price')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn text-white" style="background-color: #8B6F5B;">Update</button>
        <a href="{{ route('service_prices.index') }}" class="btn btn-outline-secondary">Batal</a>
    </form>
</div>
@endsection