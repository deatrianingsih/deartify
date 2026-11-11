<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'DeArtify - Jasa Gambar Online')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link href="https://fonts.bunny.net/css?family=caveat:500,700|nunito:400,600,700,800" rel="stylesheet">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <style>
        :root { --p: #8B6F5B; --d: #5E4334; --soft: #EDDECA; --tint: #F5EAD8; --cream: #FFF3E0; --line: #EFE3D3; --txt: #4A3B32; --gold: #E0A21B; }
        html { scroll-behavior: smooth; scroll-padding-top: 80px; }
        body { font-family: 'Nunito', sans-serif; color: var(--txt); background: #FBF6EE; margin: 0; }
        .script { font-family: 'Caveat', cursive; }
        .wrap { max-width: 1200px; margin: 0 auto; padding: 0 1.5rem; }

        /* Navbar */
        .nv { position: sticky; top: 0; z-index: 1000; background: rgba(94, 67, 52, .97); backdrop-filter: blur(8px); box-shadow: 0 6px 20px rgba(74, 59, 50, .25); }
        .nv .wrap { display: flex; align-items: center; justify-content: space-between; height: 70px; gap: 1rem; }
        .nv-brand { display: flex; align-items: center; gap: .5rem; color: var(--cream); text-decoration: none; font-family: 'Caveat', cursive; font-size: 2rem; font-weight: 700; line-height: 1; }
        .nv-brand i { font-size: 1.6rem; }
        .nv-links { display: flex; gap: .3rem; list-style: none; margin: 0; padding: 0; }
        .nv-links a { display: block; padding: .5rem 1rem; border-radius: 10px; color: #F6E8D5; font-weight: 700; font-size: .94rem; text-decoration: none; transition: background .2s, color .2s; }
        .nv-links a:hover, .nv-links a.on { background: rgba(255, 243, 224, .16); color: #fff; }
        .nv-cta { display: flex; gap: .6rem; }
        .btn-l, .btn-d { display: inline-flex; align-items: center; justify-content: center; gap: .45rem; padding: .55rem 1.3rem; border-radius: 12px; font-weight: 800; font-size: .92rem; text-decoration: none; transition: transform .2s, background .2s, box-shadow .2s; }
        .btn-l { border: 2px solid rgba(255, 243, 224, .6); color: var(--cream); }
        .btn-l:hover { background: rgba(255, 243, 224, .15); color: #fff; }
        .btn-d { background: var(--cream); color: var(--d); border: 2px solid var(--cream); }
        .btn-d:hover { background: #fff; color: var(--d); transform: translateY(-2px); }
        .nv-toggle { display: none; background: rgba(255, 243, 224, .15); border: 0; color: var(--cream); width: 42px; height: 42px; border-radius: 12px; font-size: 1.5rem; }

        /* Hero */
        .hero { position: relative; min-height: 600px; display: flex; align-items: center; background: #D9BFA0 url('{{ asset('images/welcome.png') }}') center/cover no-repeat; }
        .hero::before { content: ''; position: absolute; inset: 0; background: linear-gradient(95deg, rgba(60, 40, 30, .88) 0%, rgba(94, 67, 52, .72) 38%, rgba(94, 67, 52, 0) 72%); }
        .hero .wrap { position: relative; width: 100%; }
        .hero-box { max-width: 580px; color: #fff; padding: 3rem 0; }
        .hero-tag { display: inline-flex; align-items: center; gap: .45rem; background: rgba(255, 243, 224, .18); border: 1px solid rgba(255, 243, 224, .4); padding: .4rem 1rem; border-radius: 999px; font-weight: 700; font-size: .85rem; margin-bottom: 1.1rem; }
        .hero-tag i { color: var(--gold); }
        .hero h1 { font-size: clamp(2.3rem, 5vw, 3.6rem); font-weight: 800; line-height: 1.12; margin: 0 0 1rem; }
        .hero h1 span { font-family: 'Caveat', cursive; font-size: 1.25em; color: #FFD9A0; }
        .hero p { font-size: 1.1rem; line-height: 1.65; color: #F6E8D5; margin: 0 0 1.8rem; }
        .hero-btns { display: flex; gap: .8rem; flex-wrap: wrap; }
        .hero-btns .btn-d, .hero-btns .btn-l { padding: .85rem 1.7rem; font-size: 1rem; }
        .hero-stats { display: flex; gap: 2rem; margin-top: 2.2rem; flex-wrap: wrap; }
        .hero-stats strong { display: block; font-size: 1.5rem; color: #FFD9A0; }
        .hero-stats small { color: #F1D9B8; font-weight: 600; }

        /* Section */
        .sec { padding: 4.5rem 0; }
        .sec.alt { background: #F5EBDD; }
        .sec-head { text-align: center; margin-bottom: 2.6rem; }
        .sec-head .kicker { color: var(--p); font-weight: 800; letter-spacing: .12em; text-transform: uppercase; font-size: .8rem; }
        .sec-head h2 { font-weight: 800; font-size: clamp(1.7rem, 3vw, 2.3rem); margin: .3rem 0 .5rem; color: var(--d); }
        .sec-head p { color: #85766B; margin: 0; }

        /* Keunggulan */
        .feat { background: #fff; border: 1px solid var(--line); border-radius: 22px; padding: 1.6rem 1.4rem; height: 100%; text-align: center; box-shadow: 0 2px 12px rgba(74, 59, 50, .06); transition: transform .25s, box-shadow .25s; }
        .feat:hover { transform: translateY(-6px); box-shadow: 0 16px 32px rgba(74, 59, 50, .15); }
        .ico { width: 66px; height: 66px; margin: 0 auto 1rem; border-radius: 20px; background: linear-gradient(135deg, var(--p), var(--d)); color: #fff; display: flex; align-items: center; justify-content: center; font-size: 1.8rem; box-shadow: 0 8px 18px rgba(94, 67, 52, .3); }
        .feat h5 { font-weight: 800; font-size: 1.05rem; margin-bottom: .35rem; }
        .feat p { margin: 0; color: #85766B; font-size: .9rem; line-height: 1.55; }

        /* Layanan */
        .svc { display: flex; flex-direction: column; height: 100%; background: #fff; border: 1px solid var(--line); border-radius: 22px; overflow: hidden; box-shadow: 0 2px 12px rgba(74, 59, 50, .06); transition: transform .25s, box-shadow .25s; text-decoration: none; color: inherit; }
        .svc:hover { transform: translateY(-6px); box-shadow: 0 18px 34px rgba(74, 59, 50, .18); color: inherit; }
        .svc-img { position: relative; aspect-ratio: 4 / 3; background: var(--soft); overflow: hidden; }
        .svc-img img { width: 100%; height: 100%; object-fit: cover; transition: transform .4s; }
        .svc:hover .svc-img img { transform: scale(1.07); }
        .svc-badge { position: absolute; top: .7rem; left: .7rem; background: rgba(255, 255, 255, .95); color: var(--d); font-size: .74rem; font-weight: 800; padding: .28rem .75rem; border-radius: 999px; box-shadow: 0 3px 10px rgba(0, 0, 0, .12); }
        .svc-badge i { color: var(--gold); }
        .svc-body { padding: 1.1rem 1.2rem 1.2rem; display: flex; flex-direction: column; flex: 1; }
        .svc-body h6 { font-weight: 800; font-size: 1.08rem; margin: 0 0 .3rem; }
        .svc-body p { color: #85766B; font-size: .87rem; line-height: 1.45; margin: 0 0 .9rem; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
        .svc-foot { margin-top: auto; display: flex; justify-content: space-between; align-items: flex-end; }
        .svc-foot small { display: block; color: #9A8B80; font-size: .74rem; font-weight: 600; }
        .svc-foot strong { font-size: 1.25rem; color: var(--d); }
        .go { width: 40px; height: 40px; border-radius: 50%; background: var(--p); color: #fff; display: flex; align-items: center; justify-content: center; transition: background .2s, transform .2s; }
        .svc:hover .go { background: var(--d); transform: translateX(4px); }
        .more { text-align: center; margin-top: 2.2rem; }
        .btn-p { display: inline-flex; align-items: center; gap: .5rem; background: var(--p); color: #fff; padding: .85rem 1.9rem; border-radius: 14px; font-weight: 800; text-decoration: none; box-shadow: 0 8px 18px rgba(94, 67, 52, .28); transition: background .2s, transform .2s; }
        .btn-p:hover { background: var(--d); color: #fff; transform: translateY(-2px); }

        /* Cara pesan */
        .steps { position: relative; }
        .step { position: relative; background: #fff; border: 1px solid var(--line); border-radius: 22px; padding: 2.2rem 1.4rem 1.6rem; text-align: center; height: 100%; box-shadow: 0 2px 12px rgba(74, 59, 50, .06); }
        .step .no { position: absolute; top: -18px; left: 50%; transform: translateX(-50%); width: 38px; height: 38px; border-radius: 50%; background: var(--gold); color: #fff; font-weight: 800; display: flex; align-items: center; justify-content: center; border: 4px solid #FBF6EE; }
        .step .ico { width: 60px; height: 60px; font-size: 1.6rem; border-radius: 50%; }
        .step h5 { font-weight: 800; font-size: 1.05rem; }
        .step p { margin: 0; color: #85766B; font-size: .9rem; line-height: 1.55; }

        /* Tentang */
        .about { display: grid; grid-template-columns: 1.2fr 1fr; gap: 2.5rem; align-items: center; }
        .about h2 { font-weight: 800; color: var(--d); font-size: clamp(1.7rem, 3vw, 2.3rem); margin: .3rem 0 1rem; }
        .about p { color: #6B5B50; line-height: 1.8; font-size: 1.02rem; }
        .about-card { background: linear-gradient(135deg, var(--p), var(--d)); color: #fff; border-radius: 26px; padding: 2.2rem 2rem; text-align: center; box-shadow: 0 18px 36px rgba(94, 67, 52, .3); }
        .about-card .script { font-size: 2.4rem; color: #FFD9A0; line-height: 1.1; }
        .about-card p { color: #F6E8D5; margin: .6rem 0 1.3rem; }

        /* Footer */
        .ft { background: var(--d); color: #E9D6BE; text-align: center; padding: 1.6rem 1rem; font-size: .9rem; }
        .ft b { color: #FFD9A0; }

        @media (max-width: 991.98px) {
            .nv-toggle { display: inline-flex; align-items: center; justify-content: center; }
            .nv .wrap { flex-wrap: wrap; height: auto; min-height: 64px; padding-top: .6rem; padding-bottom: .6rem; }
            .nv-menu { display: none; width: 100%; flex-direction: column; gap: .6rem; padding-bottom: .5rem; }
            .nv-menu.open { display: flex; }
            .nv-links { flex-direction: column; }
            .nv-cta { width: 100%; } .nv-login, .nv-reg { flex: 1; justify-content: center; }
            .hero::before { background: linear-gradient(180deg, rgba(60, 40, 30, .85), rgba(94, 67, 52, .7)); }
            .about { grid-template-columns: 1fr; }
        }
    
        .nv-cta { align-items: center; gap: .4rem; }
        .nv-login { display: inline-flex; align-items: center; gap: .5rem; padding: .55rem 1rem; border-radius: 12px; color: #FFF3E0; font-weight: 800; font-size: .93rem; text-decoration: none; transition: background .2s; }
        .nv-login i { font-size: 1.25rem; }
        .nv-login:hover { background: rgba(255, 243, 224, .16); color: #fff; }
        .nv-reg { display: inline-flex; align-items: center; gap: .5rem; padding: .62rem 1.35rem; border-radius: 999px; background: linear-gradient(135deg, #F5C25B, #E0A21B); color: #4A2F1E; font-weight: 800; font-size: .93rem; text-decoration: none; box-shadow: 0 6px 16px rgba(224, 162, 27, .4); transition: transform .2s, box-shadow .2s; }
        .nv-reg:hover { color: #4A2F1E; transform: translateY(-2px); box-shadow: 0 10px 22px rgba(224, 162, 27, .55); }
        .pg-head { background: linear-gradient(120deg, #5E4334, #8B6F5B); color: #fff; padding: 3.2rem 0 4.2rem; text-align: center; }
        .pg-head h1 { font-weight: 800; margin: 0 0 .4rem; font-size: clamp(1.9rem, 4vw, 2.6rem); }
        .pg-head p { margin: 0; color: #F1D9B8; }
        .tabs { display: flex; justify-content: center; gap: .5rem; background: #fff; width: max-content; max-width: 92%; margin: -26px auto 2.2rem; padding: .4rem; border-radius: 16px; box-shadow: 0 10px 26px rgba(74, 59, 50, .18); position: relative; }
        .tab { border: 0; background: transparent; color: #6F6258; font-weight: 800; padding: .7rem 1.6rem; border-radius: 12px; cursor: pointer; display: inline-flex; align-items: center; gap: .5rem; transition: all .2s; }
        .tab:hover { background: var(--tint); color: var(--d); }
        .tab.on { background: linear-gradient(135deg, var(--p), var(--d)); color: #fff; box-shadow: 0 6px 14px rgba(94, 67, 52, .3); }
        .soon { text-align: center; background: #fff; border: 1px dashed #C9AF9A; border-radius: 22px; padding: 3.2rem 1rem; color: #85766B; }
        .soon i { font-size: 3rem; color: #C9AF9A; display: block; margin-bottom: .5rem; }
        .soon h5 { font-weight: 800; color: var(--d); }
    </style>
    @stack('styles')
</head>
<body>
@php
    $onHome = request()->is('/');
    $base = $onHome ? '' : url('/');
@endphp

<nav class="nv">
    <div class="wrap">
        <a href="{{ $onHome ? '#beranda' : url('/') }}" class="nv-brand"><i class="bi bi-palette-fill"></i>DeArtify</a>
        <button class="nv-toggle" id="nvToggle" aria-label="Menu"><i class="bi bi-list"></i></button>
        <div class="nv-menu" id="nvMenu" style="display:contents">
            <ul class="nv-links" id="nvLinks">
                <li><a href="{{ $base }}#beranda" data-sec="#beranda" class="{{ $onHome ? 'on' : '' }}">Beranda</a></li>
                <li><a href="{{ url('/layanan') }}" class="{{ request()->is('layanan') ? 'on' : '' }}" data-page="1">Layanan & Harga</a></li>
                <li><a href="{{ $base }}#cara" data-sec="#cara">Cara Pesan</a></li>
                <li><a href="{{ $base }}#tentang" data-sec="#tentang">Tentang Kami</a></li>
            </ul>
            <div class="nv-cta">
                <a href="{{ route('login') }}" class="nv-login"><i class="bi bi-person-circle"></i>Masuk</a>
                <a href="{{ route('register') }}" class="nv-reg"><i class="bi bi-stars"></i>Daftar Gratis</a>
            </div>
        </div>
    </div>
</nav>

@yield('content')

@include('layouts.footer')

<script>
    (function () {
        var t = document.getElementById('nvToggle'), m = document.getElementById('nvMenu');
        if (window.matchMedia('(max-width: 991.98px)').matches) { m.style.display = ''; }
        t.addEventListener('click', function () { m.style.display = ''; m.classList.toggle('open'); });
        document.querySelectorAll('#nvLinks a').forEach(function (a) { a.addEventListener('click', function () { m.classList.remove('open'); }); });

        @if ($onHome)
        var links = Array.prototype.filter.call(document.querySelectorAll('#nvLinks a[data-sec]'), function (a) { return document.querySelector(a.dataset.sec); });
        var secs = links.map(function (a) { return document.querySelector(a.dataset.sec); });
        function spy() {
            var y = window.scrollY + 120, cur = 0;
            secs.forEach(function (s, i) { if (s.offsetTop <= y) { cur = i; } });
            links.forEach(function (a, i) { a.classList.toggle('on', i === cur); });
        }
        window.addEventListener('scroll', spy, { passive: true });
        spy();
        @endif
    })();
</script>
@stack('scripts')
</body>
</html>