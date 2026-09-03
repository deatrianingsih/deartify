@extends('layouts.dashboard')

@section('content')
<h4 class="fw-semibold mb-4">Profil Saya</h4>

<div class="card border-0 shadow-sm p-4 mb-4" style="border-radius: 16px; max-width: 500px;">
    <h6 class="mb-3">Informasi Akun</h6> 

    @if ($errors->updateProfile ?? false)
        <div class="alert alert-danger">Terjadi kesalahan, cek kembali data kamu.</div>
    @endif

    <form action="{{ route('profile.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Nama Lengkap</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control @error('name') is-invalid @enderror">
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control @error('email') is-invalid @enderror">
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">No. Telepon</label>
            <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="form-control @error('phone') is-invalid @enderror">
            @error('phone')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror   
        </div>

        <button type="submit" class="btn text-white" style="background-color: #8B6F5B;">Simpan Perubahan</button>
    </form>
</div>

<div class="card border-0 shadow-sm p-4" style="border-radius: 16px; max-width: 500px;">
    <h6 class="mb-3">Ubah Password</h6>

    <form action="{{ route('profile.password') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Password Saat Ini</label>
            <input type="password" name="current_password" class="form-control @error('current_password') is-invalid @enderror">
            @error('current_password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Password Baru</label>
            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Konfirmasi Password Baru</label>
            <input type="password" name="password_confirmation" class="form-control">
        </div>

        <button type="submit" class="btn text-white" style="background-color: #8B6F5B;">Ubah Password</button>
    </form>
</div>
@endsection