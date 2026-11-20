@extends('layouts.dashboard')

@push('styles')
<style>
   .pd-wrap {
    max-width: 1100px;
    margin: 0 auto;
}

.pd-back {
    display: inline-flex;
    align-items: center;
    gap: .4rem;
    color: #8B6F5B;
    font-weight: 800;
    text-decoration: none;
    margin-bottom: .8rem;
}

.pd-back:hover {
    color: #5E4334;
}

.pd-head {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    gap: 1rem;
    flex-wrap: wrap;
    margin-bottom: 1.3rem;
}

.pd-head h3 {
    margin: 0 0 .2rem;
    font-weight: 800;
    color: #4A3B32;
    display: flex;
    align-items: center;
    gap: .6rem;
}

.pd-head h3 i {
    color: #8B6F5B;
}

.pd-head p {
    margin: 0;
    color: #85766B;
}

.pd-badge {
    display: inline-flex;
    align-items: center;
    gap: .4rem;
    padding: .5rem 1.1rem;
    border-radius: 999px;
    font-weight: 800;
    font-size: .9rem;
}

.pd-badge.wait {
    background: #FFF1D6;
    color: #9A6A0B;
}

.pd-badge.ok {
    background: #E3F4E6;
    color: #2F7A3D;
}

.pd-badge.no {
    background: #FBEAEA;
    color: #B3402F;
}

.pd-card {
    background: #fff;
    border: 1px solid #EFE3D3;
    border-radius: 22px;
    box-shadow: 0 2px 14px rgba(74, 59, 50, .07);
    overflow: hidden;
    height: 100%;
}

.pd-sec {
    padding: 1.1rem 1.4rem .4rem;
    font-size: .74rem;
    font-weight: 800;
    letter-spacing: .1em;
    text-transform: uppercase;
    color: #9A7B66;
}

.pd-total {
    margin: .4rem 1.4rem 1rem;
    background: linear-gradient(135deg, #8B6F5B, #5E4334);
    color: #fff;
    border-radius: 18px;
    padding: 1.1rem 1.3rem;
    box-shadow: 0 10px 22px rgba(94, 67, 52, .28);
}

.pd-total small {
    color: #F1D9B8;
    font-weight: 700;
}

.pd-total strong {
    display: block;
    font-size: 2rem;
    line-height: 1.15;
}

.pd-rows {
    padding: 0 1.4rem .4rem;
}

.pd-row {
    display: flex;
    align-items: center;
    gap: .9rem;
    padding: .75rem 0;
    border-bottom: 1px solid #F3E9DA;
}

.pd-row:last-child {
    border-bottom: 0;
}

.pd-ic {
    width: 38px;
    height: 38px;
    border-radius: 12px;
    background: #F5EAD8;
    color: #8B6F5B;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.pd-row small {
    display: block;
    color: #9A8B80;
    font-weight: 600;
    font-size: .78rem;
}

.pd-row b {
    color: #4A3B32;
}

.pd-act {
    padding: .6rem 1.4rem 1.4rem;
}

.pd-note {
    border-radius: 14px;
    padding: .9rem 1rem;
    font-size: .92rem;
    display: flex;
    gap: .7rem;
    align-items: flex-start;
}

.pd-note i {
    font-size: 1.2rem;
    margin-top: .05rem;
}

.pd-note.warn {
    background: #FFF6E3;
    color: #8A5E0A;
}

.pd-note.bad {
    background: #FBEAEA;
    color: #A8392A;
}

.pd-note.good {
    background: #E3F4E6;
    color: #2F7A3D;
}

.pd-btn {
    width: 100%;
    border: 0;
    border-radius: 14px;
    padding: .95rem 1rem;
    background: linear-gradient(135deg, #3E9B55, #2F7A3D);
    color: #fff;
    font-weight: 800;
    font-size: 1rem;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: .5rem;
    box-shadow: 0 10px 22px rgba(47, 122, 61, .3);
    transition: transform .2s, box-shadow .2s;
}

.pd-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 14px 28px rgba(47, 122, 61, .38);
}

.pd-proof {
    padding: 0 1.4rem 1.4rem;
    text-align: center;
}

.pd-frame {
    background: linear-gradient(145deg, #F5EAD8, #E6D2B8);
    border-radius: 18px;
    padding: 1rem;
    display: flex;
    justify-content: center;
    cursor: zoom-in;
}

.pd-frame img {
    max-width: 100%;
    max-height: 440px;
    border-radius: 12px;
    box-shadow: 0 8px 22px rgba(74, 59, 50, .3);
    object-fit: contain;
}

.pd-zoom {
    margin-top: .7rem;
    color: #8B6F5B;
    font-weight: 700;
    font-size: .88rem;
}

.pd-none {
    height: 260px;
    margin-bottom: 0;
    background: #FBF3E8;
    border: 2px dashed #D9C3A8;
    border-radius: 18px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    color: #9A8B80;
    gap: .3rem;
}

.pd-none i {
    font-size: 2.6rem;
    color: #C9AF9A;
}

.pd-lb {
    border: 0;
    padding: 0;
    background: transparent;
    max-width: 94vw;
    max-height: 94vh;
    margin: auto;
}

.pd-lb::backdrop {
    background: rgba(30, 18, 10, .8);
}

.pd-lb img {
    max-width: 94vw;
    max-height: 92vh;
    border-radius: 14px;
    display: block;
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