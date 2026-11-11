@extends('layouts.dashboard')

@push('styles')
<style>
    .pr-wrap { max-width: 1280px; margin: 0 auto; }
    .pr-head { display: flex; justify-content: space-between; align-items: flex-end; gap: 1rem; flex-wrap: wrap; margin-bottom: 1.3rem; }
    .pr-head h3 { margin: 0 0 .2rem; font-weight: 800; color: var(--c-text, #4A3B32); display: flex; align-items: center; gap: .6rem; }
    .pr-head h3 i { color: var(--c-primary, #8B6F5B); }
    .pr-head p { margin: 0; color: #85766B; }
    .pr-add { display: inline-flex; align-items: center; gap: .45rem; background: var(--c-primary, #8B6F5B); color: #fff; border-radius: 12px; padding: .7rem 1.2rem; font-weight: 800; font-size: .92rem; text-decoration: none; }
    .pr-add:hover { background: var(--c-dark, #6B4F3F); color: #fff; }

    .pr-bar { display: flex; gap: .9rem; align-items: center; flex-wrap: wrap; background: #fff; border-radius: 16px; box-shadow: 0 2px 12px rgba(74, 59, 50, .07); padding: .8rem 1rem; margin-bottom: 1.3rem; }
    .pr-search { position: relative; flex: 1; min-width: 220px; max-width: 340px; }
    .pr-search i { position: absolute; left: .95rem; top: 50%; transform: translateY(-50%); color: var(--c-mid, #C9AF9A); }
    .pr-search input { width: 100%; border: 1.5px solid var(--c-line, #EFE3D3); border-radius: 12px; padding: .6rem 1rem .6rem 2.5rem; background: #FDFAF6; font-size: .92rem; }
    .pr-search input:focus { outline: none; border-color: var(--c-primary, #8B6F5B); background: #fff; box-shadow: 0 0 0 .2rem rgba(139, 111, 91, .15); }
    .pr-chips { display: flex; gap: .5rem; flex-wrap: wrap; }
    .pr-chip { border: 1.5px solid var(--c-line, #EFE3D3); background: #fff; color: #6F6258; border-radius: 999px; padding: .4rem 1rem; font-weight: 700; font-size: .85rem; cursor: pointer; transition: all .15s; }
    .pr-chip:hover { border-color: var(--c-mid, #C9AF9A); color: var(--c-dark, #6B4F3F); }
    .pr-chip.active { background: var(--c-primary, #8B6F5B); border-color: var(--c-primary, #8B6F5B); color: #fff; }
    .pr-count { margin-left: auto; color: #85766B; font-size: .88rem; font-weight: 600; }

    .pr-card { display: flex; flex-direction: column; height: 100%; background: #fff; border-radius: 20px; overflow: hidden; border: 1px solid var(--c-line, #EFE3D3); box-shadow: 0 2px 12px rgba(74, 59, 50, .06); transition: transform .2s, box-shadow .2s; }
    .pr-card:hover { transform: translateY(-5px); box-shadow: 0 16px 32px rgba(74, 59, 50, .16); }
    .pr-img { position: relative; aspect-ratio: 4 / 3; background: var(--c-soft, #EDDECA); overflow: hidden; }
    .pr-img img { width: 100%; height: 100%; object-fit: cover; display: block; transition: transform .4s; }
    .pr-card:hover .pr-img img { transform: scale(1.06); }
    .pr-ph { height: 100%; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: .3rem; color: var(--c-mid, #C9AF9A); font-size: .85rem; }
    .pr-ph i { font-size: 2.2rem; }
    .pr-badge { position: absolute; top: .75rem; left: .75rem; display: inline-flex; align-items: center; gap: .3rem; background: rgba(255, 255, 255, .95); color: var(--c-dark, #6B4F3F); font-size: .74rem; font-weight: 800; padding: .3rem .75rem; border-radius: 999px; box-shadow: 0 3px 10px rgba(0, 0, 0, .12); }
    .pr-badge i { color: var(--c-primary, #8B6F5B); }
    .pr-stock { position: absolute; top: .75rem; right: .75rem; font-size: .74rem; font-weight: 800; padding: .3rem .75rem; border-radius: 999px; box-shadow: 0 3px 10px rgba(0, 0, 0, .12); }
    .pr-stock.ok { background: #E3F4E6; color: #2F7A3D; } .pr-stock.low { background: #FFF1D6; color: #9A6A0B; } .pr-stock.out { background: #FBEAEA; color: #B3402F; }
    .pr-body { padding: 1.1rem 1.2rem 1.25rem; display: flex; flex-direction: column; flex: 1; }
    .pr-body h6 { font-weight: 800; font-size: 1.08rem; margin: 0 0 .35rem; color: var(--c-text, #4A3B32); }
    .pr-desc { color: #85766B; font-size: .87rem; line-height: 1.45; margin: 0 0 .9rem; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; min-height: 2.5em; }
    .pr-foot { margin-top: auto; }
    .pr-price small { display: block; color: #9A8B80; font-size: .74rem; font-weight: 600; }
    .pr-price strong { font-size: 1.3rem; color: var(--c-dark, #6B4F3F); }
    .pr-act { display: flex; gap: .55rem; margin-top: .9rem; }
    .pr-act form { margin: 0; }
    .pr-ab { display: inline-flex; align-items: center; justify-content: center; gap: .4rem; padding: .6rem .9rem; border-radius: 11px; font-weight: 800; font-size: .86rem; text-decoration: none; cursor: pointer; border: 1.5px solid var(--c-mid, #C9AF9A); background: #fff; color: var(--c-dark, #6B4F3F); }
    .pr-ab.edit { flex: 1; background: var(--c-primary, #8B6F5B); border-color: var(--c-primary, #8B6F5B); color: #fff; }
    .pr-ab.edit:hover { background: var(--c-dark, #6B4F3F); color: #fff; }
    .pr-ab.del { border-color: #E3A9A9; color: #B3402F; }
    .pr-ab.del:hover { background: #FBEAEA; color: #B3402F; }

    .pr-empty { display: none; text-align: center; background: #fff; border-radius: 18px; padding: 2.8rem 1rem; color: #85766B; box-shadow: 0 2px 12px rgba(74, 59, 50, .07); }
    .pr-empty i { font-size: 2.8rem; color: var(--c-mid, #C9AF9A); display: block; margin-bottom: .4rem; }
    @media (max-width: 575.98px) { .pr-search { max-width: none; } .pr-count { margin-left: 0; width: 100%; } }
</style>
@endpush

@section('content')
@php
    $icons = ['kertas' => 'bi-file-earmark-text', 'pulpen' => 'bi-pen', 'pensil' => 'bi-pencil', 'lainnya' => 'bi-box-seam'];
    $cats = $products->getCollection()->pluck('category')->unique()->values();
@endphp

<div class="pr-wrap">
    <div class="pr-head">
        <div>
            <h3><i class="bi bi-pencil"></i>Produk</h3>
            <p>Kelola kertas, pulpen, pensil, dan perlengkapan gambar lainnya.</p>
        </div>
        <a href="{{ route('admin.products.create') }}" class="pr-add"><i class="bi bi-plus-lg"></i>Tambah Produk</a>
    </div>

    <div class="pr-bar">
        <div class="pr-search"><i class="bi bi-search"></i><input type="text" id="prSearch" placeholder="Cari produk..."></div>
        @if ($cats->count() > 1)
            <div class="pr-chips" id="prChips">
                <button type="button" class="pr-chip active" data-cat="">Semua</button>
                @foreach ($cats as $c)
                    <button type="button" class="pr-chip" data-cat="{{ $c }}">{{ \App\Models\Product::CATEGORIES[$c] ?? ucfirst($c) }}</button>
                @endforeach
            </div>
        @endif
        <div class="pr-count" id="prCount"></div>
    </div>

    <div class="row row-cols-1 row-cols-sm-2 row-cols-xl-4 g-3">
        @forelse ($products as $product)
            <div class="col pr-item" data-cat="{{ $product->category }}" data-name="{{ Str::lower($product->name . ' ' . $product->description) }}">
                <div class="pr-card">
                    <div class="pr-img">
                        @if ($product->image)
                            <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" loading="lazy">
                        @else
                            <div class="pr-ph"><i class="bi bi-image"></i>Tidak ada gambar</div>
                        @endif
                        <span class="pr-badge"><i class="bi {{ $icons[$product->category] ?? 'bi-box-seam' }}"></i>{{ $product->category_label }}</span>
                        @if ($product->stock <= 0)<span class="pr-stock out">Stok habis</span>
                        @elseif ($product->stock <= 5)<span class="pr-stock low">Sisa {{ $product->stock }}</span>
                        @else<span class="pr-stock ok">Stok {{ $product->stock }}</span>@endif
                    </div>
                    <div class="pr-body">
                        <h6>{{ $product->name }}</h6>
                        <p class="pr-desc">{{ $product->description ?: 'Belum ada deskripsi.' }}</p>
                        <div class="pr-foot">
                            <div class="pr-price"><small>Harga</small><strong>Rp{{ number_format($product->price, 0, ',', '.') }}</strong></div>
                            <div class="pr-act">
                                <a href="{{ route('admin.products.edit', $product) }}" class="pr-ab edit"><i class="bi bi-pencil-square"></i>Edit</a>
                                <form action="{{ route('admin.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Hapus produk {{ addslashes($product->name) }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="pr-ab del" title="Hapus"><i class="bi bi-trash"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12"><div class="pr-empty" style="display:block;"><i class="bi bi-box-seam"></i>Belum ada produk.<br><a href="{{ route('admin.products.create') }}" class="pr-add" style="margin-top:.9rem;">Tambah Produk Pertama</a></div></div>
        @endforelse
    </div>

    <div class="pr-empty" id="prNone"><i class="bi bi-search"></i>Tidak ada produk yang cocok dengan pencarianmu.</div>

    <div class="mt-4">{{ $products->links('pagination::bootstrap-5') }}</div>
</div>

<script>
    (function () {
        var items = document.querySelectorAll('.pr-item');
        if (!items.length) { return; }
        var search = document.getElementById('prSearch'), none = document.getElementById('prNone'), count = document.getElementById('prCount');
        var chips = document.querySelectorAll('#prChips .pr-chip'), cat = '';
        function apply() {
            var q = search.value.trim().toLowerCase(), shown = 0;
            items.forEach(function (el) {
                var ok = (!cat || el.dataset.cat === cat) && (!q || el.dataset.name.indexOf(q) !== -1);
                el.style.display = ok ? '' : 'none';
                if (ok) { shown++; }
            });
            none.style.display = shown ? 'none' : 'block';
            count.textContent = shown + ' produk';
        }
        search.addEventListener('input', apply);
        chips.forEach(function (c) {
            c.addEventListener('click', function () {
                chips.forEach(function (x) { x.classList.remove('active'); });
                c.classList.add('active'); cat = c.dataset.cat; apply();
            });
        });
        apply();
    })();
</script>
@endsection