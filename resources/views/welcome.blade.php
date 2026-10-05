<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DeArtify - Pesan Jasa Gambar Online</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=caveat:500,700|nunito:400,600,700,800" rel="stylesheet">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @include('layouts.brand')
    <style>
        html { scroll-behavior: smooth; }
        body { font-family: 'Nunito', sans-serif; background: #FBF6F0; }
        .wrap { max-width: 1240px; margin: 0 auto; padding: 0 1.5rem; }
        section[id] { scroll-margin-top: 84px; }

        /* ---------- Navbar ---------- */
        .w-nav { position: sticky; top: 0; z-index: 50; background: rgba(255, 255, 255, .94); backdrop-filter: blur(8px); box-shadow: 0 2px 12px rgba(74, 59, 50, .08); }
        .w-nav .wrap { height: 76px; display: flex; align-items: center; justify-content: space-between; gap: 1rem; }
        .w-links { display: flex; gap: .3rem; height: 100%; }
        .w-links a { display: flex; align-items: center; gap: .4rem; padding: 0 1rem; color: var(--c-text); font-weight: 700; font-size: .93rem; text-decoration: none; position: relative; }
        .w-links a:hover, .w-links a.active { color: var(--c-primary); }
        .w-links a.active::after { content: ''; position: absolute; left: .7rem; right: .7rem; bottom: 0; height: 3px; border-radius: 3px 3px 0 0; background: var(--c-primary); }
        .w-auth { display: flex; align-items: center; gap: .75rem; }
        .btn-line { border: 1.5px solid var(--c-mid); color: var(--c-dark); background: transparent; border-radius: 12px; padding: .55rem 1.4rem; font-weight: 700; text-decoration: none; transition: background .2s; }
        .btn-line:hover { background: var(--c-soft); color: var(--c-dark); }
        .w-auth .btn-brand { border-radius: 12px; text-decoration: none; }

        /* ---------- Hero ---------- */
        .w-hero { position: relative; overflow: hidden; background: radial-gradient(ellipse at 62% 15%, rgba(214, 183, 158, .55), transparent 42%), radial-gradient(ellipse at 6% 100%, rgba(232, 208, 188, .75), transparent 45%), linear-gradient(135deg, #F8EEE2 0%, #F4E6D6 100%); }
        .w-hero .wrap { display: grid; grid-template-columns: minmax(0, 1fr) minmax(0, 1fr); gap: 1.5rem; align-items: center; padding-top: 3.2rem; padding-bottom: 3.2rem; min-height: 450px; }
        .w-hero-text { display: flex; flex-direction: column; align-items: center; text-align: center; }
        .w-welcome { font-family: 'Caveat', cursive; font-size: 5.2rem; line-height: .9; font-weight: 700; color: var(--c-dark); display: flex; align-items: center; justify-content: center; gap: .5rem; margin: 0; }
        .w-welcome svg { width: 62px; height: 62px; flex-shrink: 0; }
        .w-sub { font-family: 'Caveat', cursive; font-size: 2.6rem; font-weight: 700; color: var(--c-text); margin: .3rem 0 1rem; line-height: 1.05; }
        .w-sub b { color: var(--c-dark); font-size: 3.2rem; }
        .w-desc { color: #6F5F54; max-width: 470px; margin: 0 auto 1.7rem; line-height: 1.75; }
        .w-cta { display: flex; flex-wrap: wrap; justify-content: center; gap: .9rem; }
        .w-cta a { padding: .8rem 1.6rem; border-radius: 12px; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: .5rem; transition: background .2s, transform .2s; }
        .w-cta .primary { background: var(--c-primary); color: #fff; box-shadow: 0 8px 20px rgba(139, 111, 91, .3); }
        .w-cta .primary:hover { background: var(--c-dark); transform: translateY(-1px); }
        .w-cta .outline { border: 1.5px solid var(--c-mid); color: var(--c-dark); background: rgba(255, 255, 255, .45); }
        .w-cta .outline:hover { background: #fff; }
        .w-art svg { width: 100%; max-width: 410px; display: block; margin: 0 auto; }

        /* ---------- Section umum ---------- */
        .w-sec { padding: 3.6rem 0; }
        .w-sec.alt { background: #F6EEE4; }
        .w-h { display: flex; align-items: center; gap: .7rem; font-weight: 800; font-size: 1.4rem; color: var(--c-dark); margin: 0 0 2rem; }
        .w-h i { color: var(--c-primary); font-size: 1.6rem; }

        /* Kenapa memilih */
        .w-why { display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.5rem; }
        .w-why-item { display: flex; gap: 1rem; align-items: flex-start; }
        .w-why-ico { flex-shrink: 0; width: 66px; height: 66px; border-radius: 52% 48% 55% 45%; background: var(--c-soft); color: var(--c-dark); display: flex; align-items: center; justify-content: center; font-size: 1.7rem; }
        .w-why-item h6 { font-weight: 800; margin: .3rem 0 .3rem; color: var(--c-text); }
        .w-why-item p { font-size: .85rem; color: #85766B; margin: 0; line-height: 1.6; }

        /* Tentang kami */
        .w-about { max-width: 780px; color: #6F5F54; line-height: 1.85; margin: 0; }

        /* Layanan */
        .w-svc-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.25rem; }
        .svc-card { display: block; background: #fff; border: 1px solid var(--c-line); border-radius: 18px; overflow: hidden; text-decoration: none; color: inherit; box-shadow: var(--c-shadow); transition: transform .2s, box-shadow .2s; height: 100%; }
        .svc-card { cursor: pointer; }
        .svc-card:hover { transform: translateY(-4px); box-shadow: 0 12px 28px rgba(74, 59, 50, .18); color: inherit; }
        .svc-card:focus-visible { outline: 3px solid var(--c-mid); outline-offset: 2px; }
        .svc-img { position: relative; height: 190px; background: var(--c-tint); }
        .svc-img img { width: 100%; height: 100%; object-fit: cover; display: block; }
        .svc-ph { height: 100%; display: flex; align-items: center; justify-content: center; color: var(--c-mid); font-size: 2.6rem; }
        .svc-chip { position: absolute; left: 12px; bottom: 12px; background: var(--c-soft); color: var(--c-dark); font-size: .74rem; font-weight: 700; padding: .22rem .7rem; border-radius: 999px; max-width: calc(100% - 24px); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .svc-body { padding: 1rem 1.1rem 1.15rem; }
        .svc-body h6 { font-weight: 800; margin-bottom: .3rem; }
        .svc-body p { font-size: .83rem; color: #85766B; min-height: 2.6em; margin-bottom: .9rem; }
        .svc-foot { display: flex; justify-content: space-between; align-items: flex-end; }
        .svc-foot small { display: block; font-size: .7rem; color: #9A8B80; }
        .svc-foot strong { font-size: 1.02rem; }
        .svc-go { width: 34px; height: 34px; border-radius: 50%; background: var(--c-soft); color: var(--c-primary); display: inline-flex; align-items: center; justify-content: center; transition: background .2s, color .2s; }
        .svc-card:hover .svc-go { background: var(--c-primary); color: #fff; }

        /* Cara pesan */
        .w-steps { display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.25rem; padding-top: 14px; }
        .w-step { background: #fff; border: 1px solid var(--c-line); border-radius: 20px; padding: 1.6rem 1.3rem; text-align: center; box-shadow: var(--c-shadow); position: relative; }
        .w-step .no { position: absolute; top: -14px; left: 50%; transform: translateX(-50%); background: var(--c-primary); color: #fff; width: 30px; height: 30px; border-radius: 50%; font-weight: 800; font-size: .85rem; display: flex; align-items: center; justify-content: center; }
        .w-step .ico { width: 62px; height: 62px; border-radius: 50%; background: var(--c-soft); color: var(--c-primary); display: flex; align-items: center; justify-content: center; font-size: 1.6rem; margin: .5rem auto 1rem; }
        .w-step h6 { font-weight: 800; margin-bottom: .35rem; }
        .w-step p { font-size: .85rem; color: #85766B; margin: 0; }

        /* Footer */
        .w-footer { background: #EAD3C4; padding: 1.4rem 0; text-align: center; }
        .w-copy { font-size: .85rem; color: #7A6254; margin: 0; }

        /* Popup deskripsi layanan */
        .w-modal { position: fixed; inset: 0; z-index: 100; display: none; align-items: center; justify-content: center; padding: 1rem; }
        .w-modal.open { display: flex; }
        .w-modal-backdrop { position: absolute; inset: 0; background: rgba(74, 59, 50, .55); backdrop-filter: blur(2px); }
        .w-modal-box { position: relative; background: #fff; border-radius: 22px; width: 100%; max-width: 440px; max-height: calc(100vh - 2rem); overflow: auto; box-shadow: 0 20px 50px rgba(74, 59, 50, .3); animation: wPop .2s ease; }
        @keyframes wPop { from { opacity: 0; transform: translateY(12px) scale(.97); } to { opacity: 1; transform: none; } }
        .w-modal-x { position: absolute; top: 12px; right: 12px; z-index: 2; width: 36px; height: 36px; border: 0; border-radius: 50%; background: rgba(255, 255, 255, .92); color: var(--c-dark); display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 8px rgba(0, 0, 0, .15); cursor: pointer; }
        .w-modal-img { height: 220px; background: var(--c-tint); }
        .w-modal-img img { width: 100%; height: 100%; object-fit: cover; display: block; }
        .w-modal-body { padding: 1.4rem 1.5rem 1.6rem; }
        .w-modal-chip { display: inline-block; background: var(--c-soft); color: var(--c-dark); font-size: .74rem; font-weight: 700; padding: .22rem .75rem; border-radius: 999px; margin-bottom: .6rem; }
        .w-modal-body h5 { font-weight: 800; margin: 0 0 .5rem; color: var(--c-text); }
        .w-modal-body p { color: #6F5F54; line-height: 1.7; margin: 0 0 1rem; white-space: pre-line; }
        .w-modal-price small { display: block; font-size: .72rem; color: #9A8B80; }
        .w-modal-price strong { font-size: 1.45rem; color: var(--c-dark); }
        .w-modal-note { display: flex; gap: .5rem; align-items: flex-start; background: var(--c-tint); color: var(--c-dark); border-radius: 12px; padding: .7rem .9rem; font-size: .82rem; margin: 1rem 0; }
        .w-modal-actions { display: flex; gap: .6rem; flex-wrap: wrap; }
        .w-modal-actions a { flex: 1; text-align: center; text-decoration: none; white-space: nowrap; border-radius: 12px; padding: .7rem 1rem; }

        /* ---------- Responsif ---------- */
        @media (max-width: 1099.98px) {
            .w-hero .wrap { grid-template-columns: 1fr; }
            .w-art { display: none; }
            .w-why { grid-template-columns: repeat(2, 1fr); }
            .w-svc-grid, .w-steps { grid-template-columns: repeat(2, 1fr); }
            .w-links { display: none; }
        }
        @media (max-width: 767.98px) {
            .w-hero .wrap { padding-top: 2.2rem; padding-bottom: 2.2rem; }
            .w-welcome { font-size: 3.8rem; }
            .w-welcome svg { width: 44px; height: 44px; }
            .w-sub { font-size: 2rem; }
            .w-sub b { font-size: 2.5rem; }
            .w-why, .w-svc-grid, .w-steps { grid-template-columns: 1fr; }
            .w-auth .btn-line { padding: .5rem 1rem; }
        }
    </style>
</head>
<body>
    {{-- Navbar --}}
    <header class="w-nav">
        <div class="wrap">
            <a href="{{ url('/') }}" class="brand"><i class="bi bi-palette-fill"></i><span>DeArtify</span></a>

            <nav class="w-links">
                <a href="#beranda" class="active"><i class="bi bi-house-fill"></i>Beranda</a>
                <a href="#layanan">Layanan & Harga</a>
                <a href="#cara-pesan">Cara Pesan</a>
                <a href="#tentang">Tentang Kami</a>
            </nav>

            <div class="w-auth">
                <a href="{{ route('login') }}" class="btn-line">Login</a>
                <a href="{{ route('register') }}" class="btn-brand">Daftar</a>
            </div>
        </div>
    </header>

    {{-- Hero --}}
    <section class="w-hero" id="beranda">
        <div class="wrap">
            <div class="w-hero-text">
                <h1 class="w-welcome">
                    <svg viewBox="0 0 64 64" aria-hidden="true" fill="none" stroke="#6B4F3F" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M30 52 C14 40 8 30 14 22 C19 16 28 18 30 26 C32 18 41 16 46 22 C52 30 46 40 30 52 Z"/>
                        <path d="M52 14 L58 10 M54 22 L61 22 M52 30 L58 34"/>
                    </svg>
                    Welcome
                </h1>
                <div class="w-sub">Selamat datang di <b>DeArtify</b></div>
                <p class="w-desc">Temukan layanan gambar terbaik sesuai kebutuhanmu. Di sini kamu bisa memesan jasa gambar dengan mudah, aman, dan praktis.</p>
                <div class="w-cta">
                    <a href="#layanan" class="primary">Lihat Layanan <i class="bi bi-arrow-right"></i></a>
                    <a href="{{ route('register') }}" class="outline">Daftar Sekarang</a>
                </div>
            </div>

            <div class="w-art">
                @include('layouts.sketch-art')
            </div>
        </div>
    </section>

    {{-- Kenapa memilih DeArtify --}}
    <section class="w-sec">
        <div class="wrap">
            <h2 class="w-h"><i class="bi bi-stars"></i>Kenapa Memilih DeArtify?</h2>
            <div class="w-why">
                <div class="w-why-item">
                    <span class="w-why-ico"><i class="bi bi-brush"></i></span>
                    <div><h6>Hasil Berkualitas</h6><p>Dikerjakan oleh tim profesional dengan hasil terbaik.</p></div>
                </div>
                <div class="w-why-item">
                    <span class="w-why-ico"><i class="bi bi-shield-check"></i></span>
                    <div><h6>Proses Aman</h6><p>Data dan transaksi kamu terlindungi.</p></div>
                </div>
                <div class="w-why-item">
                    <span class="w-why-ico"><i class="bi bi-clock"></i></span>
                    <div><h6>Pengerjaan Tepat Waktu</h6><p>Sesuai dengan estimasi waktu yang diberikan.</p></div>
                </div>
                <div class="w-why-item">
                    <span class="w-why-ico"><i class="bi bi-star"></i></span>
                    <div><h6>Harga Terjangkau</h6><p>Kualitas terbaik dengan harga yang bersahabat.</p></div>
                </div>
            </div>
        </div>
    </section>

    {{-- Layanan & Harga --}}
    <section class="w-sec alt" id="layanan">
        <div class="wrap">
            <h2 class="w-h"><i class="bi bi-palette2"></i>Layanan & Harga</h2>

            <div class="w-svc-grid">
                @forelse ($services as $service)
                    <div class="svc-card" role="button" tabindex="0" data-svc
                         data-name="{{ $service->name }}"
                         data-desc="{{ $service->description }}"
                         data-price="{{ number_format($service->price, 0, ',', '.') }}"
                         data-badge="{{ $service->badge }}"
                         data-img="{{ $service->image ? Storage::url($service->image) : '' }}">
                        <div class="svc-img">
                            @if ($service->image)
                                <img src="{{ Storage::url($service->image) }}" alt="{{ $service->name }}">
                            @else
                                <div class="svc-ph"><i class="bi bi-image"></i></div>
                            @endif
                            <span class="svc-chip">{{ $service->badge ?: $service->name }}</span>
                        </div>
                        <div class="svc-body">
                            <h6>{{ $service->name }}</h6>
                            <p>{{ Str::limit($service->description, 60) }}</p>
                            <div class="svc-foot">
                                <div>
                                    <small>Mulai dari</small>
                                    <strong>Rp {{ number_format($service->price, 0, ',', '.') }}</strong>
                                </div>
                                <span class="svc-go"><i class="bi bi-arrow-right"></i></span>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-muted text-center" style="grid-column: 1 / -1;">Layanan segera hadir.</p>
                @endforelse
            </div>
        </div>
    </section>

    {{-- Cara pesan --}}
    <section class="w-sec" id="cara-pesan">
        <div class="wrap">
            <h2 class="w-h"><i class="bi bi-list-check"></i>Cara Pesan</h2>
            <div class="w-steps">
                <div class="w-step">
                    <span class="no">1</span>
                    <div class="ico"><i class="bi bi-palette"></i></div>
                    <h6>Pilih Layanan</h6>
                    <p>Lihat daftar jasa gambar beserta harganya, lalu pilih yang kamu suka.</p>
                </div>
                <div class="w-step">
                    <span class="no">2</span>
                    <div class="ico"><i class="bi bi-cloud-arrow-up"></i></div>
                    <h6>Isi Detail & Referensi</h6>
                    <p>Ceritakan gambar yang kamu mau dan unggah gambar referensi.</p>
                </div>
                <div class="w-step">
                    <span class="no">3</span>
                    <div class="ico"><i class="bi bi-truck"></i></div>
                    <h6>Pantau Pesanan</h6>
                    <p>Cek status pesananmu dari menunggu, diproses, dikirim, sampai selesai.</p>
                </div>
                <div class="w-step">
                    <span class="no">4</span>
                    <div class="ico"><i class="bi bi-star"></i></div>
                    <h6>Terima & Beri Ulasan</h6>
                    <p>Bayar di tempat (COD), lalu beri rating dan ulasan atas hasilnya.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Tentang Kami --}}
    <section class="w-sec alt" id="tentang">
        <div class="wrap">
            <h2 class="w-h"><i class="bi bi-info-circle"></i>Tentang Kami</h2>
            <p class="w-about">DeArtify adalah aplikasi pemesanan jasa gambar online. Kamu bisa memilih layanan, menceritakan gambar yang kamu mau, mengirim referensi, lalu memantau pesananmu sampai selesai dengan mudah dan aman, semuanya dalam satu tempat.</p>
        </div>
    </section>

    {{-- Footer --}}
    <footer class="w-footer">
        <p class="w-copy">&copy; {{ date('Y') }} DeArtify. Semua hak dilindungi.</p>
    </footer>

    {{-- Popup deskripsi layanan --}}
    <div class="w-modal" id="svcModal" role="dialog" aria-modal="true" aria-labelledby="svcModalTitle">
        <div class="w-modal-backdrop" data-close></div>
        <div class="w-modal-box">
            <button type="button" class="w-modal-x" data-close aria-label="Tutup"><i class="bi bi-x-lg"></i></button>
            <div class="w-modal-img" id="svcModalImg"></div>
            <div class="w-modal-body">
                <span class="w-modal-chip" id="svcModalBadge"></span>
                <h5 id="svcModalTitle"></h5>
                <p id="svcModalDesc"></p>
                <div class="w-modal-price">
                    <small>Mulai dari</small>
                    <strong id="svcModalPrice"></strong>
                </div>
                <div class="w-modal-note"><i class="bi bi-info-circle"></i><span>Untuk memesan layanan ini, silakan login atau daftar terlebih dahulu.</span></div>
                <div class="w-modal-actions">
                    <a href="{{ route('login') }}" class="btn-brand">Login untuk Memesan</a>
                    <a href="{{ route('register') }}" class="btn-line">Daftar</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        (function () {
            // ----- Popup deskripsi layanan -----
            var modal = document.getElementById('svcModal');
            var imgBox = document.getElementById('svcModalImg');
            var badge = document.getElementById('svcModalBadge');
            var title = document.getElementById('svcModalTitle');
            var desc = document.getElementById('svcModalDesc');
            var price = document.getElementById('svcModalPrice');
            var closeBtn = modal.querySelector('.w-modal-x');
            var lastFocus = null;

            function openModal(card) {
                var d = card.dataset;
                title.textContent = d.name || '';
                desc.textContent = d.desc || 'Belum ada deskripsi untuk layanan ini.';
                price.textContent = 'Rp ' + (d.price || '0');
                badge.textContent = d.badge || '';
                badge.style.display = d.badge ? '' : 'none';

                imgBox.innerHTML = '';
                if (d.img) {
                    var img = document.createElement('img');
                    img.src = d.img;
                    img.alt = d.name || '';
                    imgBox.appendChild(img);
                } else {
                    imgBox.innerHTML = '<div class="svc-ph"><i class="bi bi-image"></i></div>';
                }

                lastFocus = document.activeElement;
                modal.classList.add('open');
                document.body.style.overflow = 'hidden';
                closeBtn.focus();
            }

            function closeModal() {
                modal.classList.remove('open');
                document.body.style.overflow = '';
                if (lastFocus) { lastFocus.focus(); }
            }

            document.querySelectorAll('[data-svc]').forEach(function (card) {
                card.addEventListener('click', function () { openModal(card); });
                card.addEventListener('keydown', function (e) {
                    if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); openModal(card); }
                });
            });
            modal.querySelectorAll('[data-close]').forEach(function (el) {
                el.addEventListener('click', closeModal);
            });
            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape' && modal.classList.contains('open')) { closeModal(); }
            });

            // ----- Menu navbar: scroll halus + penanda menu aktif -----
            var links = document.querySelectorAll('.w-links a');
            var order = ['beranda', 'layanan', 'cara-pesan', 'tentang'];

            function setActive(id) {
                links.forEach(function (a) {
                    a.classList.toggle('active', a.getAttribute('href') === '#' + id);
                });
            }

            function spy() {
                var y = window.scrollY + 140;
                var current = 'beranda';
                order.forEach(function (id) {
                    var el = document.getElementById(id);
                    if (el && el.offsetTop <= y) { current = id; }
                });
                if (window.innerHeight + window.scrollY >= document.body.scrollHeight - 4) { current = 'tentang'; }
                setActive(current);
            }

            links.forEach(function (a) {
                a.addEventListener('click', function (e) {
                    var target = document.querySelector(a.getAttribute('href'));
                    if (target) {
                        e.preventDefault();
                        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                        setActive(target.id);
                    }
                });
            });
            window.addEventListener('scroll', spy, { passive: true });
            spy();
        })();
    </script>
</body>
</html>