@extends('layouts.dashboard')

@section('content')
<div style="max-width: 1100px; margin: 0 auto;">
    <a href="{{ route('admin.products.index') }}" style="display:inline-flex;align-items:center;gap:.4rem;color:#8B6F5B;font-weight:800;text-decoration:none;margin-bottom:.8rem;"><i class="bi bi-arrow-left"></i>Kembali ke Produk</a>
    <h3 style="margin:0 0 .2rem;font-weight:800;color:#4A3B32;"><i class="bi bi-plus-circle" style="color:#8B6F5B;"></i> Tambah Produk</h3>
    <p style="margin:0 0 1.3rem;color:#85766B;">Isi data produk, lalu simpan agar tampil di halaman Layanan & Harga.</p>

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @include('admin.products._form', ['submit' => 'Simpan Produk'])
    </form>
</div>
@endsection