@extends('layouts.dashboard')

@push('styles')
<style>
    .pv-wrap { max-width: 1060px; margin: 0 auto; }

    .pv-card { background: #fff; border-radius: 20px; box-shadow: 0 2px 14px rgba(74, 59, 50, .08); overflow: hidden; margin-bottom: 1.1rem; }

    /* Banner */
    .pv-banner { height: 130px; background: linear-gradient(135deg, var(--c-primary, #8B6F5B), var(--c-dark, #6B4F3F)); position: relative; }
    .pv-banner::before, .pv-banner::after { content: ''; position: absolute; border-radius: 50%; background: rgba(255, 255, 255, .08); }
    .pv-banner::before { width: 220px; height: 220px; right: -50px; top: -90px; }
    .pv-banner::after { width: 130px; height: 130px; right: 150px; bottom: -70px; }
    .pv-id { display: flex; align-items: flex-end; gap: 1.3rem; padding: 0 2rem 1.5rem; margin-top: -52px; flex-wrap: wrap; position: relative; }
    .pv-avatar { width: 108px; height: 108px; border-radius: 50%; background: #fff; color: var(--c-primary, #8B6F5B); font-size: 2.9rem; font-weight: 800; display: flex; align-items: center; justify-content: center; border: 5px solid #fff; box-shadow: 0 8px 22px rgba(74, 59, 50, .2); flex-shrink: 0; }
    .pv-name { flex: 1; min-width: 200px; padding-bottom: .3rem; }
    .pv-name h3 { margin: 0 0 .15rem; font-weight: 800; color: var(--c-text, #4A3B32); }
    .pv-name .mail { color: #85766B; font-size: .93rem; display: flex; align-items: center; gap: .4rem; }
    .pv-role { display: inline-block; margin-top: .5rem; background: var(--c-tint, #F5EAD8); color: var(--c-dark, #6B4F3F); border-radius: 999px; padding: .2rem .85rem; font-size: .75rem; font-weight: 800; letter-spacing: .05em; text-transform: uppercase; }
    .pv-id-actions { display: flex; gap: .6rem; flex-wrap: wrap; padding-bottom: .3rem; }

    .pv-btn { display: inline-flex; align-items: center; justify-content: center; gap: .5rem; padding: .7rem 1.3rem; border-radius: 12px; font-weight: 800; font-size: .92rem; text-decoration: none; cursor: pointer; border: 1.5px solid var(--c-primary, #8B6F5B); transition: background .2s; }
    .pv-btn.primary { background: var(--c-primary, #8B6F5B); color: #fff; }
    .pv-btn.primary:hover { background: var(--c-dark, #6B4F3F); border-color: var(--c-dark, #6B4F3F); color: #fff; }
    .pv-btn.ghost { background: #fff; color: var(--c-dark, #6B4F3F); border-color: var(--c-mid, #C9AF9A); }
    .pv-btn.ghost:hover { background: var(--c-tint, #F5EAD8); color: var(--c-dark, #6B4F3F); }

    .pv-sec { padding: 1.5rem 1.7rem 1.7rem; }
    .pv-sec h5 { font-weight: 800; font-size: 1.02rem; color: var(--c-text, #4A3B32); margin: 0 0 1.1rem; display: flex; align-items: center; gap: .55rem; }
    .pv-sec h5 i { color: var(--c-primary, #8B6F5B); }

    .pv-row { display: flex; gap: .95rem; padding: .85rem 0; border-bottom: 1px solid var(--c-line, #EFE3D3); }
    .pv-row:first-of-type { padding-top: 0; }
    .pv-row:last-child { border-bottom: 0; padding-bottom: 0; }
    .pv-row .ic { width: 40px; height: 40px; border-radius: 12px; background: var(--c-tint, #F5EAD8); color: var(--c-primary, #8B6F5B); display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-size: 1.1rem; }
    .pv-row small { display: block; color: #85766B; font-size: .8rem; }
    .pv-row .v { font-weight: 700; color: var(--c-text, #4A3B32); word-break: break-word; }
    .pv-row .v.empty { color: #B8A99C; font-weight: 600; font-style: italic; }

    .pv-stats { display: grid; grid-template-columns: repeat(3, 1fr); gap: .7rem; }
    .pv-stat { background: var(--c-tint, #F5EAD8); border-radius: 14px; padding: .95rem .6rem; text-align: center; }
    .pv-stat strong { display: block; font-size: 1.5rem; color: var(--c-dark, #6B4F3F); line-height: 1.1; }
    .pv-stat span { font-size: .78rem; color: #85766B; font-weight: 700; }

    .pv-sec-box { display: flex; align-items: center; gap: .9rem; background: var(--c-tint, #F5EAD8); border-radius: 14px; padding: 1rem 1.1rem; }
    .pv-sec-box .ic { width: 44px; height: 44px; border-radius: 12px; background: #fff; color: var(--c-primary, #8B6F5B); display: flex; align-items: center; justify-content: center; font-size: 1.3rem; flex-shrink: 0; }
    .pv-sec-box p { margin: 0; font-size: .86rem; color: #6F6258; }
    .pv-sec-box strong { color: var(--c-text, #4A3B32); display: block; font-size: .95rem; }
    .pv-sec-box .pv-btn { margin-left: auto; white-space: nowrap; padding: .55rem 1rem; font-size: .85rem; }

    @media (max-width: 575.98px) {
        .pv-id { padding: 0 1.1rem 1.2rem; flex-direction: column; align-items: flex-start; }
        .pv-id-actions { width: 100%; }
        .pv-id-actions .pv-btn { flex: 1; }
        .pv-sec { padding: 1.2rem 1.1rem 1.4rem; }
        .pv-sec-box { flex-wrap: wrap; }
        .pv-sec-box .pv-btn { width: 100%; margin-left: 0; }
    }
</style>
@endpush

@section('content')
@php
    $user = auth()->user();
    $isAdmin = $user->isAdmin();
    $total = \App\Models\Order::where('user_id', $user->id)->count();
    $done = \App\Models\Order::where('user_id', $user->id)->where('status', 'completed')->count();
    $running = \App\Models\Order::where('user_id', $user->id)->whereIn('status', ['pending', 'in_progress', 'shipped'])->count();
    $joined = $user->created_at ? $user->created_at->copy()->timezone('Asia/Jakarta')->locale('id')->translatedFormat('j F Y') : null;
@endphp

<div class="pv-wrap">
    {{-- Kartu identitas --}}
    <div class="pv-card">
        <div class="pv-banner"></div>
        <div class="pv-id">
            <div class="pv-avatar">{{ strtoupper(mb_substr($user->name, 0, 1)) }}</div>
            <div class="pv-name">
                <h3>{{ $user->name }}</h3>
                <div class="mail"><i class="bi bi-envelope"></i>{{ $user->email }}</div>
                <span class="pv-role">{{ $isAdmin ? 'Admin' : 'Customer' }}</span>
            </div>
            <div class="pv-id-actions">
                <a href="{{ route('profile.edit') }}" class="pv-btn primary"><i class="bi bi-pencil-square"></i>Edit Profil</a>
                <a href="{{ route('profile.password.edit') }}" class="pv-btn ghost"><i class="bi bi-shield-lock"></i>Ubah Password</a>
            </div>
        </div>
    </div>

    <div class="row g-3">
        {{-- Informasi pribadi --}}
        <div class="col-lg-7">
            <div class="pv-card h-100">
                <div class="pv-sec">
                    <h5><i class="bi bi-person-lines-fill"></i>Informasi Pribadi</h5>

                    <div class="pv-row">
                        <div class="ic"><i class="bi bi-person"></i></div>
                        <div><small>Nama lengkap</small><div class="v">{{ $user->name }}</div></div>
                    </div>
                    <div class="pv-row">
                        <div class="ic"><i class="bi bi-envelope"></i></div>
                        <div><small>Email</small><div class="v">{{ $user->email }}</div></div>
                    </div>
                    <div class="pv-row">
                        <div class="ic"><i class="bi bi-telephone"></i></div>
                        <div>
                            <small>Nomor telepon</small>
                            @if ($user->phone)
                                <div class="v">{{ $user->phone }}</div>
                            @else
                                <div class="v empty">Belum diisi</div>
                            @endif
                        </div>
                    </div>
                    <div class="pv-row">
                        <div class="ic"><i class="bi bi-geo-alt"></i></div>
                        <div>
                            <small>Alamat</small>
                            @if ($user->address)
                                <div class="v">{{ $user->address }}</div>
                            @else
                                <div class="v empty">Belum diisi</div>
                            @endif
                        </div>
                    </div>
                    @if ($joined)
                        <div class="pv-row">
                            <div class="ic"><i class="bi bi-calendar-heart"></i></div>
                            <div><small>Bergabung sejak</small><div class="v">{{ $joined }}</div></div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Aktivitas + keamanan --}}
        <div class="col-lg-5">
            @unless ($isAdmin)
                <div class="pv-card">
                    <div class="pv-sec">
                        <h5><i class="bi bi-bar-chart"></i>Aktivitas Pesanan</h5>
                        <div class="pv-stats">
                            <div class="pv-stat"><strong>{{ $total }}</strong><span>Total</span></div>
                            <div class="pv-stat"><strong>{{ $running }}</strong><span>Berjalan</span></div>
                            <div class="pv-stat"><strong>{{ $done }}</strong><span>Selesai</span></div>
                        </div>
                        <a href="{{ route('orders.index') }}" class="pv-btn ghost w-100 mt-3"><i class="bi bi-bag"></i>Lihat Pesanan Saya</a>
                    </div>
                </div>
            @endunless

            <div class="pv-card">
                <div class="pv-sec">
                    <h5><i class="bi bi-shield-check"></i>Keamanan Akun</h5>
                    <div class="pv-sec-box">
                        <div class="ic"><i class="bi bi-key"></i></div>
                        <div>
                            <strong>Password</strong>
                            <p>Ganti secara berkala agar akun tetap aman.</p>
                        </div>
                        <a href="{{ route('profile.password.edit') }}" class="pv-btn primary">Ubah</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection