@extends('layouts.dashboard')

@section('content')
<style>
    .oc-head { margin-bottom: 1.5rem; }
    .oc-back { display: inline-flex; align-items: center; gap: .4rem; color: var(--c-primary, #8B6F5B); font-weight: 700; font-size: .88rem; text-decoration: none; margin-bottom: .6rem; }
    .oc-back:hover { color: var(--c-dark, #6B4F3F); }
    .oc-head h1 { font-size: 1.9rem; font-weight: 800; color: var(--c-dark, #6B4F3F); margin: 0 0 .3rem; }
    .oc-head p { color: #85766B; margin: 0; }

    .oc-card { background: #fff; border-radius: 20px; box-shadow: 0 2px 14px rgba(74, 59, 50, .08); padding: 1.6rem; margin-bottom: 1.25rem; }
    .oc-title { display: flex; align-items: center; gap: .7rem; font-weight: 800; font-size: 1.05rem; color: var(--c-text, #4A3B32); margin: 0 0 1.2rem; }
    .oc-no { width: 28px; height: 28px; border-radius: 50%; background: var(--c-primary, #8B6F5B); color: #fff; font-size: .82rem; display: inline-flex; align-items: center; justify-content: center; flex-shrink: 0; }

    /* Pilih layanan */
    .oc-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap: 1rem; }
    .oc-svc { position: relative; display: block; border: 2px solid var(--c-line, #EFE3D3); border-radius: 16px; overflow: hidden; cursor: pointer; background: #fff; transition: border-color .2s, box-shadow .2s, transform .2s; }
    .oc-svc:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(74, 59, 50, .12); }
    .oc-svc:focus-within { outline: 3px solid var(--c-mid, #C9AF9A); outline-offset: 2px; }
    .oc-svc.selected { border-color: var(--c-primary, #8B6F5B); box-shadow: 0 0 0 3px rgba(139, 111, 91, .18); }
    .oc-radio { position: absolute; opacity: 0; pointer-events: none; }
    .oc-svc-img { height: 120px; background: var(--c-tint, #F5EAD8); }
    .oc-svc-img img { width: 100%; height: 100%; object-fit: cover; display: block; }
    .oc-ph { height: 100%; display: flex; align-items: center; justify-content: center; color: var(--c-mid, #C9AF9A); font-size: 2rem; }
    .oc-svc-body { padding: .75rem .9rem .9rem; }
    .oc-svc-body strong { display: block; font-size: .92rem; line-height: 1.3; margin-bottom: .2rem; }
    .oc-svc-body span { color: var(--c-dark, #6B4F3F); font-weight: 800; font-size: .95rem; }
    .oc-check { position: absolute; top: 10px; right: 10px; width: 26px; height: 26px; border-radius: 50%; background: var(--c-primary, #8B6F5B); color: #fff; display: none; align-items: center; justify-content: center; font-size: .9rem; }
    .oc-svc.selected .oc-check { display: flex; }

    /* Form */
    .oc-card .form-label { font-weight: 700; font-size: .88rem; color: var(--c-text, #4A3B32); margin-bottom: .4rem; }
    .oc-card .form-control { border-radius: 12px; border: 1.5px solid var(--c-line, #EFE3D3); padding: .7rem .95rem; background: #FDFAF6; }
    .oc-card .form-control:focus { border-color: var(--c-primary, #8B6F5B); box-shadow: 0 0 0 .2rem rgba(139, 111, 91, .18); background: #fff; }
    .oc-err { color: #dc3545; font-size: .82rem; margin-top: .35rem; }

    /* Upload */
    .oc-drop { position: relative; display: block; border: 2px dashed var(--c-mid, #C9AF9A); border-radius: 16px; background: #FDF9F3; padding: 1.4rem; text-align: center; cursor: pointer; transition: background .2s, border-color .2s; margin: 0; }
    .oc-drop:hover { background: var(--c-tint, #F5EAD8); border-color: var(--c-primary, #8B6F5B); }
    .oc-drop input { position: absolute; width: 1px; height: 1px; opacity: 0; overflow: hidden; }
    .oc-drop-empty i { font-size: 2.2rem; color: var(--c-primary, #8B6F5B); display: block; line-height: 1; margin-bottom: .5rem; }
    .oc-drop-empty strong { display: block; color: var(--c-text, #4A3B32); }
    .oc-drop small { color: #9A8B80; }
    .oc-drop-preview { display: none; align-items: center; gap: 1rem; text-align: left; }
    .oc-drop-preview img { width: 84px; height: 84px; object-fit: cover; border-radius: 12px; flex-shrink: 0; }
    .oc-drop-preview strong { display: block; word-break: break-all; }
    .oc-drop.has-file .oc-drop-empty { display: none; }
    .oc-drop.has-file .oc-drop-preview { display: flex; }

    /* Ringkasan */
    .oc-sticky { position: sticky; top: 96px; }
    .oc-sum-img { height: 170px; border-radius: 14px; overflow: hidden; background: var(--c-tint, #F5EAD8); margin-bottom: 1rem; }
    .oc-sum-img img { width: 100%; height: 100%; object-fit: cover; display: block; }
    .oc-sum-name { font-weight: 800; font-size: 1.05rem; margin: 0 0 .15rem; }
    .oc-sum-empty { color: #9A8B80; }
    .oc-rows { margin: 1rem 0; border-top: 1px solid var(--c-line, #EFE3D3); }
    .oc-row { display: flex; justify-content: space-between; gap: 1rem; padding: .65rem 0; border-bottom: 1px solid var(--c-line, #EFE3D3); font-size: .9rem; }
    .oc-row span:first-child { color: #85766B; }
    .oc-row.total { border-bottom: 0; font-size: 1.05rem; }
    .oc-row.total strong { font-size: 1.3rem; color: var(--c-dark, #6B4F3F); }
    .oc-submit { display: flex; align-items: center; justify-content: center; gap: .5rem; width: 100%; border: 0; border-radius: 12px; padding: .85rem; background: var(--c-primary, #8B6F5B); color: #fff; font-weight: 800; transition: background .2s; }
    .oc-submit:hover { background: var(--c-dark, #6B4F3F); }
    .oc-cancel { display: block; text-align: center; margin-top: .6rem; padding: .7rem; border-radius: 12px; border: 1.5px solid var(--c-mid, #C9AF9A); color: var(--c-dark, #6B4F3F); font-weight: 700; text-decoration: none; }
    .oc-cancel:hover { background: var(--c-soft, #EDDECA); color: var(--c-dark, #6B4F3F); }
    .oc-tips { background: var(--c-soft, #EDDECA); border-radius: 20px; padding: 1.3rem 1.4rem; color: var(--c-dark, #6B4F3F); }
    .oc-tips h6 { font-weight: 800; margin: 0 0 .7rem; display: flex; gap: .5rem; align-items: center; }
    .oc-tips ul { list-style: none; margin: 0; padding: 0; font-size: .86rem; }
    .oc-tips li { display: flex; gap: .55rem; margin-bottom: .45rem; }
    .oc-tips li i { color: var(--c-primary, #8B6F5B); margin-top: .1rem; }

    @media (max-width: 991.98px) { .oc-sticky { position: static; } }
</style>

<div class="oc-head">
    <a href="{{ route('orders.index') }}" class="oc-back"><i class="bi bi-arrow-left"></i>Kembali ke Pesanan Saya</a>
    <h1>Buat Pesanan Baru</h1>
    <p>Pilih layanan, ceritakan gambar yang kamu mau, lalu kirim pesananmu.</p>
</div>

<form action="{{ route('orders.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="row g-4">
        {{-- Kolom kiri: form --}}
        <div class="col-lg-8">
            <div class="oc-card">
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
                @error('service_price_id')
                    <div class="oc-err">{{ $message }}</div>
                @enderror
            </div>

            <div class="oc-card">
                <h5 class="oc-title"><span class="oc-no">2</span>Detail Pesanan</h5>
                <textarea name="description" rows="5" placeholder="Jelaskan detail gambar yang kamu inginkan, misalnya gaya, warna, ekspresi, atau suasana..." class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                @error('description')
                    <div class="oc-err">{{ $message }}</div>
                @enderror
            </div>

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

            <div class="oc-card">
                <h5 class="oc-title"><span class="oc-no">4</span>Data Penerima</h5>
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
                </div>
            </div>
        </div>

        {{-- Kolom kanan: ringkasan --}}
        <div class="col-lg-4">
            <div class="oc-sticky">
                <div class="oc-card">
                    <h5 class="oc-title"><i class="bi bi-receipt" style="color: var(--c-primary, #8B6F5B);"></i>Ringkasan Pesanan</h5>

                    <div class="oc-sum-img" id="sumImg"></div>
                    <p class="oc-sum-name" id="sumName">Belum memilih layanan</p>
                    <p class="oc-sum-empty small mb-0" id="sumHint">Pilih salah satu layanan di sebelah kiri.</p>

                    <div class="oc-rows">
                        <div class="oc-row"><span>Harga layanan</span><strong id="sumPrice">-</strong></div>
                        <div class="oc-row"><span>Pembayaran</span><strong>COD (bayar di tempat)</strong></div>
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
        var radios = document.querySelectorAll('.oc-radio');
        var sumImg = document.getElementById('sumImg');
        var sumName = document.getElementById('sumName');
        var sumHint = document.getElementById('sumHint');
        var sumPrice = document.getElementById('sumPrice');
        var sumTotal = document.getElementById('sumTotal');

        function renderSummary() {
            var selected = null;
            radios.forEach(function (r) {
                r.closest('.oc-svc').classList.toggle('selected', r.checked);
                if (r.checked) { selected = r; }
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

        file.addEventListener('change', function () {
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
@endsection