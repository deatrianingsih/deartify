@extends('layouts.dashboard')

@push('styles')
<style>
    .pf-wrap {
    max-width: 1060px;
    margin: 0 auto;
}

.pf-head {
    margin-bottom: 1.3rem;
}

.pf-head h3 {
    margin: 0 0 .15rem;
    font-weight: 800;
    color: var(--c-text, #4A3B32);
    display: flex;
    align-items: center;
    gap: .6rem;
}

.pf-head h3 i {
    color: var(--c-primary, #8B6F5B);
}

.pf-head p {
    margin: 0;
    color: #85766B;
}

.pf-card {
    background: #fff;
    border-radius: 20px;
    box-shadow: 0 2px 14px rgba(74, 59, 50, .08);
    overflow: hidden;
}

/* Kartu kiri */
.pf-side-top {
    background: linear-gradient(135deg, var(--c-primary, #8B6F5B), var(--c-dark, #6B4F3F));
    padding: 2rem 1.5rem;
    text-align: center;
    color: #fff;
}

.pf-shield {
    width: 84px;
    height: 84px;
    border-radius: 50%;
    margin: 0 auto .8rem;
    background: rgba(255, 255, 255, .2);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2.3rem;
    border: 3px solid rgba(255, 255, 255, .4);
}

.pf-side-top h5 {
    margin: 0 0 .2rem;
    font-weight: 800;
}

.pf-side-top small {
    opacity: .85;
}

.pf-tips {
    padding: 1.3rem 1.4rem 1.5rem;
}

.pf-tips h6 {
    font-weight: 800;
    font-size: .92rem;
    color: var(--c-text, #4A3B32);
    margin: 0 0 .8rem;
}

.pf-tip {
    display: flex;
    gap: .6rem;
    font-size: .87rem;
    color: #6F6258;
    margin-bottom: .6rem;
    align-items: flex-start;
}

.pf-tip i {
    color: #C9B8A8;
    margin-top: .1rem;
    transition: color .2s;
}

.pf-tip.ok i {
    color: #2E7D4F;
}

.pf-tip.ok {
    color: #2E7D4F;
    font-weight: 700;
}

.pf-back {
    display: flex;
    align-items: center;
    gap: .6rem;
    margin: 0 1.1rem 1.2rem;
    padding: .7rem .8rem;
    border-radius: 12px;
    background: var(--c-tint, #F5EAD8);
    color: var(--c-dark, #6B4F3F);
    text-decoration: none;
    font-weight: 700;
    font-size: .9rem;
}

.pf-back:hover {
    background: var(--c-soft, #EDDECA);
    color: var(--c-dark, #6B4F3F);
}

/* Form */
.pf-form {
    padding: 1.8rem 2rem 2rem;
}

.pf-form h5 {
    font-weight: 800;
    color: var(--c-text, #4A3B32);
    margin: 0 0 .2rem;
}

.pf-form .sub {
    color: #85766B;
    font-size: .9rem;
    margin-bottom: 1.4rem;
}

.pf-field {
    margin-bottom: 1.15rem;
}

.pf-field label {
    display: block;
    font-weight: 700;
    font-size: .88rem;
    color: var(--c-text, #4A3B32);
    margin-bottom: .4rem;
}

.pf-input {
    position: relative;
}

.pf-input > i.lead {
    position: absolute;
    left: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: var(--c-mid, #C9AF9A);
    font-size: 1.05rem;
    pointer-events: none;
}

.pf-input input {
    width: 100%;
    border: 1.5px solid var(--c-line, #EFE3D3);
    border-radius: 12px;
    padding: .8rem 3rem .8rem 2.8rem;
    background: #FDFAF6;
    font-size: .95rem;
    color: var(--c-text, #4A3B32);
    transition: border-color .15s, box-shadow .15s, *background* .15s;
}

.pf-input input:focus {
    outline: none;
    border-color: var(--c-primary, #8B6F5B);
    background: #fff;
    box-shadow: 0 0 0 .2rem rgba(139, 111, 91, .15);
}

.pf-input.bad input {
    border-color: #D98C82;
    background: #FFF8F7;
}

.pf-eye {
    position: absolute;
    right: .5rem;
    top: 50%;
    transform: translateY(-50%);
    border: 0;
    background: transparent;
    color: #A89B90;
    width: 38px;
    height: 38px;
    border-radius: 10px;
    font-size: 1.1rem;
    cursor: pointer;
}

.pf-eye:hover {
    background: var(--c-tint, #F5EAD8);
    color: var(--c-dark, #6B4F3F);
}

.pf-err {
    color: #B3402F;
    font-size: .84rem;
    font-weight: 600;
    margin-top: .35rem;
}

.pf-hint {
    font-size: .82rem;
    margin-top: .4rem;
    min-height: 1.1em;
    font-weight: 600;
}

.pf-hint.good {
    color: #2E7D4F;
}

.pf-hint.warn {
    color: #B3402F;
}

.pf-meter {
    display: flex;
    gap: 5px;
    margin-top: .55rem;
}

.pf-meter span {
    flex: 1;
    height: 6px;
    border-radius: 4px;
    background: #EDE2D3;
    transition: *background* .2s;
}

.pf-meter[data-lv="1"] span:nth-child(-n+1) {
    background: #D9534F;
}

.pf-meter[data-lv="2"] span:nth-child(-n+2) {
    background: #F0AD4E;
}

.pf-meter[data-lv="3"] span:nth-child(-n+3) {
    background: #8FBF8F;
}

.pf-meter[data-lv="4"] span:nth-child(-n+4) {
    background: #2E7D4F;
}

.pf-meter-lbl {
    font-size: .8rem;
    color: #85766B;
    margin-top: .3rem;
}

.pf-actions {
    display: flex;
    gap: .7rem;
    flex-wrap: wrap;
    margin-top: 1.6rem;
    padding-top: 1.3rem;
    border-top: 1px solid var(--c-line, #EFE3D3);
}

.pf-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: .5rem;
    padding: .8rem 1.7rem;
    border-radius: 12px;
    font-weight: 800;
    font-size: .95rem;
    text-decoration: none;
    cursor: pointer;
    border: 1.5px solid var(--c-primary, #8B6F5B);
    transition: *background* .2s;
}

.pf-btn.primary {
    background: var(--c-primary, #8B6F5B);
    color: #fff;
}

.pf-btn.primary:hover {
    background: var(--c-dark, #6B4F3F);
    border-color: var(--c-dark, #6B4F3F);
}

.pf-btn.ghost {
    background: #fff;
    color: var(--c-dark, #6B4F3F);
    border-color: var(--c-mid, #C9AF9A);
}

.pf-btn.ghost:hover {
    background: var(--c-tint, #F5EAD8);
    color: var(--c-dark, #6B4F3F);
}

@media (max-width: 575.98px) {
    .pf-form {
        padding: 1.3rem 1.1rem 1.5rem;
    }

    .pf-btn {
        width: 100%;
    }
}
</style>
@endpush

@section('content')
@php $bad = fn ($field) => $errors->has($field) ? 'bad' : ''; @endphp

<div class="pf-wrap">
    <div class="pf-head">
        <h3><i class="bi bi-shield-lock"></i>Ubah Password</h3>
        <p>Gunakan password yang kuat supaya akunmu tetap aman.</p>
    </div>

    <div class="row g-3">
        {{-- Kiri: tips --}}
        <div class="col-lg-4">
            <div class="pf-card">
                <div class="pf-side-top">
                    <div class="pf-shield"><i class="bi bi-shield-check"></i></div>
                    <h5>Keamanan Akun</h5>
                    <small>{{ auth()->user()->email }}</small>
                </div>
                <div class="pf-tips">
                    <h6>Password yang baik:</h6>
                    <div class="pf-tip" id="tipLen"><i class="bi bi-circle"></i>Minimal 8 karakter</div>
                    <div class="pf-tip" id="tipCase"><i class="bi bi-circle"></i>Ada huruf besar dan kecil</div>
                    <div class="pf-tip" id="tipNum"><i class="bi bi-circle"></i>Ada angka</div>
                    <div class="pf-tip" id="tipSym"><i class="bi bi-circle"></i>Ada simbol (contoh: ! @ # $)</div>
                </div>
                <a href="{{ route('profile.edit') }}" class="pf-back"><i class="bi bi-arrow-left"></i>Kembali ke Edit Profil</a>
            </div>
        </div>

        {{-- Kanan: form --}}
        <div class="col-lg-8">
            <div class="pf-card">
                <form action="{{ route('profile.password') }}" method="POST" class="pf-form" novalidate>
                    @csrf
                    @method('PUT')

                    <h5>Ganti Password</h5>
                    <p class="sub">Masukkan password saat ini, lalu buat password baru.</p>

                    <div class="pf-field">
                        <label for="current_password">Password Saat Ini</label>
                        <div class="pf-input {{ $bad('current_password') }}">
                            <i class="bi bi-lock lead"></i>
                            <input type="password" id="current_password" name="current_password" autocomplete="current-password" required>
                            <button type="button" class="pf-eye" data-target="current_password" aria-label="Tampilkan password"><i class="bi bi-eye"></i></button>
                        </div>
                        @error('current_password') <div class="pf-err">{{ $message }}</div> @enderror
                    </div>

                    <div class="pf-field">
                        <label for="password">Password Baru</label>
                        <div class="pf-input {{ $bad('password') }}">
                            <i class="bi bi-key lead"></i>
                            <input type="password" id="password" name="password" autocomplete="new-password" required>
                            <button type="button" class="pf-eye" data-target="password" aria-label="Tampilkan password"><i class="bi bi-eye"></i></button>
                        </div>
                        <div class="pf-meter" id="meter" data-lv="0"><span></span><span></span><span></span><span></span></div>
                        <div class="pf-meter-lbl" id="meterLbl">Kekuatan password</div>
                        @error('password') <div class="pf-err">{{ $message }}</div> @enderror
                    </div>

                    <div class="pf-field">
                        <label for="password_confirmation">Konfirmasi Password Baru</label>
                        <div class="pf-input">
                            <i class="bi bi-key-fill lead"></i>
                            <input type="password" id="password_confirmation" name="password_confirmation" autocomplete="new-password" required>
                            <button type="button" class="pf-eye" data-target="password_confirmation" aria-label="Tampilkan password"><i class="bi bi-eye"></i></button>
                        </div>
                        <div class="pf-hint" id="matchHint"></div>
                    </div>

                    <div class="pf-actions">
                        <button type="submit" class="pf-btn primary"><i class="bi bi-check-lg"></i>Simpan Password</button>
                        <a href="{{ route('profile.edit') }}" class="pf-btn ghost">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    (function () {
        // Tampilkan / sembunyikan password
        document.querySelectorAll('.pf-eye').forEach(function (btn) {
            btn.addEventListener('click', function () {
                var input = document.getElementById(btn.dataset.target);
                var show = input.type === 'password';
                input.type = show ? 'text' : 'password';
                btn.innerHTML = '<i class="bi ' + (show ? 'bi-eye-slash' : 'bi-eye') + '"></i>';
            });
        });

        var pw = document.getElementById('password');
        var conf = document.getElementById('password_confirmation');
        var meter = document.getElementById('meter');
        var lbl = document.getElementById('meterLbl');
        var hint = document.getElementById('matchHint');
        var labels = ['Kekuatan password', 'Lemah', 'Cukup', 'Kuat', 'Sangat kuat'];

        function tip(id, ok) {
            var el = document.getElementById(id);
            el.classList.toggle('ok', ok);
            el.querySelector('i').className = 'bi ' + (ok ? 'bi-check-circle-fill' : 'bi-circle');
        }

        function check() {
            var v = pw.value;
            var len = v.length >= 8;
            var cas = /[a-z]/.test(v) && /[A-Z]/.test(v);
            var num = /\d/.test(v);
            var sym = /[^A-Za-z0-9]/.test(v);
            tip('tipLen', len); tip('tipCase', cas); tip('tipNum', num); tip('tipSym', sym);

            var lv = v.length === 0 ? 0 : Math.max(1, [len, cas, num, sym].filter(Boolean).length);
            meter.dataset.lv = lv;
            lbl.textContent = labels[lv];

            if (conf.value === '') { hint.textContent = ''; hint.className = 'pf-hint'; return; }
            var same = conf.value === v;
            hint.textContent = same ? 'Password cocok' : 'Password belum cocok';
            hint.className = 'pf-hint ' + (same ? 'good' : 'warn');
        }

        pw.addEventListener('input', check);
        conf.addEventListener('input', check);
        check();
    })();
</script>
@endsection