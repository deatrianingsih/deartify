@extends('layouts.public')

@section('title', 'Layanan & Harga - DeArtify')

@section('content')
@php
    $all = $services ?? \App\Models\ServicePrice::latest()->get();
    $items = $products ?? collect();
@endphp

<header class="pg-head">
    <div class="wrap">
        <h1>Layanan & Harga</h1>
        <p>Lihat-lihat dulu jasa gambar dan perlengkapan gambar kami. Kalau sudah cocok, tinggal login untuk memesan.</p>
    </div>
</header>

<div class="tabs" id="tabs">
    <button type="button" class="tab on" data-tab="layanan"><i class="bi bi-palette"></i>Jasa Gambar</button>
    <button type="button" class="tab" data-tab="produk"><i class="bi bi-pencil"></i>Produk <span class="cnt">{{ $items->count() }}</span></button>
</div>

<section class="sec" style="padding-top:0;">
    <div class="wrap">
        <div id="pane-layanan">
            <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 g-4">
                @forelse ($all as $s)
                    <div class="col">
                        <div class="svc" role="button" tabindex="0" data-detail
                             data-kind="Jasa Gambar" data-name="{{ $s->name }}" data-desc="{{ $s->description }}"
                             data-price="Rp{{ number_format($s->price, 0, ',', '.') }}" data-badge="{{ $s->badge }}"
                             data-img="{{ $s->image ? Storage::url($s->image) : '' }}">
                            <div class="svc-img">
                                @if ($s->image)<img src="{{ Storage::url($s->image) }}" alt="{{ $s->name }}" loading="lazy">@endif
                                @if ($s->badge)<span class="svc-badge"><i class="bi bi-star-fill"></i> {{ $s->badge }}</span>@endif
                            </div>
                            <div class="svc-body">
                                <h6>{{ $s->name }}</h6>
                                <p>{{ $s->description }}</p>
                                <div class="svc-foot">
                                    <div><small>Mulai dari</small><strong>Rp{{ number_format($s->price, 0, ',', '.') }}</strong></div>
                                    <span class="go"><i class="bi bi-arrow-right"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12"><div class="soon"><i class="bi bi-palette"></i><h5>Belum ada layanan</h5></div></div>
                @endforelse
            </div>
            <div class="more"><a href="{{ route('login') }}" class="btn-p">Login untuk Memesan <i class="bi bi-arrow-right"></i></a></div>
        </div>

        <div id="pane-produk" style="display:none;">
            <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 g-4">
                @forelse ($items as $p)
                    <div class="col">
                        <div class="svc" role="button" tabindex="0" data-detail
                             data-kind="Produk" data-name="{{ $p->name }}" data-desc="{{ $p->description ?? '' }}"
                             data-price="Rp{{ number_format($p->price ?? 0, 0, ',', '.') }}" data-badge="{{ isset($p->stock) && $p->stock <= 0 ? 'Stok habis' : '' }}"
                             data-img="{{ !empty($p->image) ? Storage::url($p->image) : '' }}">
                            <div class="svc-img">
                                @if (!empty($p->image))<img src="{{ Storage::url($p->image) }}" alt="{{ $p->name }}" loading="lazy">
                                @else<div class="ph"><i class="bi bi-image"></i></div>@endif
                                @if (isset($p->stock) && $p->stock <= 0)<span class="svc-badge">Stok habis</span>@endif
                            </div>
                            <div class="svc-body">
                                <h6>{{ $p->name }}</h6>
                                @if (!empty($p->description))<p>{{ $p->description }}</p>@endif
                                <div class="svc-foot">
                                    <div><small>Harga</small><strong>Rp{{ number_format($p->price ?? 0, 0, ',', '.') }}</strong></div>
                                    <span class="go"><i class="bi bi-arrow-right"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12"><div class="soon"><i class="bi bi-bag-heart"></i><h5>Belum ada produk</h5><p class="mb-0">Produk akan segera tersedia.</p></div></div>
                @endforelse
            </div>
        </div>
    </div>
</section>

<dialog id="dtl" class="dtl">
    <button type="button" class="dtl-x" id="dtlClose" aria-label="Tutup"><i class="bi bi-x-lg"></i></button>
    <div class="dtl-img" id="dtlImg"></div>
    <div class="dtl-body">
        <div class="dtl-meta"><span class="dtl-kind" id="dtlKind"></span><span class="dtl-badge" id="dtlBadge"></span></div>
        <h4 id="dtlName"></h4>
        <div class="dtl-lbl">Deskripsi</div>
        <p class="dtl-desc" id="dtlDesc"></p>
        <div class="dtl-foot">
            <div class="dtl-price"><small>Mulai dari</small><strong id="dtlPrice"></strong></div>
            <a href="{{ route('login') }}" class="dtl-cta"><i class="bi bi-box-arrow-in-right"></i>Login untuk Memesan</a>
            <div class="dtl-hint">Belum punya akun? <a href="{{ route('register') }}">Daftar gratis</a></div>
        </div>
    </div>
</dialog>
@endsection

@push('styles')
<style>
.svc[data-detail]{cursor:pointer}
.dtl{border:0;outline:0;padding:0;background:#fff;color:#4A3B32;border-radius:26px;width:min(880px,94vw);max-height:90vh;overflow:hidden;box-shadow:0 30px 80px rgba(40,25,15,.45);position:fixed;inset:0;margin:auto}
.dtl[open]{display:grid;grid-template-columns:1fr 1fr;animation:dtlIn .28s ease}
.dtl::backdrop{background:rgba(60,40,30,.6);backdrop-filter:blur(4px)}
@keyframes dtlIn{from{opacity:0;transform:translateY(16px) scale(.97)}to{opacity:1;transform:none}}
.dtl-x{position:absolute;top:.9rem;right:.9rem;z-index:3;width:38px;height:38px;border-radius:50%;border:0;background:#F5EAD8;color:#5E4334;display:flex;align-items:center;justify-content:center;transition:background .2s,transform .2s}
.dtl-x:hover{background:#EDDECA;transform:rotate(90deg)}
.dtl-img{position:relative;background:linear-gradient(145deg,#F5EAD8,#E6D2B8);min-height:420px;display:flex;align-items:center;justify-content:center;color:#C9AF9A;font-size:3.5rem}
.dtl-pic{position:absolute;inset:1.1rem;border-radius:20px;overflow:hidden;box-shadow:0 10px 24px rgba(74,59,50,.22);background:#fff}.dtl-pic img{width:100%;height:100%;object-fit:cover;transform:scale(1.08);display:block}
.dtl-body{padding:2rem 2rem 1.8rem;display:flex;flex-direction:column;overflow:auto;max-height:90vh}
.dtl-meta{display:flex;gap:.5rem;flex-wrap:wrap;margin:0 2.5rem .9rem 0}
.dtl-kind{background:#F5EAD8;color:#5E4334;font-weight:800;font-size:.76rem;padding:.3rem .85rem;border-radius:999px}
.dtl-badge{background:#E0A21B;color:#fff;font-weight:800;font-size:.76rem;padding:.3rem .85rem;border-radius:999px}
.dtl-badge:empty{display:none}
.dtl h4{font-family:'Nunito',sans-serif;font-weight:800;font-size:1.7rem;color:#4A3B32;margin:0 0 .6rem;line-height:1.2}
.dtl-lbl{font-size:.72rem;font-weight:800;letter-spacing:.1em;text-transform:uppercase;color:#9A7B66;margin-bottom:.3rem}
.dtl-desc{color:#6B5B50;line-height:1.7;white-space:pre-line;margin:0 0 1.2rem;font-size:.98rem}
.dtl-foot{margin-top:auto}
.dtl-price{background:#FBF3E8;border:1px solid #EFE3D3;border-radius:16px;padding:.8rem 1.1rem;display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem}
.dtl-price small{color:#85766B;font-weight:700}
.dtl-price strong{font-size:1.65rem;color:#5E4334}
.dtl-cta{display:flex;align-items:center;justify-content:center;gap:.5rem;width:100%;padding:.9rem 1rem;border-radius:14px;background:linear-gradient(135deg,#8B6F5B,#5E4334);color:#fff;font-weight:800;text-decoration:none;box-shadow:0 8px 18px rgba(94,67,52,.3);transition:transform .2s,box-shadow .2s}
.dtl-cta:hover{color:#fff;transform:translateY(-2px);box-shadow:0 12px 24px rgba(94,67,52,.38)}
.dtl-hint{text-align:center;margin-top:.8rem;color:#85766B;font-size:.88rem}
.dtl-hint a{color:#8B6F5B;font-weight:800}
/* Popup: tinggi tetap, deskripsi panjang bisa digulir sendiri, judul/harga/tombol selalu terlihat */
.dtl[open]{height:min(580px,90vh)}
.dtl-img{min-height:0;height:100%}
.dtl-body{overflow:hidden;max-height:none;height:100%;min-height:0}
.dtl-desc{flex:1;min-height:0;overflow:auto;padding-right:.7rem;margin-bottom:1rem;font-size:.94rem;line-height:1.6;scrollbar-width:thin;scrollbar-color:#C9AF9A transparent}
.dtl-desc::-webkit-scrollbar{width:6px}.dtl-desc::-webkit-scrollbar-thumb{background:#C9AF9A;border-radius:6px}
.dtl.is-prd .dtl-pic{background:#fff}
.dtl.is-prd .dtl-img{background:linear-gradient(145deg,#FBF5EC,#F1E4D0)}
.dtl.is-prd .dtl-pic img{object-fit:contain;transform:none;padding:.4rem}
@media (max-width:720px){.dtl[open]{display:block;overflow:auto}.dtl-img{min-height:0;aspect-ratio:4/3}.dtl-body{padding:1.3rem 1.3rem 1.5rem;max-height:none}.dtl-x{background:rgba(255,255,255,.95)}}
@media (max-width:720px){.dtl[open]{height:auto;max-height:92vh}.dtl-body{height:auto;overflow:visible}.dtl-desc{overflow:visible}.dtl-img{height:auto}}
.cnt{background:rgba(0,0,0,.12);border-radius:999px;padding:0 .55rem;font-size:.8rem}.tab.on .cnt{background:rgba(255,255,255,.25)}.ph{height:100%;display:flex;align-items:center;justify-content:center;color:#C9AF9A;font-size:2.4rem}</style>
@endpush

@push('scripts')
<script>
    document.querySelectorAll('#tabs .tab').forEach(function (b) {
        b.addEventListener('click', function () {
            document.querySelectorAll('#tabs .tab').forEach(function (x) { x.classList.toggle('on', x === b); });
            document.getElementById('pane-layanan').style.display = b.dataset.tab === 'layanan' ? '' : 'none';
            document.getElementById('pane-produk').style.display = b.dataset.tab === 'produk' ? '' : 'none';
        });
    });

    (function () {
        var d = document.getElementById('dtl');
        function open(el) {
            var q = function (id) { return document.getElementById(id); };
            q('dtlKind').textContent = el.dataset.kind;
            q('dtlBadge').textContent = el.dataset.badge || '';
            q('dtlName').textContent = el.dataset.name;
            q('dtlDesc').textContent = el.dataset.desc || 'Belum ada deskripsi.';
            q('dtlPrice').textContent = el.dataset.price;
            var img = q('dtlImg'); img.innerHTML = '';
            if (el.dataset.img) { var w = document.createElement('div'); w.className = 'dtl-pic'; var i = document.createElement('img'); i.src = el.dataset.img; i.alt = el.dataset.name; w.appendChild(i); img.appendChild(w); }
            else { img.innerHTML = '<i class="bi bi-image"></i>'; }
            d.classList.toggle('is-prd', el.dataset.kind === 'Produk');
            d.showModal();
        }
        document.querySelectorAll('[data-detail]').forEach(function (el) {
            el.addEventListener('click', function () { open(el); });
            el.addEventListener('keydown', function (e) { if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); open(el); } });
        });
        document.getElementById('dtlClose').addEventListener('click', function () { d.close(); });
        d.addEventListener('click', function (e) { if (e.target === d) { d.close(); } });
    })();
</script>
@endpush