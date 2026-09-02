@extends('layouts.dashboard')

@section('content')
<div class="container">
    <h4 class="fw-semibold mb-4">Buat Pesanan Baru</h4>

    <div class="card border-0 shadow-sm p-4" style="border-radius: 16px; max-width: 600px;">
    <form action="{{ route('orders.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label class="form-label">Jenis Jasa</label>
            <select name="service_price_id" class="form-select @error('service_price_id') is-invalid @enderror">
                <option value="">-- Pilih Jasa --</option>
                @foreach ($servicePrices as $sp)
                    <option value="{{ $sp->id }}" @selected(old('service_price_id') == $sp->id)>
                        {{ $sp->name }} — Rp{{ number_format($sp->price, 0, ',', '.') }}
                    </option>
                @endforeach
            </select>
            @error('service_price_id') 
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Deskripsi Pesanan</label>
            <textarea name="description" class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
            @error('description') 
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Gambar Referensi (opsional)</label>
            <input type="file" name="reference_image" class="form-control @error('reference_image') is-invalid @enderror">
            @error('reference_image') 
                <div class="invalid-feedback">{{ $message }}</div> 
            @enderror
        </div>

        <hr>
        <h6>Data Penerima</h6>

        <div class="mb-3">
            <label class="form-label">Nama Penerima</label>
            <input type="text" name="recipient_name" value="{{ old('recipient_name') }}" class="form-control @error('recipient_name') is-invalid @enderror">
            @error('recipient_name') 
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Nomor Telepon Penerima</label>
            <input type="text" name="recipient_phone" value="{{ old('recipient_phone') }}" class="form-control @error('recipient_phone') is-invalid @enderror">
            @error('recipient_phone') 
            <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Alamat Pengiriman</label>
            <textarea name="shipping_address" class="form-control @error('shipping_address') is-invalid @enderror">{{ old('shipping_address') }}</textarea>
            @error('shipping_address') 
                <div class="invalid-feedback">{{ $message }}</div> 
            @enderror
        </div>

        <button type="submit" class="btn text-white" style="background-color: #8B6F5B;">Kirim Pesanan</button>
        <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary">Batal</a>
    </form>
</div>
@endsection