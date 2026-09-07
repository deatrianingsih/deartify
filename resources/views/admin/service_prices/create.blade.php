@extends('layouts.dashboard')

@section('content')
<h4 class="fw-semibold mb-4">Tambah Harga Layanan</h4>

<div class="card border-0 shadow-sm p-4" style="border-radius: 16px; max-width: 500px;">
    <form action="{{ route('service_prices.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="mb-3">
         <label class="form-label">Gambar Jasa</label>
         <input type="file" name="image" class="form-control @error('image') is-invalid @enderror">
         @error('image')
             <div class="invalid-feedback">{{ $message }}</div>
         @enderror
    </div>
    <div class="mb-3">
        <label class="form-label">Nama Jasa</label>
        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="mb-3">
        <label class="form-label">Deskripsi</label>
        <textarea name="description" class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
        @error('description')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="mb-3">
        <label class="form-label">Harga</label>
        <input type="number" name="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price') }}" step="0.01">
        @error('price')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <button type="submit" class="btn text-white" style="background-color: #8B6F5B">Simpan</button>
    <a href="{{ route('service_prices.index') }}" class="btn btn-outline-secondary">Batal</a>
</form>
</div>
@endsection