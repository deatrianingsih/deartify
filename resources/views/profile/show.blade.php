@extends('layouts.dashboard')

@section('content')
<div class="mb-4">
    <h4 class="fw-semibold mb-1">Profil Saya</h4>
    <p class="text-muted small mb-0">Kelola informasi akun dan keamanan akun Anda.</p>
</div>

<div class="card border-0 shadow-sm p-4" style="border-radius: 16px; max-width: 700px;">
    <div class="row align-items-center">
        <div class="col-md-3 text-center border-end">
            <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-semibold mx-auto mb-3"
                 style="width: 96px; height: 96px; background-color: #8B6F5B; font-size: 2.25rem;">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
            <div class="fw-semibold fs-5">{{ $user->name }}</div>
            <div class="text-muted small"><i class="bi bi-envelope me-1"></i>{{ $user->email }}</div>
            <div class="text-muted small"><i class="bi bi-telephone me-1"></i>{{ $user->phone ?? '-' }}</div>
        </div>

        <div class="col-md-9">
            <div class="d-flex align-items-center gap-3 py-2 border-bottom">
                <i class="bi bi-person-fill fs-5" style="color: #8B6F5B;"></i>
                <span class="text-muted" style="width: 100px;">Nama</span>
                <span>: {{ $user->name }}</span>
            </div>
            <div class="d-flex align-items-center gap-3 py-2 border-bottom">
                <i class="bi bi-envelope-fill fs-5" style="color: #8B6F5B;"></i>
                <span class="text-muted" style="width: 100px;">Email</span>
                <span>: {{ $user->email }}</span>
            </div>
            <div class="d-flex align-items-center gap-3 py-2 border-bottom">
                <i class="bi bi-telephone-fill fs-5" style="color: #8B6F5B;"></i>
                <span class="text-muted" style="width: 100px;">No. Telepon</span>
                <span>: {{ $user->phone ?? '-' }}</span>
            </div>
            <div class="d-flex align-items-center gap-3 py-2 mb-3">
                <i class="bi bi-geo-alt-fill fs-5" style="color: #8B6F5B;"></i>
                <span class="text-muted" style="width: 100px;">Alamat</span>
                <span>: {{ $user->address ?? '-' }}</span>
            </div>

            <div class="d-flex gap-2">
                <a href="{{ route('profile.edit') }}" class="btn text-white" style="background-color: #8B6F5B;">
                    <i class="bi bi-pencil-square me-1"></i>Edit Profil
                </a>
                <a href="{{ route('profile.password.edit') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-lock-fill me-1"></i>Ubah Password
                </a>
            </div>
        </div>
    </div>
</div>
@endsection