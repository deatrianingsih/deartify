<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Layanan & Harga - DeArtify</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=caveat:500,700|nunito:400,600,700,800" rel="stylesheet">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @include('layouts.brand')
    <style>
       html {
    scroll-behavior: smooth;
}

body {
    font-family: 'Nunito', sans-serif;
    background: #FBF6F0;
}

.wrap {
    max-width: none;
    margin: 0 auto;
    padding: 0 3.5rem;
}

section[id] {
    scroll-margin-top: 140px;
}

/* Navbar */
.w-nav {
    position: sticky;
    top: 0;
    z-index: 50;
    background: rgba(255, 255, 255, .94);
    backdrop-filter: blur(8px);
    box-shadow: 0 2px 12px rgba(74, 59, 50, .08);
}

.w-nav .wrap {
    height: 76px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
}

.w-links {
    display: flex;
    gap: .3rem;
    height: 100%;
}

.w-links a {
    display: flex;
    align-items: center;
    gap: .4rem;
    padding: 0 1rem;
    color: var(--c-text);
    font-weight: 700;
    font-size: .93rem;
    text-decoration: none;
    position: relative;
}

.w-links a:hover,
.w-links a.active {
    color: var(--c-primary);
}

.w-links a.active::after {
    content: '';
    position: absolute;
    left: .7rem;
    right: .7rem;
    bottom: 0;
    height: 3px;
    border-radius: 3px 3px 0 0;
    background: var(--c-primary);
}

.w-auth {
    display: flex;
    align-items: center;
    gap: .75rem;
}

.btn-line {
    border: 1.5px solid var(--c-mid);
    color: var(--c-dark);
    background: transparent;
    border-radius: 12px;
    padding: .55rem 1.4rem;
    font-weight: 700;
    text-decoration: none;
    transition: *background* .2s;
}

.btn-line:hover {
    background: var(--c-soft);
    color: var(--c-dark);
}

.w-auth .btn-brand {
    border-radius: 12px;
    text-decoration: none;
}

/* Header halaman */
.c-head {
    background: linear-gradient(135deg, #F8EEE2 0%, #F1DFC9 100%);
    padding: 2.6rem 0 2.2rem;
}

.c-head h1 {
    font-family: 'Caveat', cursive;
    font-size: 3.6rem;
    font-weight: 700;
    color: var(--c-dark);
    margin: 0;
    line-height: 1;
}

.c-head p {
    color: #6F5F54;
    margin: .6rem 0 0;
    max-width: 620px;
    line-height: 1.7;
}

.c-tabs {
    display: flex;
    gap: .6rem;
    margin-top: 1.4rem;
    flex-wrap: wrap;
}

.c-tabs a {
    padding: .5rem 1.2rem;
    border-radius: 999px;
    background: rgba(255, 255, 255, .7);
    border: 1.5px solid var(--c-mid);
    color: var(--c-dark);
    font-weight: 700;
    font-size: .9rem;
    text-decoration: none;
}

.c-tabs a:hover {
    background: #fff;
}

/* Section */
.w-sec {
    padding: 3rem 0;
}

.w-sec.alt {
    background: #F6EEE4;
}

.w-h {
    display: flex;
    align-items: center;
    gap: .7rem;
    font-weight: 800;
    font-size: 1.4rem;
    color: var(--c-dark);
    margin: 0 0 .4rem;
}

.w-h i {
    color: var(--c-primary);
    font-size: 1.6rem;
}

.w-sub {
    color: #85766B;
    margin: 0 0 1.8rem;
}

.w-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1.25rem;
}

/* Kartu */
.svc-card {
    display: block;
    background: #fff;
    border: 1px solid var(--c-line);
    border-radius: 18px;
    overflow: hidden;
    text-decoration: none;
    color: inherit;
    box-shadow: var(--c-shadow);
    transition: transform .2s, box-shadow .2s;
    height: 100%;
}

.svc-card.clickable {
    cursor: pointer;
}

.svc-card.clickable:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 28px rgba(74, 59, 50, .18);
}

.svc-card:focus-visible {
    outline: 3px solid var(--c-mid);
    outline-offset: 2px;
}

.svc-img {
    position: relative;
    height: 190px;
    background: var(--c-tint);
}

.svc-img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}

.svc-ph {
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--c-mid);
    font-size: 2.6rem;
}

.svc-chip {
    position: absolute;
    left: 12px;
    bottom: 12px;
    background: var(--c-soft);
    color: var(--c-dark);
    font-size: .74rem;
    font-weight: 700;
    padding: .22rem .7rem;
    border-radius: 999px;
    max-width: calc(100% - 24px);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.svc-body {
    padding: 1rem 1.1rem 1.15rem;
}

.svc-body h6 {
    font-weight: 800;
    margin-bottom: .3rem;
}

.svc-body p {
    font-size: .83rem;
    color: #85766B;
    min-height: 2.6em;
    margin-bottom: .9rem;
}

.svc-foot {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
}

.svc-foot small {
    display: block;
    font-size: .7rem;
    color: #9A8B80;
}

.svc-foot strong {
    font-size: 1.02rem;
}

.svc-go {
    width: 34px;
    height: 34px;
    border-radius: 50%;
    background: var(--c-soft);
    color: var(--c-primary);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    transition: *background* .2s, color .2s;
}

.svc-card:hover .svc-go {
    background: var(--c-primary);
    color: #fff;
}

.stock {
    font-size: .78rem;
    font-weight: 700;
    padding: .2rem .65rem;
    border-radius: 999px;
    background: #E3F1E4;
    color: #2F6B3A;
}

.stock.out {
    background: #F8D7DA;
    color: #842029;
}

.empty {
    grid-column: 1 / -1;
    text-align: center;
    color: #85766B;
    padding: 2rem 0;
}

/* Footer */
.w-footer {
    background: #EAD3C4;
    padding: 1.4rem 0;
    text-align: center;
}

.w-copy {
    font-size: .85rem;
    color: #7A6254;
    margin: 0;
}

/* Popup */
.w-modal {
    position: fixed;
    inset: 0;
    z-index: 100;
    display: none;
    align-items: center;
    justify-content: center;
    padding: 1rem;
}

.w-modal.open {
    display: flex;
}

.w-modal-backdrop {
    position: absolute;
    inset: 0;
    background: rgba(74, 59, 50, .55);
    backdrop-filter: blur(2px);
}

.w-modal-box {
    position: relative;
    background: #fff;
    border-radius: 22px;
    width: 100%;
    max-width: 440px;
    max-height: calc(100vh - 2rem);
    overflow: auto;
    box-shadow: 0 20px 50px rgba(74, 59, 50, .3);
}

.w-modal-x {
    position: absolute;
    top: 12px;
    right: 12px;
    z-index: 2;
    width: 36px;
    height: 36px;
    border: 0;
    border-radius: 50%;
    background: rgba(255, 255, 255, .92);
    color: var(--c-dark);
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 2px 8px rgba(0, 0, 0, .15);
    cursor: pointer;
}

.w-modal-img {
    height: 220px;
    background: var(--c-tint);
}

.w-modal-img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}

.w-modal-body {
    padding: 1.4rem 1.5rem 1.6rem;
}

.w-modal-chip {
    display: inline-block;
    background: var(--c-soft);
    color: var(--c-dark);
    font-size: .74rem;
    font-weight: 700;
    padding: .22rem .75rem;
    border-radius: 999px;
    margin-bottom: .6rem;
}

.w-modal-body h5 {
    font-weight: 800;
    margin: 0 0 .5rem;
    color: var(--c-text);
}

.w-modal-body p {
    color: #6F5F54;
    line-height: 1.7;
    margin: 0 0 1rem;
    white-space: pre-line;
}

.w-modal-price small {
    display: block;
    font-size: .72rem;
    color: #9A8B80;
}

.w-modal-price strong {
    font-size: 1.45rem;
    color: var(--c-dark);
}

.w-modal-note {
    display: flex;
    gap: .5rem;
    align-items: flex-start;
    background: var(--c-tint);
    color: var(--c-dark);
    border-radius: 12px;
    padding: .7rem .9rem;
    font-size: .82rem;
    margin: 1rem 0;
}

.w-modal-actions {
    display: flex;
    gap: .6rem;
    flex-wrap: wrap;
}

.w-modal-actions a {
    flex: 1;
    text-align: center;
    text-decoration: none;
    white-space: nowrap;
    border-radius: 12px;
    padding: .7rem 1rem;
}

@media (max-width: 1099.98px) {
    .w-grid {
        grid-template-columns: repeat(2, 1fr);
    }

    .w-links {
        display: none;
    }
}

@media (max-width: 767.98px) {
    .wrap {
        padding: 0 1.25rem;
    }

    .w-grid {
        grid-template-columns: 1fr;
    }

    .c-head h1 {
        font-size: 2.8rem;
    }

    .w-auth .btn-line {
        padding: .5rem 1rem;
    }
}
    </style>
</head>
<body>
    {{-- Navbar --}}
    <header class="w-nav">
        <div class="wrap">
            <a href="{{ url('/') }}" class="brand"><i class="bi bi-palette-fill"></i><span>DeArtify</span></a>

            <nav class="w-links">
                <a href="{{ url('/') }}"><i class="bi bi-house-fill"></i>Beranda</a>
                <a href="{{ route('catalog') }}" class="active">Layanan & Harga</a>
                <a href="{{ url('/') }}#cara-pesan">Cara Pesan</a>
                <a href="{{ url('/') }}#tentang">Tentang Kami</a>
            </nav>

            <div class="w-auth">
                @auth
                    <a href="{{ route('home') }}" class="btn-brand" style="text-decoration: none; border-radius: 12px;">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="btn-line">Login</a>
                    <a href="{{ route('register') }}" class="btn-brand">Daftar</a>
                @endauth
            </div>
        </div>
    </header>

    {{-- Header halaman --}}
    <section class="c-head">
        <div class="wrap">
            <h1>Layanan & Harga</h1>
            <p>Lihat-lihat dulu jasa gambar dan perlengkapan gambar kami. Kalau sudah cocok, tinggal login untuk memesan.</p>
            <div class="c-tabs">
                <a href="#jasa"><i class="bi bi-palette2"></i> Jasa Gambar</a>
                <a href="#produk"><i class="bi bi-pencil"></i> Produk</a>
            </div>
        </div>
    </section>

    {{-- Jasa gambar --}}
    <section class="w-sec" id="jasa">
        <div class="wrap">
            <h2 class="w-h"><i class="bi bi-palette2"></i>Jasa Gambar</h2>
            <p class="w-sub">Klik kartu untuk melihat detail dan harga.</p>

            <div class="w-grid">
                @forelse ($services as $service)
                    <div class="svc-card clickable" role="button" tabindex="0" data-item
                         data-id="{{ $service->id }}"
                         data-type="service"
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
                    <p class="empty">Layanan segera hadir.</p>
                @endforelse
            </div>
        </div>
    </section>

    {{-- Produk --}}
    <section class="w-sec alt" id="produk">
        <div class="wrap">
            <h2 class="w-h"><i class="bi bi-pencil"></i>Produk</h2>
            <p class="w-sub">Kertas, pulpen, pensil, dan perlengkapan gambar lainnya.</p>

            <div class="c-tabs" style="margin: 0 0 1.6rem;">
                <a href="{{ route('catalog') }}#produk" @if (!$category) style="background:#fff;border-color:var(--c-primary);" @endif>Semua</a>
                @foreach (\App\Models\Product::CATEGORIES as $key => $label)
                    <a href="{{ route('catalog', ['kategori' => $key]) }}#produk" @if ($category === $key) style="background:#fff;border-color:var(--c-primary);" @endif>{{ $label }}</a>
                @endforeach
            </div>

            <div class="w-grid">
                @forelse ($products as $product)
                    <div class="svc-card clickable" role="button" tabindex="0" data-item
                         data-type="product"
                         data-name="{{ $product->name }}"
                         data-desc="{{ $product->description }}"
                         data-price="{{ number_format($product->price, 0, ',', '.') }}"
                         data-badge="{{ $product->category_label }}"
                         data-stock="{{ $product->stock }}"
                         data-img="{{ $product->image ? Storage::url($product->image) : '' }}">
                        <div class="svc-img">
                            @if ($product->image)
                                <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}">
                            @else
                                <div class="svc-ph"><i class="bi bi-image"></i></div>
                            @endif
                            <span class="svc-chip">{{ $product->category_label }}</span>
                        </div>
                        <div class="svc-body">
                            <h6>{{ $product->name }}</h6>
                            <p>{{ Str::limit($product->description, 60) }}</p>
                            <div class="svc-foot">
                                <div>
                                    <small>Harga</small>
                                    <strong>Rp {{ number_format($product->price, 0, ',', '.') }}</strong>
                                </div>
                                <span class="stock {{ $product->stock > 0 ? '' : 'out' }}">{{ $product->stock > 0 ? 'Stok '.$product->stock : 'Habis' }}</span>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="empty">Belum ada produk{{ $category ? ' di kategori ini' : '' }}.</p>
                @endforelse
            </div>
        </div>
    </section>

    <footer class="w-footer">
        <p class="w-copy">&copy; {{ date('Y') }} DeArtify. Semua hak dilindungi.</p>
    </footer>

    {{-- Popup detail --}}
    <div class="w-modal" id="itemModal" role="dialog" aria-modal="true" aria-labelledby="itemTitle">
        <div class="w-modal-backdrop" data-close></div>
        <div class="w-modal-box">
            <button type="button" class="w-modal-x" data-close aria-label="Tutup"><i class="bi bi-x-lg"></i></button>
            <div class="w-modal-img" id="itemImg"></div>
            <div class="w-modal-body">
                <span class="w-modal-chip" id="itemBadge"></span>
                <h5 id="itemTitle"></h5>
                <p id="itemDesc"></p>
                <div class="w-modal-price">
                    <small id="itemPriceLabel">Mulai dari</small>
                    <strong id="itemPrice"></strong>
                </div>
                <div class="w-modal-note" id="itemNote"></div>
                <div class="w-modal-actions" id="itemActions"></div>
            </div>
        </div>
    </div>

    <script>
        (function () {
            var IS_AUTH = @json(auth()->check());
            var URL_LOGIN = @json(route('login'));
            var URL_REGISTER = @json(route('register'));
            var URL_ORDER = @json(route('orders.create'));

            var modal = document.getElementById('itemModal');
            var imgBox = document.getElementById('itemImg');
            var badge = document.getElementById('itemBadge');
            var title = document.getElementById('itemTitle');
            var desc = document.getElementById('itemDesc');
            var price = document.getElementById('itemPrice');
            var priceLabel = document.getElementById('itemPriceLabel');
            var note = document.getElementById('itemNote');
            var actions = document.getElementById('itemActions');
            var closeBtn = modal.querySelector('.w-modal-x');
            var lastFocus = null;

            function openModal(card) {
                var d = card.dataset;
                var isService = d.type === 'service';

                title.textContent = d.name || '';
                desc.textContent = d.desc || 'Belum ada deskripsi.';
                price.textContent = 'Rp ' + (d.price || '0');
                priceLabel.textContent = isService ? 'Mulai dari' : 'Harga';
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

                if (isService) {
                    if (IS_AUTH) {
                        note.innerHTML = '<i class="bi bi-info-circle"></i><span>Klik tombol di bawah untuk mengisi detail pesanan.</span>';
                        actions.innerHTML = '<a href="' + URL_ORDER + '?service_price_id=' + encodeURIComponent(d.id) + '" class="btn-brand">Pesan Sekarang</a>';
                    } else {
                        note.innerHTML = '<i class="bi bi-info-circle"></i><span>Untuk memesan layanan ini, silakan login atau daftar terlebih dahulu.</span>';
                        actions.innerHTML = '<a href="' + URL_LOGIN + '" class="btn-brand">Login untuk Memesan</a><a href="' + URL_REGISTER + '" class="btn-line">Daftar</a>';
                    }
                } else {
                    var stock = parseInt(d.stock || '0', 10);
                    note.innerHTML = '<i class="bi bi-box-seam"></i><span>' + (stock > 0 ? 'Stok tersedia: ' + stock + '.' : 'Stok sedang habis.') + ' Pemesanan produk segera hadir.</span>';
                    actions.innerHTML = '';
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

            document.querySelectorAll('[data-item]').forEach(function (card) {
                card.addEventListener('click', function () { openModal(card); });
                card.addEventListener('keydown', function (e) {
                    if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); openModal(card); }
                });
            });
            modal.querySelectorAll('[data-close]').forEach(function (el) { el.addEventListener('click', closeModal); });
            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape' && modal.classList.contains('open')) { closeModal(); }
            });
        })();
    </script>
</body>
</html>