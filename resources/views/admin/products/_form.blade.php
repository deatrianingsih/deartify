@php
    $p = $product ?? null;
    $catIcons = ['kertas' => 'bi-file-earmark-text', 'pulpen' => 'bi-pen', 'pensil' => 'bi-pencil', 'lainnya' => 'bi-box-seam'];
    $catNow = old('category', $p?->category ?? 'kertas');
@endphp

@push('styles')
<style>
    
.pf-card {
    background: #fff;
    border: 1px solid #EFE3D3;
    border-radius: 22px;
    box-shadow: 0 2px 14px rgba(74, 59, 50, .07);
    padding: 1.5rem;
    margin-bottom: 1.1rem;
}

.pf-title {
    display: flex;
    align-items: center;
    gap: .6rem;
    font-weight: 800;
    color: #4A3B32;
    margin: 0 0 1.1rem;
    font-size: 1.05rem;
}

.pf-no {
    width: 28px;
    height: 28px;
    border-radius: 50%;
    background: #8B6F5B;
    color: #fff;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: .85rem;
}

.pf-lbl {
    display: block;
    font-weight: 800;
    font-size: .86rem;
    color: #4A3B32;
    margin-bottom: .4rem;
}

.pf-lbl small {
    font-weight: 600;
    color: #9A8B80;
}

.pf-in {
    width: 100%;
    border: 1.5px solid #EFE3D3;
    background: #FDFAF6;
    border-radius: 14px;
    padding: .75rem 1rem;
    font-size: .97rem;
    transition: border-color .2s, box-shadow .2s, background .2s;
}

.pf-in:focus {
    outline: none;
    border-color: #8B6F5B;
    background: #fff;
    box-shadow: 0 0 0 .22rem rgba(139, 111, 91, .18);
}

.pf-in.bad {
    border-color: #D98A80;
}

textarea.pf-in {
    resize: vertical;
    min-height: 110px;
}

.pf-err {
    color: #B3402F;
    font-size: .83rem;
    font-weight: 700;
    margin-top: .35rem;
}

.pf-cats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(110px, 1fr));
    gap: .7rem;
}

.pf-cat {
    position: relative;
    display: block;
    margin: 0;
}

.pf-cat input {
    position: absolute;
    inset: 0;
    opacity: 0;
    cursor: pointer;
    z-index: 2;
}

.pf-cat .box {
    display: block;
    text-align: center;
    border: 2px solid #EFE3D3;
    border-radius: 16px;
    padding: .85rem .4rem;
    background: #FDFAF6;
    transition: all .2s;
}

.pf-cat .box i {
    display: block;
    font-size: 1.5rem;
    color: #B59A85;
    margin-bottom: .2rem;
    transition: color .2s;
}

.pf-cat .box b {
    font-size: .9rem;
    color: #4A3B32;
}

.pf-cat:hover .box {
    border-color: #C9AF9A;
    transform: translateY(-2px);
}

.pf-cat input:checked + .box {
    border-color: #8B6F5B;
    background: #F5EAD8;
    box-shadow: 0 8px 18px rgba(139, 111, 91, .22);
}

.pf-cat input:checked + .box i {
    color: #8B6F5B;
}

.pf-money {
    position: relative;
}

.pf-money span {
    position: absolute;
    left: 1rem;
    top: 50%;
    transform: translateY(-50%);
    font-weight: 800;
    color: #8B6F5B;
}

.pf-money .pf-in {
    padding-left: 2.8rem;
    font-weight: 800;
}

.pf-step {
    display: flex;
    align-items: center;
    gap: .5rem;
}

.pf-step button {
    width: 46px;
    height: 46px;
    flex-shrink: 0;
    border: 1.5px solid #EFE3D3;
    background: #F5EAD8;
    color: #5E4334;
    border-radius: 14px;
    font-size: 1.2rem;
    font-weight: 800;
}

.pf-step button:hover {
    background: #8B6F5B;
    color: #fff;
}

.pf-step .pf-in {
    text-align: center;
    font-weight: 800;
}

.pf-drop {
    position: relative;
    border: 2px dashed #D9C3A8;
    border-radius: 18px;
    background: #FBF3E8;
    text-align: center;
    padding: 1.6rem 1rem;
    cursor: pointer;
    transition: border-color .2s, background .2s;
    overflow: hidden;
}

.pf-drop:hover {
    border-color: #8B6F5B;
    background: #F5EAD8;
}

.pf-drop input {
    position: absolute;
    inset: 0;
    opacity: 0;
    cursor: pointer;
}

.pf-drop > i {
    font-size: 2.4rem;
    color: #B59A85;
    display: block;
}

.pf-drop b {
    display: block;
    color: #4A3B32;
}

.pf-drop small {
    color: #9A8B80;
}

.pf-drop img {
    display: none;
    width: 100%;
    max-height: 260px;
    object-fit: cover;
    border-radius: 12px;
}

.pf-drop.has .ph {
    display: none;
}

.pf-drop.has img {
    display: block;
}

.pf-drop.has {
    padding: .6rem;
}

.pf-fname {
    margin-top: .6rem;
    color: #85766B;
    font-size: .85rem;
    text-align: center;
    word-break: break-all;
}

.pf-bar {
    display: flex;
    gap: .7rem;
}

.pf-save {
    flex: 1;
    border: 0;
    border-radius: 14px;
    padding: .9rem 1rem;
    background: linear-gradient(135deg, #8B6F5B, #5E4334);
    color: #fff;
    font-weight: 800;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: .5rem;
    box-shadow: 0 10px 22px rgba(94, 67, 52, .3);
    transition: transform .2s;
}

.pf-save:hover {
    transform: translateY(-2px);
}

.pf-cancel {
    padding: .9rem 1.4rem;
    border-radius: 14px;
    border: 2px solid #D9C3A8;
    background: #fff;
    color: #6B4F3F;
    font-weight: 800;
    text-decoration: none;
    text-align: center;
}

.pf-cancel:hover {
    background: #F5EAD8;
    color: #5E4334;
}

.pf-tip {
    background: #FBF3E8;
    border-radius: 18px;
    padding: 1rem 1.2rem;
    color: #6B5B50;
    font-size: .88rem;
}

.pf-tip b {
    color: #5E4334;
}

.pf-tip li {
    margin-bottom: .3rem;
}

</style>
@endpush

<div class="row g-3">
    {{-- Kiri: data produk --}}
    <div class="col-lg-7">
        <div class="pf-card">
            <h5 class="pf-title"><span class="pf-no">1</span>Informasi Produk</h5>

            <div class="mb-3">
                <label class="pf-lbl" for="name">Nama Produk</label>
                <input type="text" id="name" name="name" value="{{ old('name', $p?->name) }}" placeholder="Contoh: Kertas Gambar A3" class="pf-in @error('name') bad @enderror" required>
                @error('name')<div class="pf-err">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="pf-lbl">Kategori</label>
                <div class="pf-cats">
                    @foreach (\App\Models\Product::CATEGORIES as $key => $label)
                        <label class="pf-cat">
                            <input type="radio" name="category" value="{{ $key }}" {{ $catNow === $key ? 'checked' : '' }}>
                            <span class="box"><i class="bi {{ $catIcons[$key] ?? 'bi-box-seam' }}"></i><b>{{ $label }}</b></span>
                        </label>
                    @endforeach
                </div>
                @error('category')<div class="pf-err">{{ $message }}</div>@enderror
            </div>

            <div>
                <label class="pf-lbl" for="description">Deskripsi <small>(opsional)</small></label>
                <textarea id="description" name="description" rows="4" placeholder="Jelaskan ukuran, bahan, atau keunggulan produk" class="pf-in @error('description') bad @enderror">{{ old('description', $p?->description) }}</textarea>
                @error('description')<div class="pf-err">{{ $message }}</div>@enderror
            </div>
        </div>

        <div class="pf-card">
            <h5 class="pf-title"><span class="pf-no">2</span>Harga & Stok</h5>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="pf-lbl" for="price">Harga</label>
                    <div class="pf-money">
                        <span>Rp</span>
                        <input type="number" id="price" name="price" min="0" step="500" value="{{ old('price', $p ? (int) $p->price : '') }}" placeholder="0" class="pf-in @error('price') bad @enderror" required>
                    </div>
                    @error('price')<div class="pf-err">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="pf-lbl" for="stock">Stok</label>
                    <div class="pf-step">
                        <button type="button" data-step="-1" aria-label="Kurangi">&minus;</button>
                        <input type="number" id="stock" name="stock" min="0" value="{{ old('stock', $p?->stock ?? 0) }}" class="pf-in @error('stock') bad @enderror" required>
                        <button type="button" data-step="1" aria-label="Tambah">+</button>
                    </div>
                    @error('stock')<div class="pf-err">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>
    </div>

    {{-- Kanan: foto + simpan --}}
    <div class="col-lg-5">
        <div class="pf-card">
            <h5 class="pf-title"><span class="pf-no">3</span>Foto Produk</h5>
            @php $hasImg = (bool) $p?->image; @endphp
            <div class="pf-drop {{ $hasImg ? 'has' : '' }}" id="pfDrop">
                <input type="file" name="image" id="pfFile" accept="image/*">
                <div class="ph"><i class="bi bi-cloud-arrow-up"></i><b>Klik untuk pilih foto</b><small>JPG atau PNG, maksimal 2 MB</small></div>
                <img id="pfPrev" alt="Pratinjau" src="{{ $hasImg ? Storage::url($p->image) : '' }}">
            </div>
            <div class="pf-fname" id="pfName">{{ $hasImg ? 'Foto saat ini. Pilih foto baru untuk menggantinya.' : '' }}</div>
            @error('image')<div class="pf-err">{{ $message }}</div>@enderror
        </div>

        <div class="pf-card">
            <div class="pf-bar">
                <a href="{{ route('admin.products.index') }}" class="pf-cancel">Batal</a>
                <button type="submit" class="pf-save"><i class="bi bi-check2-circle"></i>{{ $submit ?? 'Simpan' }}</button>
            </div>
        </div>

        <div class="pf-tip">
            <b><i class="bi bi-lightbulb"></i> Tips</b>
            <ul class="mb-0 mt-2 ps-3">
                <li>Pakai foto yang terang dan tidak buram.</li>
                <li>Isi stok 0 kalau produk sedang habis.</li>
            </ul>
        </div>
    </div>
</div>

<script>
    (function () {
        var stock = document.getElementById('stock');
        document.querySelectorAll('[data-step]').forEach(function (b) {
            b.addEventListener('click', function () {
                stock.value = Math.max(0, (parseInt(stock.value, 10) || 0) + parseInt(b.dataset.step, 10));
            });
        });

        var file = document.getElementById('pfFile'), drop = document.getElementById('pfDrop');
        var prev = document.getElementById('pfPrev'), name = document.getElementById('pfName');
        file.addEventListener('change', function () {
            var f = file.files && file.files[0];
            if (!f) { return; }
            name.textContent = f.name;
            var r = new FileReader();
            r.onload = function (e) { prev.src = e.target.result; };
            r.readAsDataURL(f);
            drop.classList.add('has');
        });
    })();
</script>