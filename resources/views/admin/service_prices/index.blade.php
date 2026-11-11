@extends('layouts.dashboard')

@push('styles')
<style>
    .sv-wrap { max-width: 1280px; margin: 0 auto; }

    /* Header */
    .sv-head { display: flex; justify-content: space-between; align-items: flex-end; gap: 1rem; flex-wrap: wrap; margin-bottom: 1.3rem; }
    .sv-head h3 { margin: 0 0 .2rem; font-weight: 800; color: var(--c-text, #4A3B32); display: flex; align-items: center; gap: .6rem; }
    .sv-head h3 i { color: var(--c-primary, #8B6F5B); }
    .sv-head p { margin: 0; color: #85766B; }
    .sv-add { display: inline-flex; align-items: center; gap: .45rem; background: var(--c-primary, #8B6F5B); color: #fff; border-radius: 12px; padding: .7rem 1.2rem; font-weight: 800; font-size: .92rem; text-decoration: none; }
    .sv-add:hover { background: var(--c-dark, #6B4F3F); color: #fff; }

    /* Toolbar: cari + filter */
    .sv-bar { display: flex; gap: .9rem; align-items: center; flex-wrap: wrap; background: #fff; border-radius: 16px; box-shadow: 0 2px 12px rgba(74, 59, 50, .07); padding: .8rem 1rem; margin-bottom: 1.3rem; }
    .sv-search { position: relative; flex: 1; min-width: 220px; max-width: 340px; }
    .sv-search i { position: absolute; left: .95rem; top: 50%; transform: translateY(-50%); color: var(--c-mid, #C9AF9A); }
    .sv-search input { width: 100%; border: 1.5px solid var(--c-line, #EFE3D3); border-radius: 12px; padding: .6rem 1rem .6rem 2.5rem; background: #FDFAF6; font-size: .92rem; }
    .sv-search input:focus { outline: none; border-color: var(--c-primary, #8B6F5B); background: #fff; box-shadow: 0 0 0 .2rem rgba(139, 111, 91, .15); }
    .sv-chips { display: flex; gap: .5rem; flex-wrap: wrap; }
    .sv-chip { border: 1.5px solid var(--c-line, #EFE3D3); background: #fff; color: #6F6258; border-radius: 999px; padding: .4rem 1rem; font-weight: 700; font-size: .85rem; cursor: pointer; transition: all .15s; }
    .sv-chip:hover { border-color: var(--c-mid, #C9AF9A); color: var(--c-dark, #6B4F3F); }
    .sv-chip.active { background: var(--c-primary, #8B6F5B); border-color: var(--c-primary, #8B6F5B); color: #fff; }
    .sv-count { margin-left: auto; color: #85766B; font-size: .88rem; font-weight: 600; }

    /* Kartu layanan */
    .sv-card { display: flex; flex-direction: column; height: 100%; background: #fff; border-radius: 20px; overflow: hidden; border: 1px solid var(--c-line, #EFE3D3); box-shadow: 0 2px 12px rgba(74, 59, 50, .06); transition: transform .2s, box-shadow .2s; }
    .sv-card:hover { transform: translateY(-5px); box-shadow: 0 16px 32px rgba(74, 59, 50, .16); }
    .sv-img { position: relative; aspect-ratio: 4 / 3; background: var(--c-soft, #EDDECA); overflow: hidden; }
    .sv-img img { width: 100%; height: 100%; object-fit: cover; display: block; transition: transform .4s; }
    .sv-card:hover .sv-img img { transform: scale(1.06); }
    .sv-ph { height: 100%; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: .3rem; color: var(--c-mid, #C9AF9A); font-size: .85rem; }
    .sv-ph i { font-size: 2.2rem; }
    .sv-badge { position: absolute; top: .75rem; left: .75rem; display: inline-flex; align-items: center; gap: .3rem; background: rgba(255, 255, 255, .95); color: var(--c-dark, #6B4F3F); font-size: .74rem; font-weight: 800; padding: .3rem .75rem; border-radius: 999px; box-shadow: 0 3px 10px rgba(0, 0, 0, .12); }
    .sv-badge i { color: #E0A21B; }
    .sv-body { padding: 1.1rem 1.2rem 1.25rem; display: flex; flex-direction: column; flex: 1; }
    .sv-body h6 { font-weight: 800; font-size: 1.08rem; margin: 0 0 .35rem; color: var(--c-text, #4A3B32); }
    .sv-desc { color: #85766B; font-size: .87rem; line-height: 1.45; margin: 0 0 .9rem; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; min-height: 2.5em; }
    .sv-foot { margin-top: auto; }
    .sv-price small { display: block; color: #9A8B80; font-size: .74rem; font-weight: 600; }
    .sv-price strong { font-size: 1.3rem; color: var(--c-dark, #6B4F3F); }
    .sv-btn { display: flex; align-items: center; justify-content: center; gap: .5rem; width: 100%; margin-top: .9rem; padding: .75rem 1rem; border-radius: 12px; background: var(--c-primary, #8B6F5B); color: #fff; font-weight: 800; font-size: .93rem; text-decoration: none; border: 0; transition: background .2s; }
    .sv-btn:hover { background: var(--c-dark, #6B4F3F); color: #fff; }
    .sv-btn i { transition: transform .2s; }
    .sv-btn:hover i { transform: translateX(4px); }
    .sv-admin { display: flex; gap: .55rem; margin-top: .9rem; }
    .sv-admin form { margin: 0; }
    .sv-ab { display: inline-flex; align-items: center; justify-content: center; gap: .4rem; padding: .6rem .9rem; border-radius: 11px; font-weight: 800; font-size: .86rem; text-decoration: none; cursor: pointer; border: 1.5px solid var(--c-mid, #C9AF9A); background: #fff; color: var(--c-dark, #6B4F3F); }
    .sv-ab:hover { background: var(--c-tint, #F5EAD8); color: var(--c-dark, #6B4F3F); }
    .sv-ab.edit { flex: 1; background: var(--c-primary, #8B6F5B); border-color: var(--c-primary, #8B6F5B); color: #fff; }
    .sv-ab.edit:hover { background: var(--c-dark, #6B4F3F); color: #fff; }
    .sv-ab.del { border-color: #E3A9A9; color: #B3402F; }
    .sv-ab.del:hover { background: #FBEAEA; color: #B3402F; }

    .sv-empty { display: none; text-align: center; background: #fff; border-radius: 18px; padding: 2.8rem 1rem; color: #85766B; box-shadow: 0 2px 12px rgba(74, 59, 50, .07); }
    .sv-empty i { font-size: 2.8rem; color: var(--c-mid, #C9AF9A); display: block; margin-bottom: .4rem; }

    @media (max-width: 575.98px) {
        .sv-search { max-width: none; }
        .sv-count { margin-left: 0; width: 100%; }
    }

    .sv-card[data-detail] { cursor: pointer; }
    .sv-acts { display: flex; gap: .5rem; margin-top: .9rem; }
    .sv-acts .sv-btn { margin-top: 0; flex: 1; width: auto; cursor: pointer; }
    .sv-cart { flex-shrink: 0; width: 46px; border-radius: 12px; border: 1.5px solid var(--c-primary, #8B6F5B); background: #fff; color: var(--c-primary, #8B6F5B); font-size: 1.15rem; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all .2s; }
    .sv-cart:hover { background: var(--c-primary, #8B6F5B); color: #fff; }
    .dtl-acts { display: flex; gap: .6rem; }
    .dtl-acts .dtl-cta { flex: 1; width: auto; border: 0; cursor: pointer; }
    .dtl-addcart { flex-shrink: 0; display: flex; align-items: center; justify-content: center; gap: .4rem; padding: 0 1.1rem; border-radius: 14px; border: 1.5px solid #8B6F5B; background: #fff; color: #5E4334; font-weight: 800; cursor: pointer; transition: all .2s; }
    .dtl-addcart:hover { background: #8B6F5B; color: #fff; }
    .sv-tabs { display: inline-flex; gap: .3rem; background: #fff; border: 1px solid var(--c-line, #EFE3D3); border-radius: 14px; padding: .3rem; margin-bottom: 1.2rem; box-shadow: 0 2px 10px rgba(74, 59, 50, .06); }
    .sv-tab { border: 0; background: transparent; color: #6F6258; font-weight: 800; font-size: .92rem; padding: .55rem 1.3rem; border-radius: 10px; cursor: pointer; display: inline-flex; align-items: center; gap: .45rem; transition: all .15s; }
    .sv-tab:hover { color: var(--c-dark, #6B4F3F); }
    .sv-tab.active { background: var(--c-primary, #8B6F5B); color: #fff; }
    .sv-pane[hidden] { display: none; }
    .sv-stock { position: absolute; top: .75rem; right: .75rem; background: rgba(255, 255, 255, .95); color: #2F7D4F; font-size: .74rem; font-weight: 800; padding: .3rem .75rem; border-radius: 999px; box-shadow: 0 3px 10px rgba(0, 0, 0, .12); }
    .sv-stock.out { color: #B3402F; }
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
.dtl.is-prd .dtl-pic,.dtl.is-prd .dtl-img{background:#fff}
.dtl.is-prd .dtl-img{background:linear-gradient(145deg,#FBF5EC,#F1E4D0)}
.dtl.is-prd .dtl-pic img{object-fit:contain;transform:none;padding:.4rem}
@media (max-width:720px){.dtl[open]{display:block;overflow:auto}.dtl-img{min-height:0;aspect-ratio:4/3}.dtl-body{padding:1.3rem 1.3rem 1.5rem;max-height:none}.dtl-x{background:rgba(255,255,255,.95)}}
@media (max-width:720px){.dtl[open]{height:auto;max-height:92vh}.dtl-body{height:auto;overflow:visible}.dtl-desc{overflow:visible}.dtl-img{height:auto}}
</style>
@endpush

@section('content')
@php
    $isAdmin = auth()->user()->isAdmin();
    $badges = $servicePrices->pluck('badge')->filter()->unique()->values();
@endphp

<div class="sv-wrap">
    <div class="sv-head">
        <div>
            <h3><i class="bi bi-palette"></i>Layanan & Harga</h3>
            <p>
                @if ($isAdmin)
                    Kelola layanan ilustrasi dan atur harga jasa yang tersedia.
                @else
                    Pilih jasa gambar yang kamu suka, lalu pesan dengan mudah.
                @endif
            </p>
        </div>
        @if ($isAdmin)
            <a href="{{ route('service_prices.create') }}" class="sv-add"><i class="bi bi-plus-lg"></i>Tambah Harga Jasa</a>
        @endif
    </div>

    @unless ($isAdmin)
        <div class="sv-tabs" role="tablist">
            <button type="button" class="sv-tab active" data-tab="svcPane"><i class="bi bi-palette"></i>Jasa Gambar</button>
            <button type="button" class="sv-tab" data-tab="prdPane"><i class="bi bi-bag-heart"></i>Produk</button>
        </div>
    @endunless

    <div class="sv-pane" id="svcPane">
    {{-- Cari & filter --}}
    <div class="sv-bar">
        <div class="sv-search">
            <i class="bi bi-search"></i>
            <input type="text" id="svSearch" placeholder="Cari layanan...">
        </div>
        @if ($badges->isNotEmpty())
            <div class="sv-chips" id="svChips">
                <button type="button" class="sv-chip active" data-badge="">Semua</button>
                @foreach ($badges as $badge)
                    <button type="button" class="sv-chip" data-badge="{{ $badge }}">{{ $badge }}</button>
                @endforeach
            </div>
        @endif
        <div class="sv-count" id="svCount"></div>
    </div>

    {{-- Daftar layanan --}}
    <div class="row row-cols-1 row-cols-sm-2 row-cols-xl-4 g-3" id="svGrid">
        @forelse ($servicePrices as $servicePrice)
            <div class="col sv-item"
                 data-badge="{{ $servicePrice->badge }}"
                 data-search="{{ Str::lower($servicePrice->name . ' ' . $servicePrice->description) }}">
                <div class="sv-card" role="button" tabindex="0" data-detail data-type="service" data-id="{{ $servicePrice->id }}"
                     data-name="{{ $servicePrice->name }}" data-desc="{{ $servicePrice->description }}"
                     data-price="Rp{{ number_format($servicePrice->price, 0, ',', '.') }}" data-badge="{{ $servicePrice->badge }}"
                     data-img="{{ $servicePrice->image ? Storage::url($servicePrice->image) : '' }}"
                     data-order="{{ route('orders.create', ['service_price_id' => $servicePrice->id]) }}">
                    <div class="sv-img">
                        @if ($servicePrice->image)
                            <img src="{{ Storage::url($servicePrice->image) }}" alt="{{ $servicePrice->name }}" loading="lazy">
                        @else
                            <div class="sv-ph"><i class="bi bi-image"></i>Tidak ada gambar</div>
                        @endif
                        @if ($servicePrice->badge)
                            <span class="sv-badge"><i class="bi bi-star-fill"></i>{{ $servicePrice->badge }}</span>
                        @endif
                    </div>
                    <div class="sv-body">
                        <h6>{{ $servicePrice->name }}</h6>
                        <p class="sv-desc">{{ $servicePrice->description ?: 'Belum ada deskripsi.' }}</p>

                        <div class="sv-foot">
                            <div class="sv-price">
                                <small>Mulai dari</small>
                                <strong>Rp{{ number_format($servicePrice->price, 0, ',', '.') }}</strong>
                            </div>

                            @if ($isAdmin)
                                <div class="sv-admin">
                                    <a href="{{ route('service_prices.edit', $servicePrice) }}" class="sv-ab edit"><i class="bi bi-pencil-square"></i>Edit</a>
                                    <form action="{{ route('service_prices.destroy', $servicePrice) }}" method="POST" onsubmit="return confirm('Yakin hapus layanan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="sv-ab del" title="Hapus"><i class="bi bi-trash"></i></button>
                                    </form>
                                </div>
                            @else
                                <form action="{{ route('cart.add') }}" method="POST" class="sv-acts">
                                    @csrf
                                    <input type="hidden" name="type" value="service">
                                    <input type="hidden" name="id" value="{{ $servicePrice->id }}">
                                    <button type="submit" name="buy" value="0" class="sv-cart" title="Masukkan keranjang" aria-label="Masukkan keranjang"><i class="bi bi-cart-plus"></i></button>
                                    <button type="submit" name="buy" value="1" class="sv-btn">Pesan Sekarang <i class="bi bi-arrow-right"></i></button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12"><div class="sv-empty" style="display:block;"><i class="bi bi-palette"></i>Belum ada data harga jasa.</div></div>
        @endforelse
    </div>

    <div class="sv-empty" id="svNone"><i class="bi bi-search"></i>Tidak ada layanan yang cocok dengan pencarianmu.</div>

    <div class="mt-4">
        {{ $servicePrices->links('pagination::bootstrap-5') }}
    </div>
    </div>{{-- /svcPane --}}

    @unless ($isAdmin)
        @php
            $products = \App\Models\Product::latest()->get();
        @endphp
        <div class="sv-pane" id="prdPane" hidden>
            <div class="sv-bar">
                <div class="sv-search">
                    <i class="bi bi-search"></i>
                    <input type="text" id="prdSearch" placeholder="Cari produk...">
                </div>
                <div class="sv-count" id="prdCount"></div>
            </div>

            <div class="row row-cols-1 row-cols-sm-2 row-cols-xl-4 g-3" id="prdGrid">
                @forelse ($products as $product)
                    @php
                        $pDesc = trim(str_replace('**', '', (string) $product->description));
                        $inStock = $product->stock > 0;
                    @endphp
                    <div class="col prd-item" data-search="{{ Str::lower($product->name . ' ' . $pDesc . ' ' . $product->category_label) }}">
                        <div class="sv-card" role="button" tabindex="0" data-detail data-kind="Produk" data-type="product" data-id="{{ $product->id }}" data-soldout="{{ $inStock ? 0 : 1 }}"
                             data-name="{{ $product->name }}" data-desc="{{ $pDesc }}"
                             data-price="Rp{{ number_format($product->price, 0, ',', '.') }}" data-badge="{{ $product->category_label }}"
                             data-img="{{ $product->image ? Storage::url($product->image) : '' }}"
                             data-order="">
                            <div class="sv-img">
                                @if ($product->image)
                                    <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" loading="lazy">
                                @else
                                    <div class="sv-ph"><i class="bi bi-image"></i>Tidak ada gambar</div>
                                @endif
                                <span class="sv-badge"><i class="bi bi-star-fill"></i>{{ $product->category_label }}</span>
                                <span class="sv-stock {{ $product->stock > 0 ? '' : 'out' }}">{{ $product->stock > 0 ? 'Stok ' . $product->stock : 'Habis' }}</span>
                            </div>
                            <div class="sv-body">
                                <h6>{{ $product->name }}</h6>
                                <p class="sv-desc">{{ $pDesc ?: 'Belum ada deskripsi.' }}</p>

                                <div class="sv-foot">
                                    <div class="sv-price">
                                        <small>Harga</small>
                                        <strong>Rp{{ number_format($product->price, 0, ',', '.') }}</strong>
                                    </div>
                                    @if ($inStock)
                                        <form action="{{ route('cart.add') }}" method="POST" class="sv-acts">
                                            @csrf
                                            <input type="hidden" name="type" value="product">
                                            <input type="hidden" name="id" value="{{ $product->id }}">
                                            <button type="submit" name="buy" value="0" class="sv-cart" title="Masukkan keranjang" aria-label="Masukkan keranjang"><i class="bi bi-cart-plus"></i></button>
                                            <button type="submit" name="buy" value="1" class="sv-btn">Pesan Sekarang <i class="bi bi-arrow-right"></i></button>
                                        </form>
                                    @else
                                        <span class="sv-btn" style="background:#C9BFB5;cursor:not-allowed;">Stok Habis</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12"><div class="sv-empty" style="display:block;"><i class="bi bi-bag"></i>Belum ada produk.</div></div>
                @endforelse
            </div>
            <div class="sv-empty" id="prdNone"><i class="bi bi-search"></i>Tidak ada produk yang cocok dengan pencarianmu.</div>
        </div>
    @endunless
</div>

<dialog id="dtl" class="dtl">
    <button type="button" class="dtl-x" id="dtlClose" aria-label="Tutup"><i class="bi bi-x-lg"></i></button>
    <div class="dtl-img" id="dtlImg"></div>
    <div class="dtl-body">
        <div class="dtl-meta"><span class="dtl-kind" id="dtlKind">Jasa Gambar</span><span class="dtl-badge" id="dtlBadge"></span></div>
        <h4 id="dtlName"></h4>
        <div class="dtl-lbl">Deskripsi</div>
        <p class="dtl-desc" id="dtlDesc"></p>
        <div class="dtl-foot">
            <div class="dtl-price"><small id="dtlPriceLbl">Mulai dari</small><strong id="dtlPrice"></strong></div>
            @unless ($isAdmin)
                <form action="{{ route('cart.add') }}" method="POST" id="dtlForm" class="dtl-acts">
                    @csrf
                    <input type="hidden" name="type" id="dtlType" value="service">
                    <input type="hidden" name="id" id="dtlId" value="">
                    <button type="submit" name="buy" value="0" class="dtl-addcart" title="Masukkan keranjang"><i class="bi bi-cart-plus"></i>Keranjang</button>
                    <button type="submit" name="buy" value="1" class="dtl-cta"><i class="bi bi-bag-plus"></i>Pesan Sekarang</button>
                </form>
            @endunless
        </div>
    </div>
</dialog>

<script>
    (function () {
        var items = document.querySelectorAll('.sv-item');

        var search = document.getElementById('svSearch');
        var chips = document.querySelectorAll('#svChips .sv-chip');
        var none = document.getElementById('svNone');
        var count = document.getElementById('svCount');
        var activeBadge = '';

        // Isi kolom cari dari ?q= (datang dari dashboard)
        var qParam = new URLSearchParams(location.search).get('q');
        if (qParam && search) { search.value = qParam; }

        // Tab Jasa Gambar / Produk
        var tabs = document.querySelectorAll('.sv-tab');
        function showTab(id) {
            tabs.forEach(function (t) { t.classList.toggle('active', t.dataset.tab === id); });
            document.querySelectorAll('.sv-pane').forEach(function (p) { p.hidden = p.id !== id; });
            try { history.replaceState(null, '', id === 'prdPane' ? '#produk' : location.pathname + location.search); } catch (e) {}
        }
        tabs.forEach(function (t) { t.addEventListener('click', function () { showTab(t.dataset.tab); }); });
        if (location.hash === '#produk' && tabs.length) { showTab('prdPane'); }

        // Produk: cari
        var pItems = document.querySelectorAll('.prd-item');
        var pSearch = document.getElementById('prdSearch');
        if (pSearch) {
            var pApply = function () {
                var q = pSearch.value.trim().toLowerCase(), n = 0;
                pItems.forEach(function (el) {
                    var ok = !q || el.dataset.search.indexOf(q) !== -1;
                    el.style.display = ok ? '' : 'none';
                    if (ok) { n++; }
                });
                document.getElementById('prdNone').style.display = (pItems.length && n === 0) ? 'block' : 'none';
                document.getElementById('prdCount').textContent = n + ' produk';
            };
            pSearch.addEventListener('input', pApply);
            pApply();
        }

        function apply() {
            var q = search.value.trim().toLowerCase();
            var shown = 0;
            items.forEach(function (el) {
                var okBadge = !activeBadge || el.dataset.badge === activeBadge;
                var okText = !q || el.dataset.search.indexOf(q) !== -1;
                var show = okBadge && okText;
                el.style.display = show ? '' : 'none';
                if (show) { shown++; }
            });
            none.style.display = shown === 0 ? 'block' : 'none';
            count.textContent = shown + ' layanan';
        }

        // Detail layanan (popup)
        var dlg = document.getElementById('dtl');
        function openDetail(el) {
            var q = function (id) { return document.getElementById(id); };
            q('dtlBadge').textContent = el.dataset.badge || '';
            q('dtlName').textContent = el.dataset.name;
            q('dtlDesc').textContent = el.dataset.desc || 'Belum ada deskripsi.';
            q('dtlPrice').textContent = el.dataset.price;
            var isPrd = el.dataset.kind === 'Produk';
            q('dtlKind').textContent = el.dataset.kind || 'Jasa Gambar';
            q('dtlPriceLbl').textContent = isPrd ? 'Harga' : 'Mulai dari';
            var form = q('dtlForm');
            if (form) {
                q('dtlType').value = el.dataset.type || 'service';
                q('dtlId').value = el.dataset.id || '';
                form.style.display = el.dataset.soldout === '1' ? 'none' : '';
            }
            var img = q('dtlImg'); img.innerHTML = '';
            if (el.dataset.img) { var w = document.createElement('div'); w.className = 'dtl-pic'; var i = document.createElement('img'); i.src = el.dataset.img; i.alt = el.dataset.name; w.appendChild(i); img.appendChild(w); }
            else { img.innerHTML = '<i class="bi bi-image"></i>'; }
            dlg.classList.toggle('is-prd', (el.dataset.kind || '') === 'Produk');
            dlg.showModal();
        }
        items.forEach(function (it) {
            var card = it.querySelector('[data-detail]');
            card.addEventListener('click', function (e) { if (e.target.closest('a, button, form')) { return; } openDetail(card); });
            card.addEventListener('keydown', function (e) { if ((e.key === 'Enter' || e.key === ' ') && e.target === card) { e.preventDefault(); openDetail(card); } });
        });
        document.querySelectorAll('.prd-item [data-detail]').forEach(function (card) {
            card.addEventListener('click', function () { openDetail(card); });
            card.addEventListener('keydown', function (e) { if ((e.key === 'Enter' || e.key === ' ') && e.target === card) { e.preventDefault(); openDetail(card); } });
        });
        document.getElementById('dtlClose').addEventListener('click', function () { dlg.close(); });
        dlg.addEventListener('click', function (e) { if (e.target === dlg) { dlg.close(); } });

        search.addEventListener('input', apply);
        chips.forEach(function (chip) {
            chip.addEventListener('click', function () {
                chips.forEach(function (c) { c.classList.remove('active'); });
                chip.classList.add('active');
                activeBadge = chip.dataset.badge;
                apply();
            });
        });
        apply();
    })();
</script>
@endsection