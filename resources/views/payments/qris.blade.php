@extends('layouts.dashboard')

@section('content')
<div class="mb-4">
    <h4 class="fw-semibold mb-1"><i class="bi bi-qr-code me-2" style="color: #8B6F5B;"></i>QRIS Pembayaran</h4>
    <p class="text-muted small mb-0">QR dan nomor DANA ini tampil ke customer yang memilih pembayaran QRIS</p>
</div>

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<form action="{{ route('payments.qris.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="row g-3">
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm p-4" style="border-radius: 16px;">
                <div class="mb-3">
                    <label class="form-label fw-semibold">Nomor DANA</label>
                    <input type="text" name="dana_number" value="{{ old('dana_number', $qris->dana_number) }}" class="form-control @error('dana_number') is-invalid @enderror" placeholder="08xxxxxxxxxx">
                    @error('dana_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Atas Nama</label>
                    <input type="text" name="account_name" value="{{ old('account_name', $qris->account_name) }}" class="form-control @error('account_name') is-invalid @enderror">
                    @error('account_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Catatan untuk Customer <span class="text-muted fw-normal">(opsional)</span></label>
                    <textarea name="note" rows="3" class="form-control @error('note') is-invalid @enderror" placeholder="Contoh: Pastikan nominal sesuai total pesanan.">{{ old('note', $qris->note) }}</textarea>
                    @error('note') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="mb-4">
                    <label class="form-label fw-semibold">Gambar QRIS</label>
                    <input type="file" name="image" accept="image/*" class="form-control @error('image') is-invalid @enderror">
                    <div class="form-text">Screenshot/unduh QRIS dari aplikasi DANA kamu. Maksimal 4 MB.</div>
                    @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn text-white" style="background-color: #8B6F5B;"><i class="bi bi-check-lg"></i> Simpan</button>
                    <a href="{{ route('payments.index') }}" class="btn btn-outline-secondary">Kembali</a>
                </div>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm p-4 text-center" style="border-radius: 16px;">
                <h6 class="text-start mb-3">QRIS Saat Ini</h6>
                @if ($qris->image)
                    <img src="{{ Storage::url($qris->image) }}" class="rounded-3 mx-auto" style="max-width: 260px; width: 100%;" alt="QRIS">
                @else
                    <div class="text-muted py-5" style="background-color: #F5EAD8; border-radius: 12px;">Belum ada QRIS.<br>Pilihan QRIS belum tampil di form pesanan.</div>
                @endif
            </div>
        </div>
    </div>
</form>
@endsection