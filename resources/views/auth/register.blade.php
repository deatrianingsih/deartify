<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - DeArtify</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link href="https://fonts.bunny.net/css?family=caveat:500,700|nunito:400,600,700,800" rel="stylesheet">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <style>
        :root { --p: #8B6F5B; --d: #5E4334; --cream: #FFF3E0; --line: #EFE3D3; --txt: #4A3B32; --gold: #E0A21B; }
        body { font-family: 'Nunito', sans-serif; margin: 0; color: var(--txt); }

        .au { min-height: 100vh; display: flex; flex-direction: column; background: #8B6F5B url('{{ asset('images/welcome.png') }}') center/cover no-repeat fixed; position: relative; }
        .au::before { content: ''; position: absolute; inset: 0; background: linear-gradient(135deg, rgba(60, 40, 30, .78), rgba(94, 67, 52, .55)); }
        .au > * { position: relative; }

        .au-top { display: flex; justify-content: space-between; align-items: center; padding: .8rem 2rem; }
        .au-brand { display: flex; align-items: center; gap: .5rem; color: var(--cream); text-decoration: none; font-family: 'Caveat', cursive; font-size: 2.1rem; font-weight: 700; line-height: 1; }
        .au-back { color: #F6E8D5; text-decoration: none; font-weight: 700; display: inline-flex; align-items: center; gap: .4rem; padding: .5rem 1rem; border-radius: 12px; }
        .au-back:hover { background: rgba(255, 243, 224, .16); color: #fff; }

        .au-main { flex: 1; display: flex; align-items: center; padding-top: 0 !important; justify-content: center; padding: 1rem 1rem 3rem; }
        .au-card { width: 100%; max-width: 440px; background: rgba(255, 255, 255, .96); border-radius: 28px; padding: 2.2rem 2.1rem 1.9rem; box-shadow: 0 30px 70px rgba(30, 18, 10, .45); backdrop-filter: blur(6px); animation: up .5s ease; }
        @keyframes up { from { opacity: 0; transform: translateY(18px); } to { opacity: 1; transform: none; } }
        .au-ico { width: 64px; height: 64px; border-radius: 20px; margin: 0 auto 1rem; background: linear-gradient(135deg, var(--p), var(--d)); color: #fff; display: flex; align-items: center; justify-content: center; font-size: 1.9rem; box-shadow: 0 10px 22px rgba(94, 67, 52, .35); }
        .au-card h1 { text-align: center; font-weight: 800; font-size: 1.7rem; margin: 0 0 .25rem; color: var(--d); }
        .au-sub { text-align: center; color: #85766B; margin: 0 0 1.5rem; }

        .au-alert { background: #FBEAEA; color: #B3402F; border: 1px solid #F0C9C4; border-radius: 12px; padding: .7rem .9rem; font-size: .9rem; font-weight: 600; margin-bottom: 1rem; display: flex; gap: .5rem; align-items: flex-start; }
        .au-f { margin-bottom: .8rem; }
        .au-card { max-width: 660px; padding: 1.5rem 1.8rem 1.3rem; }
        .au-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 0 1rem; }
        .au-grid .full { grid-column: 1 / -1; }
        .au-head { display: flex; align-items: center; gap: .9rem; margin-bottom: 1.1rem; }
        .au-head .au-ico { margin: 0; width: 52px; height: 52px; font-size: 1.5rem; border-radius: 16px; flex-shrink: 0; }
        .au-head h1 { text-align: left; font-size: 1.45rem; margin: 0; }
        .au-head .au-sub { text-align: left; margin: 0; font-size: .9rem; }
        .au-in input[type=email], .au-in input[type=password], .au-in input[type=text], .au-in input[type=tel] { padding-top: .62rem; padding-bottom: .62rem; }
        .au-f label { margin-bottom: .3rem; }
        .au-btn { padding: .78rem 1rem; }
        .au-foot { margin-top: 1rem; padding-top: .9rem; }
        @media (max-width: 575.98px) { .au-grid { grid-template-columns: 1fr; } }
        .au-f label { display: block; font-weight: 800; font-size: .88rem; margin-bottom: .4rem; color: var(--txt); }
        .au-in { position: relative; }
        .au-in > i.lead { position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: #B59A85; font-size: 1.05rem; pointer-events: none; }
        .au-in input[type=email], .au-in input[type=password], .au-in input[type=text], .au-in input[type=tel] { width: 100%; border: 1.5px solid var(--line); background: #FDFAF6; border-radius: 14px; padding: .8rem 1rem .8rem 2.8rem; font-size: .97rem; transition: border-color .2s, box-shadow .2s, background .2s; }
        .au-in input:focus { outline: none; border-color: var(--p); background: #fff; box-shadow: 0 0 0 .22rem rgba(139, 111, 91, .18); }
        .au-in input.bad { border-color: #D98A80; }
        .au-eye { position: absolute; right: .5rem; top: 50%; transform: translateY(-50%); border: 0; background: transparent; color: #9A7B66; width: 38px; height: 38px; border-radius: 10px; }
        .au-eye:hover { background: #F5EAD8; }
        .au-err { color: #B3402F; font-size: .83rem; font-weight: 700; margin-top: .35rem; }

        .au-row { display: flex; justify-content: space-between; align-items: center; margin: .2rem 0 1.3rem; font-size: .9rem; }
        .au-row label { display: flex; align-items: center; gap: .5rem; margin: 0; font-weight: 600; color: #6B5B50; cursor: pointer; }
        .au-row input { accent-color: var(--p); width: 17px; height: 17px; }
        .au-row a { color: var(--p); font-weight: 700; text-decoration: none; }
        .au-row a:hover { text-decoration: underline; }

        .au-btn { width: 100%; border: 0; border-radius: 14px; padding: .9rem 1rem; background: linear-gradient(135deg, var(--p), var(--d)); color: #fff; font-weight: 800; font-size: 1rem; display: flex; align-items: center; justify-content: center; gap: .55rem; box-shadow: 0 10px 22px rgba(94, 67, 52, .35); transition: transform .2s, box-shadow .2s; }
        .au-btn:hover { transform: translateY(-2px); box-shadow: 0 14px 28px rgba(94, 67, 52, .42); }
        .au-foot { text-align: center; margin-top: 1.4rem; padding-top: 1.2rem; border-top: 1px solid var(--line); color: #85766B; font-size: .92rem; }
        .au-foot a { color: var(--p); font-weight: 800; text-decoration: none; }
        .au-foot a:hover { text-decoration: underline; }

        @media (max-width: 575.98px) { .au-top { padding: 1rem; } .au-card { padding: 1.7rem 1.3rem 1.5rem; border-radius: 24px; } }
    </style>
</head>
<body>
<div class="au">
    <div class="au-top">
        <a href="{{ url('/') }}" class="au-brand"><i class="bi bi-palette-fill"></i>DeArtify</a>
        <a href="{{ url('/') }}" class="au-back"><i class="bi bi-arrow-left"></i>Kembali</a>
    </div>

    <div class="au-main">
        <div class="au-card">
            <div class="au-head">
                <div class="au-ico"><i class="bi bi-person-plus"></i></div>
                <div>
                    <h1>Buat Akun Baru</h1>
                    <p class="au-sub">Daftar untuk mulai memesan jasa gambar</p>
                </div>
            </div>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="au-grid">
                <div class="au-f full">
                    <label for="name">Nama Lengkap</label>
                    <div class="au-in">
                        <i class="bi bi-person lead"></i>
                        <input id="name" type="text" name="name" value="{{ old('name') }}" placeholder="Nama lengkapmu" class="@error('name') bad @enderror" required autocomplete="name" autofocus>
                    </div>
                    @error('name')<div class="au-err">{{ $message }}</div>@enderror
                </div>

                <div class="au-f">
                    <label for="email">Email</label>
                    <div class="au-in">
                        <i class="bi bi-envelope lead"></i>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="nama@email.com" class="@error('email') bad @enderror" required autocomplete="email">
                    </div>
                    @error('email')<div class="au-err">{{ $message }}</div>@enderror
                </div>

                <div class="au-f">
                    <label for="phone">No. Telepon</label>
                    <div class="au-in">
                        <i class="bi bi-telephone lead"></i>
                        <input id="phone" type="tel" name="phone" value="{{ old('phone') }}" placeholder="08xxxxxxxxxx" class="@error('phone') bad @enderror" required autocomplete="tel">
                    </div>
                    @error('phone')<div class="au-err">{{ $message }}</div>@enderror
                </div>

                <div class="au-f">
                    <label for="password">Password</label>
                    <div class="au-in">
                        <i class="bi bi-lock lead"></i>
                        <input id="password" type="password" name="password" placeholder="Minimal 8 karakter" class="@error('password') bad @enderror" required autocomplete="new-password">
                        <button type="button" class="au-eye" data-eye="password" aria-label="Lihat password"><i class="bi bi-eye"></i></button>
                    </div>
                    @error('password')<div class="au-err">{{ $message }}</div>@enderror
                </div>

                <div class="au-f">
                    <label for="password-confirm">Konfirmasi Password</label>
                    <div class="au-in">
                        <i class="bi bi-shield-lock lead"></i>
                        <input id="password-confirm" type="password" name="password_confirmation" placeholder="Ulangi password" required autocomplete="new-password">
                        <button type="button" class="au-eye" data-eye="password-confirm" aria-label="Lihat password"><i class="bi bi-eye"></i></button>
                    </div>
                </div>

                </div>

                <button type="submit" class="au-btn"><i class="bi bi-stars"></i>Daftar</button>
            </form>

            <div class="au-foot">Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a></div>
        </div>
    </div>
</div>

<script>
    document.querySelectorAll('[data-eye]').forEach(function (b) {
        b.addEventListener('click', function () {
            var i = document.getElementById(b.dataset.eye), ic = b.querySelector('i');
            var show = i.type === 'password';
            i.type = show ? 'text' : 'password';
            ic.className = show ? 'bi bi-eye-slash' : 'bi bi-eye';
        });
    });
</script>
</body>
</html>