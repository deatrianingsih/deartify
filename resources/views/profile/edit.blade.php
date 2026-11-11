@extends('layouts.dashboard')

@push('styles')
<style>
    .pf-wrap { max-width: 1060px; margin: 0 auto; }
    .pf-head { margin-bottom: 1.3rem; }
    .pf-head h3 { margin: 0 0 .15rem; font-weight: 800; color: var(--c-text, #4A3B32); display: flex; align-items: center; gap: .6rem; }
    .pf-head h3 i { color: var(--c-primary, #8B6F5B); }
    .pf-head p { margin: 0; color: #85766B; }

    .pf-card { background: #fff; border-radius: 20px; box-shadow: 0 2px 14px rgba(74, 59, 50, .08); overflow: hidden; }

    /* Kartu profil kiri */
    .pf-side-top { background: linear-gradient(135deg, var(--c-primary, #8B6F5B), var(--c-dark, #6B4F3F)); padding: 2rem 1.5rem 3.6rem; text-align: center; color: #fff; }
    .pf-side-top h5 { margin: .8rem 0 .1rem; font-weight: 800; }
    .pf-side-top small { opacity: .85; word-break: break-all; }
    .pf-avatar { width: 92px; height: 92px; border-radius: 50%; margin: 0 auto; background: #fff; color: var(--c-primary, #8B6F5B); font-size: 2.4rem; font-weight: 800; display: flex; align-items: center; justify-content: center; border: 4px solid rgba(255, 255, 255, .45); box-shadow: 0 8px 22px rgba(0, 0, 0, .18); }
    .pf-role { display: inline-block; margin-top: .6rem; background: rgba(255, 255, 255, .2); border-radius: 999px; padding: .2rem .8rem; font-size: .76rem; font-weight: 800; letter-spacing: .05em; text-transform: uppercase; }
    .pf-stats { display: flex; margin: -2.2rem 1.1rem 0; background: #fff; border-radius: 16px; box-shadow: 0 6px 20px rgba(74, 59, 50, .12); position: relative; }
    .pf-stat { flex: 1; text-align: center; padding: .9rem .4rem; }
    .pf-stat + .pf-stat { border-left: 1px solid var(--c-line, #EFE3D3); }
    .pf-stat strong { display: block; font-size: 1.25rem; color: var(--c-dark, #6B4F3F); }
    .pf-stat span { font-size: .78rem; color: #85766B; }
    .pf-links { padding: 1.1rem 1.1rem 1.3rem; display: flex; flex-direction: column; gap: .35rem; }
    .pf-link { display: flex; align-items: center; gap: .75rem; padding: .7rem .8rem; border-radius: 12px; color: var(--c-text, #4A3B32); text-decoration: none; font-weight: 700; font-size: .92rem; transition: background .15s; }
    .pf-link:hover { background: var(--c-tint, #F5EAD8); color: var(--c-dark, #6B4F3F); }
    .pf-link i { width: 34px; height: 34px; border-radius: 10px; background: var(--c-tint, #F5EAD8); color: var(--c-primary, #8B6F5B); display: flex; align-items: center; justify-content: center; }
    .pf-link .chev { margin-left: auto; width: auto; height: auto; background: none; color: #B8A99C; }

    /* Form kanan */
    .pf-form { padding: 1.8rem 2rem 2rem; }
    .pf-form h5 { font-weight: 800; color: var(--c-text, #4A3B32); margin: 0 0 .2rem; }
    .pf-form .sub { color: #85766B; font-size: .9rem; margin-bottom: 1.4rem; }
    .pf-field { margin-bottom: 1.15rem; }
    .pf-field label { display: block; font-weight: 700; font-size: .88rem; color: var(--c-text, #4A3B32); margin-bottom: .4rem; }
    .pf-input { position: relative; }
    .pf-input > i { position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: var(--c-mid, #C9AF9A); font-size: 1.05rem; pointer-events: none; }
    .pf-input.ta > i { top: 1.15rem; transform: none; }
    .pf-input input, .pf-input textarea { width: 100%; border: 1.5px solid var(--c-line, #EFE3D3); border-radius: 12px; padding: .8rem 1rem .8rem 2.8rem; background: #FDFAF6; font-size: .95rem; color: var(--c-text, #4A3B32); transition: border-color .15s, box-shadow .15s, background .15s; }
    .pf-input textarea { min-height: 104px; resize: vertical; }
    .pf-input input:focus, .pf-input textarea:focus { outline: none; border-color: var(--c-primary, #8B6F5B); background: #fff; box-shadow: 0 0 0 .2rem rgba(139, 111, 91, .15); }
    .pf-input.bad input, .pf-input.bad textarea { border-color: #D98C82; background: #FFF8F7; }
    .pf-err { color: #B3402F; font-size: .84rem; font-weight: 600; margin-top: .35rem; }
    .pf-hint { color: #9A8B80; font-size: .8rem; margin-top: .3rem; }
    .pf-actions { display: flex; gap: .7rem; flex-wrap: wrap; margin-top: 1.6rem; padding-top: 1.3rem; border-top: 1px solid var(--c-line, #EFE3D3); }
    .pf-btn { display: inline-flex; align-items: center; justify-content: center; gap: .5rem; padding: .8rem 1.7rem; border-radius: 12px; font-weight: 800; font-size: .95rem; text-decoration: none; cursor: pointer; border: 1.5px solid var(--c-primary, #8B6F5B); transition: background .2s; }
    .pf-btn.primary { background: var(--c-primary, #8B6F5B); color: #fff; }
    .pf-btn.primary:hover { background: var(--c-dark, #6B4F3F); border-color: var(--c-dark, #6B4F3F); }
    .pf-btn.ghost { background: #fff; color: var(--c-dark, #6B4F3F); border-color: var(--c-mid, #C9AF9A); }
    .pf-btn.ghost:hover { background: var(--c-tint, #F5EAD8); color: var(--c-dark, #6B4F3F); }

    @media (max-width: 575.98px) {
        .pf-form { padding: 1.3rem 1.1rem 1.5rem; }
        .pf-btn { width: 100%; }
    }
</style>
@endpush

@section('content')
@php
    $user = auth()->user();
    $isAdmin = $user->isAdmin();
    $orderCount = \App\Models\Order::where('user_id', $user->id)->count();
    $doneCount = \App\Models\Order::where('user_id', $user->id)->where('status', 'completed')->count();
    $bad = fn ($field) => $errors->has($field) ? 'bad' : '';
@endphp

<div class="pf-wrap">
    <div class="pf-head">
        <h3><i class="bi bi-person-circle"></i>Edit Profil</h3>
        <p>Perbarui data dirimu supaya pengiriman dan komunikasi pesanan lebih lancar.</p>
    </div>

    <div class="row g-3">
        {{-- Kiri: ringkasan akun --}}
        <div class="col-lg-4">
            <div class="pf-card">
                <div class="pf-side-top">
                    <div class="pf-avatar">{{ strtoupper(mb_substr($user->name, 0, 1)) }}</div>
                    <h5>{{ $user->name }}</h5>
                    <small>{{ $user->email }}</small>
                    <div><span class="pf-role">{{ $isAdmin ? 'Admin' : 'Customer' }}</span></div>
                </div>

                @unless ($isAdmin)
                    <div class="pf-stats">
                        <div class="pf-stat"><strong>{{ $orderCount }}</strong><span>Pesanan</span></div>
                        <div class="pf-stat"><strong>{{ $doneCount }}</strong><span>Selesai</span></div>
                    </div>
                @endunless

                <div class="pf-links" @if ($isAdmin) style="padding-top: 1.4rem;" @endif>
                    <a href="{{ route('profile.password.edit') }}" class="pf-link">
                        <i class="bi bi-shield-lock"></i>Ganti Password<i class="bi bi-chevron-right chev"></i>
                    </a>
                    @unless ($isAdmin)
                        <a href="{{ route('orders.index') }}" class="pf-link">
                            <i class="bi bi-bag"></i>Pesanan Saya<i class="bi bi-chevron-right chev"></i>
                        </a>
                    @endunless
                </div>
            </div>
        </div>

        {{-- Kanan: form --}}
        <div class="col-lg-8">
            <div class="pf-card">
                <form action="{{ route('profile.update') }}" method="POST" class="pf-form" novalidate>
                    @csrf
                    @method('PUT')

                    <h5>Data Pribadi</h5>
                    <p class="sub">Pastikan data di bawah ini benar dan masih aktif.</p>

                    <div class="pf-field">
                        <label for="name">Nama Lengkap</label>
                        <div class="pf-input {{ $bad('name') }}">
                            <i class="bi bi-person"></i>
                            <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" placeholder="Nama lengkap kamu" required>
                        </div>
                        @error('name') <div class="pf-err">{{ $message }}</div> @enderror
                    </div>

                    <div class="pf-field">
                        <label for="email">Email</label>
                        <div class="pf-input {{ $bad('email') }}">
                            <i class="bi bi-envelope"></i>
                            <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" placeholder="nama@email.com" required>
                        </div>
                        @error('email') <div class="pf-err">{{ $message }}</div> @enderror
                    </div>

                    <div class="pf-field">
                        <label for="phone">Nomor Telepon</label>
                        <div class="pf-input {{ $bad('phone') }}">
                            <i class="bi bi-telephone"></i>
                            <input type="text" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="08xxxxxxxxxx" inputmode="tel">
                        </div>
                        @error('phone') <div class="pf-err">{{ $message }}</div> @enderror
                        <div class="pf-hint">Dipakai untuk menghubungi kamu soal pesanan.</div>
                    </div>

                    <div class="pf-field">
                        <label for="address">Alamat</label>
                        <div class="pf-input ta {{ $bad('address') }}">
                            <i class="bi bi-geo-alt"></i>
                            <textarea id="address" name="address" placeholder="Alamat lengkap (jalan, desa/kelurahan, kecamatan, kota)">{{ old('address', $user->address) }}</textarea>
                        </div>
                        @error('address') <div class="pf-err">{{ $message }}</div> @enderror
                    </div>

                    <div class="pf-actions">
                        <button type="submit" class="pf-btn primary"><i class="bi bi-check-lg"></i>Simpan Perubahan</button>
                        <a href="{{ route('profile.show') }}" class="pf-btn ghost">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection