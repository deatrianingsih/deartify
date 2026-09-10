@extends('layouts.dashboard')

@section('content')
<h4 class="fw-semibold mb-4">Profil Saya</h4>

<div class="card border-0 shadow-sm p-4" Style="border-radius: 16px; max-width: 500px;">
    <div class="text-center mb-4">
        <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-semibold mx-auto"
            style="width: 72px; height: 72px; background-color: #8B6F5B; font-size: 1.75rem;">
            {{ strtoupper(substr($user->name, 0, 1)) }}
        </div>
    </div>

    <table class="table table-borderless mb-4">
        <tr>
            <th width="140" class="text-muted fw-normal">Nama</th>
            <td>:{{ $user->name }}</td>
        </tr>
        <tr>
            <th class="text-muted fw-normal">Email</th>
            <td>:{{ $user->email }}</td>
        </tr>
        <tr>
            <th class="text-muted fw-normal">No. Telepon</th>
            <td>: {{ $user->phone ?? '-' }}</td>
        </tr>
        <tr>
            <th class="text-muted fw-normal">Alamat</th>
            <td>:{{ $user->address ?? '-' }}</td>
        </tr>
    </table>

    <div class="d-grid gap-2">
        <a href="{{ route('profile.edit') }}" class="btn text-white" style="background-color: #8B6F5B;">Edit Profil</a>
        <a href="{{ route('profile.password.edit') }}" class="btn btn-outline-secondary">Ubah Password</a>
    </div>
</div>
@endsection