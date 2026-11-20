@extends('layouts.dashboard')

@section('content')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
<style>
  .mp-search {
    display: flex;
    gap: .5rem;
    flex-wrap: wrap;
    margin-bottom: .6rem;
}

.mp-search input {
    flex: 1;
    min-width: 200px;
}

.mp-btn {
    border: 0;
    background: var(--c-primary, #8B6F5B);
    color: #fff;
    font-weight: 800;
    border-radius: 10px;
    padding: .5rem 1rem;
    display: inline-flex;
    align-items: center;
    gap: .4rem;
}

.mp-btn:hover {
    background: var(--c-dark, #6B4F3F);
}

.mp-btn.alt {
    background: #fff;
    color: var(--c-dark, #6B4F3F);
    border: 1.5px solid var(--c-mid, #C9AF9A);
}

#mpMap {
    height: 280px;
    border-radius: 14px;
    border: 1px solid var(--c-line, #EFE3D3);
    z-index: 0;
}

.mp-info {
    margin-top: .5rem;
    font-size: .85rem;
    color: #85766B;
    display: flex;
    gap: .4rem;
    align-items: flex-start;
}
</style>

@php
    // Layanan yang sudah dipilih (dari halaman Layanan & Harga / Dashboard, atau saat validasi gagal)
    $chosenId = old('service_price_id', $selectedServiceId ?? null);
    $chosen = $chosenId ? $servicePrices->firstWhere('id', (int) $chosenId) : null;

    // Mode produk: dibuka dari tab Produk (?product_id=...)
    $product = $product ?? (old('product_id') ? \App\Models\Product::find(old('product_id')) : null);
    $isP = (bool) $product;
    if ($isP) { $chosen = null; }
    $qtyOld = max(1, (int) old('quantity', 1));
@endphp
<style>
   .qty {
    display: inline-flex;
    align-items: center;
    border: 1.5px solid var(--c-line, #EFE3D3);
    border-radius: 12px;
    overflow: hidden;
    background: #fff;
}

.qty button {
    width: 40px;
    height: 40px;
    border: 0;
    background: var(--c-tint, #F5EAD8);
    color: var(--c-dark, #6B4F3F);
    font-size: 1.1rem;
    font-weight: 800;
}

.qty button:hover {
    background: var(--c-soft, #EDDECA);
}

.qty input {
    width: 56px;
    height: 40px;
    border: 0;
    text-align: center;
    font-weight: 800;
    -moz-appearance: textfield;
}

.qty input::-webkit-outer-spin-button,
.qty input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

.qty input:focus {
    outline: none;
}

.oc-head {
    margin-bottom: 1.5rem;
}

.oc-back {
    display: inline-flex;
    align-items: center;
    gap: .4rem;
    color: var(--c-primary, #8B6F5B);
    font-weight: 700;
    font-size: .88rem;
    text-decoration: none;
    margin-bottom: .6rem;
}

.oc-back:hover {
    color: var(--c-dark, #6B4F3F);
}

.oc-head h1 {
    font-size: 1.9rem;
    font-weight: 800;
    color: var(--c-dark, #6B4F3F);
    margin: 0 0 .3rem;
}

.oc-head p {
    color: #85766B;
    margin: 0;
}

.oc-card {
    background: #fff;
    border-radius: 20px;
    box-shadow: 0 2px 14px rgba(74, 59, 50, .08);
    padding: 1.6rem;
    margin-bottom: 1.25rem;
}

.oc-title {
    display: flex;
    align-items: center;
    gap: .7rem;
    font-weight: 800;
    font-size: 1.05rem;
    color: var(--c-text, #4A3B32);
    margin: 0 0 1.2rem;
}

.oc-no {
    width: 28px;
    height: 28px;
    border-radius: 50%;
    background: var(--c-primary, #8B6F5B);
    color: #fff;
    font-size: .82rem;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

/* Pilih layanan */
.oc-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
    gap: 1rem;
}

.oc-svc {
    position: relative;
    display: block;
    border: 2px solid var(--c-line, #EFE3D3);
    border-radius: 16px;
    overflow: hidden;
    cursor: pointer;
    background: #fff;
    transition: border-color .2s, box-shadow .2s, transform .2s;
}

.oc-svc:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(74, 59, 50, .12);
}

.oc-svc:focus-within {
    outline: 3px solid var(--c-mid, #C9AF9A);
    outline-offset: 2px;
}

.oc-svc.selected {
    border-color: var(--c-primary, #8B6F5B);
    box-shadow: 0 0 0 3px rgba(139, 111, 91, .18);
}

.oc-radio {
    position: absolute;
    opacity: 0;
    pointer-events: none;
}

.oc-svc-img {
    height: 120px;
    background: var(--c-tint, #F5EAD8);
}

.oc-svc-img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}

.oc-ph {
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--c-mid, #C9AF9A);
    font-size: 2rem;
}

.oc-svc-body {
    padding: .75rem .9rem .9rem;
}

.oc-svc-body strong {
    display: block;
    font-size: .92rem;
    line-height: 1.3;
    margin-bottom: .2rem;
}

.oc-svc-body span {
    color: var(--c-dark, #6B4F3F);
    font-weight: 800;
    font-size: .95rem;
}

.oc-check {
    position: absolute;
    top: 10px;
    right: 10px;
    width: 26px;
    height: 26px;
    border-radius: 50%;
    background: var(--c-primary, #8B6F5B);
    color: #fff;
    display: none;
    align-items: center;
    justify-content: center;
    font-size: .9rem;
}

.oc-svc.selected .oc-check {
    display: flex;
}

/* Layanan yang sudah dipilih */
.oc-chosen {
    display: flex;
    align-items: center;
    gap: 1.1rem;
    border: 2px solid var(--c-primary, #8B6F5B);
    border-radius: 16px;
    padding: .8rem;
    background: #FDFAF6;
}

.oc-chosen-img {
    width: 130px;
    height: 100px;
    border-radius: 12px;
    overflow: hidden;
    flex-shrink: 0;
    background: var(--c-tint, #F5EAD8);
}

.oc-chosen-img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}

.oc-chosen-info {
    min-width: 0;
}

.oc-chosen-info small {
    display: block;
    color: #9A8B80;
    font-size: .72rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .05em;
    margin-bottom: .15rem;
}

.oc-chosen-info strong {
    display: block;
    font-size: 1.1rem;
    color: var(--c-text, #4A3B32);
}

.oc-chosen-info p {
    font-size: .85rem;
    color: #85766B;
    margin: .2rem 0 .4rem;
}

.oc-chosen-info .oc-chosen-price {
    font-weight: 800;
    color: var(--c-dark, #6B4F3F);
}

.oc-change {
    margin-left: auto;
    flex-shrink: 0;
    white-space: nowrap;
    display: inline-flex;
    align-items: center;
    gap: .4rem;
    padding: .55rem 1rem;
    border-radius: 12px;
    border: 1.5px solid var(--c-mid, #C9AF9A);
    color: var(--c-dark, #6B4F3F);
    font-weight: 700;
    font-size: .86rem;
    text-decoration: none;
}

.oc-change:hover {
    background: var(--c-soft, #EDDECA);
    color: var(--c-dark, #6B4F3F);
}

/* Form */
.oc-card .form-label {
    font-weight: 700;
    font-size: .88rem;
    color: var(--c-text, #4A3B32);
    margin-bottom: .4rem;
}

.oc-card .form-control {
    border-radius: 12px;
    border: 1.5px solid var(--c-line, #EFE3D3);
    padding: .7rem .95rem;
    background: #FDFAF6;
}

.oc-card .form-control:focus {
    border-color: var(--c-primary, #8B6F5B);
    box-shadow: 0 0 0 .2rem rgba(139, 111, 91, .18);
    background: #fff;
}

.oc-err {
    color: #dc3545;
    font-size: .82rem;
    margin-top: .35rem;
}

/* Upload */
.oc-drop {
    position: relative;
    display: block;
    border: 2px dashed var(--c-mid, #C9AF9A);
    border-radius: 16px;
    background: #FDF9F3;
    padding: 1.4rem;
    text-align: center;
    cursor: pointer;
    transition: background .2s, border-color .2s;
    margin: 0;
}

.oc-drop:hover {
    background: var(--c-tint, #F5EAD8);
    border-color: var(--c-primary, #8B6F5B);
}

.oc-drop input {
    position: absolute;
    width: 1px;
    height: 1px;
    opacity: 0;
    overflow: hidden;
}

.oc-drop-empty i {
    font-size: 2.2rem;
    color: var(--c-primary, #8B6F5B);
    display: block;
    line-height: 1;
    margin-bottom: .5rem;
}

.oc-drop-empty strong {
    display: block;
    color: var(--c-text, #4A3B32);
}

.oc-drop small {
    color: #9A8B80;
}

.oc-drop-preview {
    display: none;
    align-items: center;
    gap: 1rem;
    text-align: left;
}

.oc-drop-preview img {
    width: 84px;
    height: 84px;
    object-fit: cover;
    border-radius: 12px;
    flex-shrink: 0;
}

.oc-drop-preview strong {
    display: block;
    word-break: break-all;
}

.oc-drop.has-file .oc-drop-empty {
    display: none;
}

.oc-drop.has-file .oc-drop-preview {
    display: flex;
}

/* Ringkasan */
.oc-sticky {
    position: sticky;
    top: 96px;
}

.oc-sum-img {
    height: 170px;
    border-radius: 14px;
    overflow: hidden;
    background: var(--c-tint, #F5EAD8);
    margin-bottom: 1rem;
}

.oc-sum-img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}

.oc-sum-name {
    font-weight: 800;
    font-size: 1.05rem;
    margin: 0 0 .15rem;
}

.oc-sum-empty {
    color: #9A8B80;
}

.oc-rows {
    margin: 1rem 0;
    border-top: 1px solid var(--c-line, #EFE3D3);
}

.oc-row {
    display: flex;
    justify-content: space-between;
    gap: 1rem;
    padding: .65rem 0;
    border-bottom: 1px solid var(--c-line, #EFE3D3);
    font-size: .9rem;
}

.oc-row span:first-child {
    color: #85766B;
}

.oc-fee {
    font-size: .78rem;
    font-weight: 800;
    color: var(--c-primary, #8B6F5B);
    background: var(--c-tint, #F5EAD8);
    border-radius: 999px;
    padding: .1rem .55rem;
    margin-left: .3rem;
}

.oc-pay label.off-cod {
    opacity: .45;
    cursor: not-allowed;
}

.oc-row\.total {
    border-bottom: 0;
    font-size: 1.05rem;
}

.oc-row\.total strong {
    font-size: 1.3rem;
    color: var(--c-dark, #6B4F3F);
}

.oc-submit {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: .5rem;
    width: 100%;
    border: 0;
    border-radius: 12px;
    padding: .85rem;
    background: var(--c-primary, #8B6F5B);
    color: #fff;
    font-weight: 800;
    transition: background .2s;
}

.oc-submit:hover {
    background: var(--c-dark, #6B4F3F);
}

.oc-cancel {
    display: block;
    text-align: center;
    margin-top: .6rem;
    padding: .7rem;
    border-radius: 12px;
    border: 1.5px solid var(--c-mid, #C9AF9A);
    color: var(--c-dark, #6B4F3F);
    font-weight: 700;
    text-decoration: none;
}

.oc-cancel:hover {
    background: var(--c-soft, #EDDECA);
    color: var(--c-dark, #6B4F3F);
}

.oc-tips {
    background: var(--c-soft, #EDDECA);
    border-radius: 20px;
    padding: 1.3rem 1.4rem;
    color: var(--c-dark, #6B4F3F);
}

.oc-tips h6 {
    font-weight: 800;
    margin: 0 0 .7rem;
    display: flex;
    gap: .5rem;
    align-items: center;
}

.oc-tips ul {
    list-style: none;
    margin: 0;
    padding: 0;
    font-size: .86rem;
}

.oc-tips li {
    display: flex;
    gap: .55rem;
    margin-bottom: .45rem;
}

.oc-tips li i {
    color: var(--c-primary, #8B6F5B);
    margin-top: .1rem;
}

@media (max-width: 991.98px) {
    .oc-sticky {
        position: static;
    }
}

@media (max-width: 575.98px) {
    .oc-chosen {
        flex-wrap: wrap;
    }

    .oc-chosen-img {
        width: 100%;
        height: 150px;
    }

    .oc-change {
        margin-left: 0;
    }
}

/* Metode pembayaran */
.oc-pay {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: .8rem;
}

.oc-pay label {
    position: relative;
    display: flex;
    gap: .8rem;
    align-items: center;
    border: 1.5px solid var(--c-line, #EFE3D3);
    border-radius: 14px;
    padding: .9rem 1rem;
    cursor: pointer;
    background: #FDFAF6;
    transition: border-color .2s, background .2s;
}

.oc-pay input {
    position: absolute;
    opacity: 0;
}

.oc-pay label:has(input:checked) {
    border-color: var(--c-primary, #8B6F5B);
    background: var(--c-tint, #F5EAD8);
    box-shadow: 0 0 0 .15rem rgba(139, 111, 91, .15);
}

.oc-pay i {
    font-size: 1.6rem;
    color: var(--c-primary, #8B6F5B);
}

.oc-pay strong {
    display: block;
    color: var(--c-text, #4A3B32);
}

.oc-pay small {
    color: #85766B;
}

.oc-pay label.off {
    opacity: .5;
    cursor: not-allowed;
}

.oc-qris-note {
    display: none;
    margin-top: .9rem;
    background: #FDFAF6;
    border: 1px dashed var(--c-mid, #C9AF9A);
    border-radius: 12px;
    padding: .8rem 1rem;
    font-size: .88rem;
    color: #6F6258;
}
</style>

<div class="oc-head">
    <a href="{{ route('orders.index') }}" class="oc-back"><i class="bi bi-arrow-left"></i>Kembali ke Pesanan Saya</a>
    <h1>Buat Pesanan Baru</h1>
    <p>{{ $isP ? 'Atur jumlah produk, isi data pengiriman, lalu kirim pesananmu.' : ($chosen ? 'Ceritakan gambar yang kamu mau, lalu kirim pesananmu.' : 'Pilih layanan, ceritakan gambar yang kamu mau, lalu kirim pesananmu.') }}</p>
</div>

<form action="{{ route('orders.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="row g-4">
        {{-- Kolom kiri: form --}}
        <div class="col-lg-8">
            <div class="oc-card">
                @if ($isP)
                    <h5 class="oc-title"><span class="oc-no">1</span>Produk yang Dipilih</h5>

                    <div class="oc-chosen">
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" id="ocChosen" data-unit="{{ (int) $product->price }}" data-stock="{{ (int) $product->stock }}"
                               data-name="{{ $product->name }}"
                               data-price="Rp{{ number_format($product->price * $qtyOld, 0, ',', '.') }}"
                               data-img="{{ $product->image ? Storage::url($product->image) : '' }}">
                        <div class="oc-chosen-img">
                            @if ($product->image)
                                <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}">
                            @else
                                <div class="oc-ph"><i class="bi bi-image"></i></div>
                            @endif
                        </div>
                        <div class="oc-chosen-info">
                            <small>{{ $product->category_label }} &bull; {{ $product->stock > 0 ? 'Stok ' . $product->stock : 'Stok habis' }}</small>
                            <strong>{{ $product->name }}</strong>
                            @if ($product->description)
                                <p>{{ Str::limit($product->description, 90) }}</p>
                            @endif
                            <span class="oc-chosen-price">Rp{{ number_format($product->price, 0, ',', '.') }} <small class="text-muted fw-normal">/ item</small></span>
                            <div class="mt-2 d-flex align-items-center gap-2">
                                <span class="small fw-bold text-muted">Jumlah</span>
                                <div class="qty">
                                    <button type="button" id="qtyMinus" aria-label="Kurangi">&minus;</button>
                                    <input type="number" name="quantity" id="qtyInput" value="{{ min($qtyOld, max(1, $product->stock)) }}" min="1" max="{{ max(1, (int) $product->stock) }}">
                                    <button type="button" id="qtyPlus" aria-label="Tambah">+</button>
                                </div>
                            </div>
                            @error('quantity') <div class="oc-err">{{ $message }}</div> @enderror
                        </div>
                        <a href="{{ route('service_prices.index') }}#produk" class="oc-change"><i class="bi bi-arrow-repeat"></i>Ganti produk</a>
                    </div>
                @elseif ($chosen)
                    <h5 class="oc-title"><span class="oc-no">1</span>Layanan yang Dipilih</h5>

                    <div class="oc-chosen">
                        <input type="hidden" name="service_price_id" value="{{ $chosen->id }}" id="ocChosen"
                               data-name="{{ $chosen->name }}"
                               data-price="Rp{{ number_format($chosen->price, 0, ',', '.') }}"
                               data-badge="{{ $chosen->badge }}"
                               data-img="{{ $chosen->image ? Storage::url($chosen->image) : '' }}">
                        <div class="oc-chosen-img">
                            @if ($chosen->image)
                                <img src="{{ Storage::url($chosen->image) }}" alt="{{ $chosen->name }}">
                            @else
                                <div class="oc-ph"><i class="bi bi-image"></i></div>
                            @endif
                        </div>
                        <div class="oc-chosen-info">
                            <small>Layanan kamu</small>
                            <strong>{{ $chosen->name }}</strong>
                            @if ($chosen->description)
                                <p>{{ Str::limit($chosen->description, 90) }}</p>
                            @endif
                            <span class="oc-chosen-price">Rp{{ number_format($chosen->price, 0, ',', '.') }}</span>
                        </div>
                        <a href="{{ route('orders.create') }}" class="oc-change"><i class="bi bi-arrow-repeat"></i>Ganti layanan</a>
                    </div>
                @else
                    <h5 class="oc-title"><span class="oc-no">1</span>Pilih Jenis Layanan</h5>

                    <div class="oc-grid">
                        @forelse ($servicePrices as $sp)
                            <label class="oc-svc">
                                <input type="radio" class="oc-radio" name="service_price_id" value="{{ $sp->id }}"
                                       data-name="{{ $sp->name }}"
                                       data-price="Rp{{ number_format($sp->price, 0, ',', '.') }}"
                                       data-badge="{{ $sp->badge }}"
                                       data-img="{{ $sp->image ? Storage::url($sp->image) : '' }}"
                                       @checked((string) old('service_price_id', $selectedServiceId ?? '') === (string) $sp->id)>
                                <span class="oc-check"><i class="bi bi-check-lg"></i></span>
                                <div class="oc-svc-img">
                                    @if ($sp->image)
                                        <img src="{{ Storage::url($sp->image) }}" alt="{{ $sp->name }}">
                                    @else
                                        <div class="oc-ph"><i class="bi bi-image"></i></div>
                                    @endif
                                </div>
                                <div class="oc-svc-body">
                                    <strong>{{ $sp->name }}</strong>
                                    <span>Rp{{ number_format($sp->price, 0, ',', '.') }}</span>
                                </div>
                            </label>
                        @empty
                            <p class="text-muted mb-0">Belum ada layanan yang tersedia.</p>
                        @endforelse
                    </div>
                @endif
                @error('service_price_id')
                    <div class="oc-err">{{ $message }}</div>
                @enderror
            </div>

            <div class="oc-card">
                <h5 class="oc-title"><span class="oc-no">2</span>{{ $isP ? 'Catatan untuk Penjual' : 'Detail Pesanan' }} @if ($isP)<small class="text-muted fw-normal">(opsional)</small>@endif</h5>
                <textarea name="description" rows="{{ $isP ? 3 : 5 }}" placeholder="{{ $isP ? 'Tulis catatan jika ada, misalnya pilihan warna atau ukuran...' : 'Jelaskan detail gambar yang kamu inginkan, misalnya gaya, warna, ekspresi, atau suasana...' }}" class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                @error('description')
                    <div class="oc-err">{{ $message }}</div>
                @enderror
            </div>

            @unless ($isP)
            <div class="oc-card">
                <h5 class="oc-title"><span class="oc-no">3</span>Referensi / Gambaran <small class="text-muted fw-normal">(opsional)</small></h5>
                <label class="oc-drop" id="ocDrop">
                    <input type="file" name="reference_image" id="ocFile" accept="image/*">
                    <div class="oc-drop-empty">
                        <i class="bi bi-cloud-arrow-up"></i>
                        <strong>Klik untuk upload gambar referensi</strong>
                        <small>Format gambar (JPG, PNG), maksimal 2 MB</small>
                    </div>
                    <div class="oc-drop-preview">
                        <img src="" alt="Pratinjau referensi" id="ocPreview">
                        <div>
                            <strong id="ocFileName"></strong>
                            <small>Klik untuk mengganti gambar</small>
                        </div>
                    </div>
                </label>
                @error('reference_image')
                    <div class="oc-err">{{ $message }}</div>
                @enderror
            </div>

            @endunless

            <div class="oc-card">
                <h5 class="oc-title"><span class="oc-no">{{ $isP ? 3 : 4 }}</span>Data Penerima</h5>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Nama Penerima</label>
                        <input type="text" name="recipient_name" value="{{ old('recipient_name') }}" class="form-control @error('recipient_name') is-invalid @enderror">
                        @error('recipient_name')
                            <div class="oc-err">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Nomor Telepon Penerima</label>
                        <input type="text" name="recipient_phone" value="{{ old('recipient_phone') }}" class="form-control @error('recipient_phone') is-invalid @enderror">
                        @error('recipient_phone')
                            <div class="oc-err">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-12">
                        <label class="form-label">Alamat Pengiriman</label>
                        <textarea name="shipping_address" rows="3" class="form-control @error('shipping_address') is-invalid @enderror">{{ old('shipping_address') }}</textarea>
                        @error('shipping_address')
                            <div class="oc-err">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-12">
                        <label class="form-label">Tandai Lokasi di Peta <small class="text-muted fw-normal">(opsional, supaya kurir mudah menemukan)</small></label>
                        <div class="mp-search">
                            <input type="text" id="mpQuery" class="form-control" placeholder="Cari alamat / nama tempat, contoh: Jl. Malioboro Yogyakarta">
                            <button type="button" id="mpFind" class="mp-btn"><i class="bi bi-search"></i>Cari</button>
                            <button type="button" id="mpGps" class="mp-btn alt"><i class="bi bi-crosshair"></i>Lokasiku</button>
                        </div>
                        <div id="mpMap"></div>
                        <div class="mp-info" id="mpInfo"><i class="bi bi-info-circle"></i>Cari alamat atau klik peta, lalu geser pin untuk menyesuaikan.</div>
                        <input type="hidden" name="shipping_lat" id="mpLat" value="{{ old('shipping_lat') }}">
                        <input type="hidden" name="shipping_lng" id="mpLng" value="{{ old('shipping_lng') }}">
                    </div>
                </div>
            </div>
            {{-- 5. Area pengiriman --}}
            @php
                $areas = config('shipping.areas', []);
                $areaOld = old('delivery_area', array_key_first($areas));
            @endphp
            <div class="oc-card">
                <h5 class="oc-title"><span class="oc-no">{{ $isP ? 4 : 5 }}</span>Area Pengiriman</h5>
                <div class="oc-pay" id="areaBox">
                    @foreach ($areas as $key => $area)
                        <label>
                            <input type="radio" name="delivery_area" value="{{ $key }}" data-fee="{{ (int) $area['fee'] }}" data-cod="{{ $area['cod'] ? 1 : 0 }}" data-label="{{ $area['label'] }}" {{ $areaOld === $key ? 'checked' : '' }}>
                            <i class="bi {{ $area['icon'] }}"></i>
                            <span><strong>{{ $area['label'] }} <span class="oc-fee">{{ $area['fee'] > 0 ? '+Rp' . number_format($area['fee'], 0, ',', '.') : 'Gratis' }}</span></strong><small>{{ $area['note'] }}</small></span>
                        </label>
                    @endforeach
                </div>
                @error('delivery_area') <div class="oc-err">{{ $message }}</div> @enderror
            </div>

            {{-- 6. Metode pembayaran --}}
            @php
                $payOld = old('payment_method', 'cod');
                $anyReady = collect($wallets)->contains(fn ($w) => $w['ready']);
            @endphp
            <div class="oc-card">
                <h5 class="oc-title"><span class="oc-no">{{ $isP ? 5 : 6 }}</span>Metode Pembayaran</h5>
                <div class="oc-pay">
                    <label>
                        <input type="radio" name="payment_method" value="cod" data-label="COD (bayar di tempat)" {{ $payOld === 'cod' || ! $anyReady ? 'checked' : '' }}>
                        <i class="bi bi-cash-coin"></i>
                        <span><strong>COD</strong><small>Bayar di tempat saat pesanan diterima</small></span>
                    </label>
                    @foreach ($wallets as $key => $wallet)
                        <label class="{{ $wallet['ready'] ? '' : 'off' }}">
                            <input type="radio" name="payment_method" value="{{ $key }}" data-label="{{ $wallet['label'] }}" data-ewallet="1"
                                   {{ $payOld === $key && $wallet['ready'] ? 'checked' : '' }} {{ $wallet['ready'] ? '' : 'disabled' }}>
                            <i class="bi {{ $wallet['icon'] }}"></i>
                            <span><strong>{{ $wallet['label'] }}</strong><small>{{ $wallet['ready'] ? 'Scan QR lalu unggah bukti bayar' : 'Belum tersedia' }}</small></span>
                        </label>
                    @endforeach
                </div>
                <div class="oc-qris-note" id="payNote"><i class="bi bi-info-circle me-1"></i>Setelah pesanan dikirim, QR akan tampil di halaman detail pesanan. Scan, bayar sesuai total, lalu unggah bukti pembayaran.</div>
                @error('payment_method') <div class="oc-err">{{ $message }}</div> @enderror
            </div>
        </div>

        {{-- Kolom kanan: ringkasan --}}
        <div class="col-lg-4">
            <div class="oc-sticky">
                <div class="oc-card">
                    <h5 class="oc-title"><i class="bi bi-receipt" style="color: var(--c-primary, #8B6F5B);"></i>Ringkasan Pesanan</h5>

                    <div class="oc-sum-img" id="sumImg"></div>
                    <p class="oc-sum-name" id="sumName">{{ $isP ? $product->name : ($chosen ? $chosen->name : 'Belum memilih layanan') }}</p>
                    <p class="oc-sum-empty small mb-0" id="sumHint" @if ($chosen || $isP) style="display: none;" @endif>Pilih salah satu layanan di sebelah kiri.</p>

                    <div class="oc-rows">
                        <div class="oc-row"><span>{{ $isP ? 'Harga produk' : 'Harga layanan' }}</span><strong id="sumPrice">-</strong></div>
                        <div class="oc-row"><span>Ongkir <small id="sumArea" class="text-muted"></small></span><strong id="sumFee">Gratis</strong></div>
                        <div class="oc-row"><span>Pembayaran</span><strong id="sumPay">COD (bayar di tempat)</strong></div>
                        <div class="oc-row total"><span>Total</span><strong id="sumTotal">-</strong></div>
                    </div>

                    <button type="submit" class="oc-submit"><i class="bi bi-send"></i>Kirim Pesanan</button>
                    <a href="{{ route('orders.index') }}" class="oc-cancel">Batal</a>
                </div>

                <div class="oc-tips">
                    <h6><i class="bi bi-lightbulb"></i>Tips agar hasil maksimal</h6>
                    <ul>
                        <li><i class="bi bi-check-circle-fill"></i>Jelaskan detail gambar sejelas mungkin.</li>
                        <li><i class="bi bi-check-circle-fill"></i>Unggah referensi yang jelas dan tidak buram.</li>
                        <li><i class="bi bi-check-circle-fill"></i>Pastikan nama, nomor telepon, dan alamat sudah benar.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    (function () {
        // ----- Ringkasan pesanan mengikuti layanan yang dipilih -----
        var radios = document.querySelectorAll('.oc-radio, #ocChosen');
        var sumImg = document.getElementById('sumImg');
        var sumName = document.getElementById('sumName');
        var sumHint = document.getElementById('sumHint');
        var sumPrice = document.getElementById('sumPrice');
        var sumTotal = document.getElementById('sumTotal');

        function renderSummary() {
            var selected = null;
            radios.forEach(function (r) {
                var isOn = r.type === 'hidden' ? true : r.checked;
                var card = r.closest('.oc-svc');
                if (card) { card.classList.toggle('selected', isOn); }
                if (isOn) { selected = r; }
            });

            sumImg.innerHTML = '';
            if (!selected) {
                sumImg.innerHTML = '<div class="oc-ph"><i class="bi bi-image"></i></div>';
                sumName.textContent = 'Belum memilih layanan';
                sumHint.style.display = '';
                sumPrice.textContent = '-';
                sumTotal.textContent = '-';
                return;
            }

            var d = selected.dataset;
            if (d.img) {
                var img = document.createElement('img');
                img.src = d.img;
                img.alt = d.name;
                sumImg.appendChild(img);
            } else {
                sumImg.innerHTML = '<div class="oc-ph"><i class="bi bi-image"></i></div>';
            }
            sumName.textContent = d.name;
            sumHint.style.display = 'none';
            sumPrice.textContent = d.price;
            sumTotal.textContent = d.price;
        }

        radios.forEach(function (r) { r.addEventListener('change', renderSummary); });
        renderSummary();

        // ----- Pratinjau gambar referensi -----
        var file = document.getElementById('ocFile');
        var drop = document.getElementById('ocDrop');
        var preview = document.getElementById('ocPreview');
        var fileName = document.getElementById('ocFileName');

        if (file) file.addEventListener('change', function () {
            var f = file.files && file.files[0];
            if (!f) { drop.classList.remove('has-file'); return; }
            fileName.textContent = f.name;
            var reader = new FileReader();
            reader.onload = function (e) { preview.src = e.target.result; };
            reader.readAsDataURL(f);
            drop.classList.add('has-file');
        });
    })();
</script>
<script>
    (function () {
        var pays = document.querySelectorAll('input[name="payment_method"]');
        var sumPay = document.getElementById('sumPay');
        var note = document.getElementById('payNote');
        function sync() {
            var c = document.querySelector('input[name="payment_method"]:checked');
            sumPay.textContent = c ? c.dataset.label : 'COD (bayar di tempat)';
            note.style.display = c && c.dataset.ewallet ? 'block' : 'none';
        }
        pays.forEach(function (r) { r.addEventListener('change', sync); });
        sync();
    })();
</script>
<script>
    // Ongkir + total + COD nonaktif untuk luar kota
    (function () {
        var areas = document.querySelectorAll('input[name="delivery_area"]');
        var svc = document.querySelectorAll('.oc-radio, #ocChosen');
        var sumFee = document.getElementById('sumFee');
        var sumArea = document.getElementById('sumArea');
        var sumTotal = document.getElementById('sumTotal');
        var cod = document.querySelector('input[name="payment_method"][value="cod"]');
        var rp = function (n) { return 'Rp' + Math.round(n).toLocaleString('id-ID'); };

        function selectedPrice() {
            var p = null;
            svc.forEach(function (r) { if (r.type === 'hidden' || r.checked) { p = r; } });
            return p ? parseInt((p.dataset.price || '0').replace(/\D/g, ''), 10) : null;
        }

        function update() {
            var a = document.querySelector('input[name="delivery_area"]:checked');
            var fee = a ? parseInt(a.dataset.fee, 10) : 0;
            var codOk = !a || a.dataset.cod === '1';

            sumFee.textContent = fee > 0 ? rp(fee) : 'Gratis';
            sumArea.textContent = a ? '(' + a.dataset.label + ')' : '';

            var price = selectedPrice();
            sumTotal.textContent = price === null ? '-' : rp(price + fee);

            if (cod) {
                cod.disabled = !codOk;
                cod.closest('label').classList.toggle('off-cod', !codOk);
                if (!codOk && cod.checked) {
                    var alt = document.querySelector('input[name="payment_method"]:not([value="cod"]):not(:disabled)');
                    if (alt) { alt.checked = true; alt.dispatchEvent(new Event('change')); }
                }
            }
        }

        areas.forEach(function (r) { r.addEventListener('change', update); });
        svc.forEach(function (r) { r.addEventListener('change', function () { setTimeout(update, 0); }); });
        update();
    })();
</script>
@if ($isP)
<script>
    // Jumlah produk: harga ringkasan ikut berubah
    (function () {
        var input = document.getElementById('qtyInput'), box = document.getElementById('ocChosen');
        var unit = parseInt(box.dataset.unit, 10), stock = parseInt(box.dataset.stock, 10) || 1;
        function sync() {
            var q = Math.min(Math.max(parseInt(input.value, 10) || 1, 1), stock);
            input.value = q;
            box.dataset.price = 'Rp' + (unit * q).toLocaleString('id-ID');
            box.dispatchEvent(new Event('change'));
        }
        document.getElementById('qtyMinus').addEventListener('click', function () { input.value = (parseInt(input.value, 10) || 1) - 1; sync(); });
        document.getElementById('qtyPlus').addEventListener('click', function () { input.value = (parseInt(input.value, 10) || 1) + 1; sync(); });
        input.addEventListener('change', sync);
        sync();
    })();
</script>
@endif
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    (function () {
        var latEl = document.getElementById('mpLat'), lngEl = document.getElementById('mpLng');
        var info = document.getElementById('mpInfo'), addr = document.querySelector('textarea[name="shipping_address"]');
        var start = [-7.7956, 110.3695]; // titik awal peta; ubah sesuai kota toko
        var hasPin = latEl.value && lngEl.value;
        var map = L.map('mpMap').setView(hasPin ? [+latEl.value, +lngEl.value] : start, hasPin ? 16 : 12);
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 19, attribution: '&copy; OpenStreetMap' }).addTo(map);
        var marker = null;

        function setInfo(t) { info.innerHTML = '<i class="bi bi-geo-alt-fill"></i>' + t; }
        function place(lat, lng, fill) {
            if (!marker) {
                marker = L.marker([lat, lng], { draggable: true }).addTo(map);
                marker.on('dragend', function () { var p = marker.getLatLng(); place(p.lat, p.lng, true); });
            } else { marker.setLatLng([lat, lng]); }
            latEl.value = (+lat).toFixed(7); lngEl.value = (+lng).toFixed(7);
            setInfo('Lokasi tersimpan: ' + (+lat).toFixed(5) + ', ' + (+lng).toFixed(5));
            if (fill) { reverse(lat, lng); }
        }
        function reverse(lat, lng) {
            fetch('https://nominatim.openstreetmap.org/reverse?format=json&accept-language=id&lat=' + lat + '&lon=' + lng)
                .then(function (r) { return r.json(); })
                .then(function (d) {
                    if (d && d.display_name) {
                        setInfo(d.display_name);
                        if (addr && !addr.value.trim()) { addr.value = d.display_name; }
                    }
                }).catch(function () {});
        }
        function find() {
            var q = document.getElementById('mpQuery').value.trim();
            if (!q) { return; }
            setInfo('Mencari...');
            fetch('https://nominatim.openstreetmap.org/search?format=json&limit=1&countrycodes=id&accept-language=id&q=' + encodeURIComponent(q))
                .then(function (r) { return r.json(); })
                .then(function (d) {
                    if (!d.length) { setInfo('Alamat tidak ditemukan. Coba kata kunci lain atau klik langsung di peta.'); return; }
                    map.setView([d[0].lat, d[0].lon], 17); place(d[0].lat, d[0].lon, false); setInfo(d[0].display_name);
                }).catch(function () { setInfo('Gagal mencari. Periksa koneksi internet.'); });
        }
        document.getElementById('mpFind').addEventListener('click', find);
        document.getElementById('mpQuery').addEventListener('keydown', function (e) { if (e.key === 'Enter') { e.preventDefault(); find(); } });
        document.getElementById('mpGps').addEventListener('click', function () {
            if (!navigator.geolocation) { setInfo('Browser tidak mendukung GPS.'); return; }
            navigator.geolocation.getCurrentPosition(function (p) {
                map.setView([p.coords.latitude, p.coords.longitude], 17); place(p.coords.latitude, p.coords.longitude, true);
            }, function () { setInfo('Tidak bisa mengambil lokasi. Izinkan akses lokasi di browser.'); });
        });
        map.on('click', function (e) { place(e.latlng.lat, e.latlng.lng, true); });
        if (hasPin) { place(+latEl.value, +lngEl.value, false); }
    })();
</script>
@endsection