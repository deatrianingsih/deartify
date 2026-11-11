@extends('layouts.dashboard')

@push('styles')
<style>
    .ct-wrap { max-width: 1100px; margin: 0 auto; }
    .ct-head h3 { margin: 0 0 .2rem; font-weight: 800; color: var(--c-text, #4A3B32); display: flex; align-items: center; gap: .6rem; }
    .ct-head h3 i { color: var(--c-primary, #8B6F5B); }
    .ct-head p { color: #85766B; margin-bottom: 1.3rem; }
    .ct-card { background: #fff; border: 1px solid var(--c-line, #EFE3D3); border-radius: 18px; box-shadow: 0 2px 12px rgba(74, 59, 50, .06); }
    .ct-item { display: flex; gap: 1rem; align-items: center; padding: 1rem 1.2rem; border-bottom: 1px solid var(--c-line, #EFE3D3); }
    .ct-item:last-child { border-bottom: 0; }
    .ct-img { width: 84px; height: 84px; border-radius: 14px; background: var(--c-soft, #EDDECA); overflow: hidden; flex-shrink: 0; display: flex; align-items: center; justify-content: center; color: var(--c-mid, #C9AF9A); font-size: 1.6rem; }
    .ct-img img { width: 100%; height: 100%; object-fit: cover; }
    .ct-info { flex: 1; min-width: 0; }
    .ct-type { display: inline-block; font-size: .7rem; font-weight: 800; padding: .15rem .6rem; border-radius: 999px; background: var(--c-tint, #F5EAD8); color: var(--c-dark, #5E4334); margin-bottom: .25rem; }
    .ct-type.prd { background: #FDEBD0; color: #A8700C; }
    .ct-info h6 { margin: 0 0 .15rem; font-weight: 800; font-size: 1.02rem; color: var(--c-text, #4A3B32); }
    .ct-info small { color: #85766B; }
    .ct-qty { display: inline-flex; align-items: center; border: 1.5px solid var(--c-line, #EFE3D3); border-radius: 12px; overflow: hidden; background: #fff; }
    .ct-qty button { width: 34px; height: 36px; border: 0; background: var(--c-tint, #F5EAD8); color: var(--c-dark, #5E4334); font-weight: 800; }
    .ct-qty button:hover { background: var(--c-soft, #EDDECA); }
    .ct-qty input { width: 46px; height: 36px; border: 0; text-align: center; font-weight: 800; -moz-appearance: textfield; }
    .ct-qty input::-webkit-outer-spin-button, .ct-qty input::-webkit-inner-spin-button { -webkit-appearance: none; margin: 0; }
    .ct-qty input:focus { outline: none; }
    .ct-sub { text-align: right; min-width: 120px; }
    .ct-sub b { display: block; font-size: 1.05rem; color: var(--c-dark, #5E4334); }
    .ct-del { border: 0; background: none; color: #B3402F; font-size: .82rem; font-weight: 700; padding: 0; margin-top: .3rem; }
    .ct-del:hover { text-decoration: underline; }
    .ct-sum { padding: 1.3rem; position: sticky; top: 90px; }
    .ct-sum h5 { font-weight: 800; font-size: 1.05rem; margin-bottom: 1rem; color: var(--c-text, #4A3B32); }
    .ct-row { display: flex; justify-content: space-between; margin-bottom: .6rem; color: #6F6258; font-size: .93rem; }
    .ct-row.total { border-top: 1px dashed var(--c-line, #EFE3D3); padding-top: .8rem; margin-top: .8rem; font-weight: 800; color: var(--c-text, #4A3B32); font-size: 1.1rem; }
    .ct-go { display: flex; align-items: center; justify-content: center; gap: .5rem; width: 100%; margin-top: 1rem; padding: .85rem 1rem; border-radius: 12px; background: var(--c-primary, #8B6F5B); color: #fff; font-weight: 800; text-decoration: none; }
    .ct-go:hover { background: var(--c-dark, #5E4334); color: #fff; }
    .ct-more { display: block; text-align: center; margin-top: .8rem; color: var(--c-primary, #8B6F5B); font-weight: 700; font-size: .9rem; text-decoration: none; }
    .ct-empty { text-align: center; padding: 3rem 1rem; color: #85766B; }
    .ct-empty i { font-size: 3.2rem; color: var(--c-mid, #C9AF9A); display: block; margin-bottom: .5rem; }
    .ct-empty a { display: inline-flex; gap: .4rem; align-items: center; margin-top: 1rem; background: var(--c-primary, #8B6F5B); color: #fff; font-weight: 800; border-radius: 12px; padding: .7rem 1.4rem; text-decoration: none; }
    @media (max-width: 575.98px) {
        .ct-item { flex-wrap: wrap; }
        .ct-sub { text-align: left; min-width: 0; margin-left: auto; }
    }
</style>
@endpush

@section('content')
<div class="ct-wrap">
    <div class="ct-head">
        <h3><i class="bi bi-cart3"></i>Keranjang Saya</h3>
        <p>Jasa gambar dan produk bisa dibayar sekaligus dengan satu alamat pengiriman.</p>
    </div>

    @if (empty($lines))
        <div class="ct-card ct-empty">
            <i class="bi bi-cart-x"></i>
            Keranjangmu masih kosong.
            <div><a href="{{ route('service_prices.index') }}"><i class="bi bi-palette"></i>Lihat Layanan & Harga</a></div>
        </div>
    @else
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="ct-card">
                    @foreach ($lines as $line)
                        <div class="ct-item">
                            <div class="ct-img">@if ($line['image'])<img src="{{ Storage::url($line['image']) }}" alt="">@else<i class="bi bi-image"></i>@endif</div>
                            <div class="ct-info">
                                <span class="ct-type {{ $line['type'] === 'product' ? 'prd' : '' }}">{{ $line['type'] === 'product' ? 'Produk' : 'Jasa Gambar' }}</span>
                                <h6>{{ $line['name'] }}</h6>
                                <small>Rp{{ number_format($line['price'], 0, ',', '.') }} {{ $line['type'] === 'product' ? '/ item' : '' }}@if ($line['type'] === 'product') &bull; stok {{ $line['stock'] }}@endif</small>
                            </div>

                            <form action="{{ route('cart.update', $line['key']) }}" method="POST" class="ct-qty-form">
                                @csrf @method('PATCH')
                                <div class="ct-qty">
                                    <button type="button" data-d="-1" aria-label="Kurangi">&minus;</button>
                                    <input type="number" name="qty" value="{{ $line['qty'] }}" min="1" max="{{ $line['type'] === 'product' ? max(1, $line['stock']) : 99 }}">
                                    <button type="button" data-d="1" aria-label="Tambah">+</button>
                                </div>
                            </form>

                            <div class="ct-sub">
                                <b>Rp{{ number_format($line['subtotal'], 0, ',', '.') }}</b>
                                <form action="{{ route('cart.remove', $line['key']) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="ct-del"><i class="bi bi-trash"></i> Hapus</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
                <a href="{{ route('service_prices.index') }}" class="ct-more"><i class="bi bi-plus-circle"></i> Tambah layanan atau produk lain</a>
            </div>

            <div class="col-lg-4">
                <div class="ct-card ct-sum">
                    <h5>Ringkasan</h5>
                    <div class="ct-row"><span>Jumlah item</span><span>{{ collect($lines)->sum('qty') }}</span></div>
                    <div class="ct-row"><span>Subtotal</span><span>Rp{{ number_format($subtotal, 0, ',', '.') }}</span></div>
                    <div class="ct-row"><span>Ongkir</span><span class="text-muted small">dihitung di checkout</span></div>
                    <div class="ct-row total"><span>Total</span><span>Rp{{ number_format($subtotal, 0, ',', '.') }}</span></div>
                    <a href="{{ route('cart.checkout') }}" class="ct-go">Checkout <i class="bi bi-arrow-right"></i></a>
                </div>
            </div>
        </div>
    @endif
</div>

<script>
    document.querySelectorAll('.ct-qty-form').forEach(function (f) {
        var input = f.querySelector('input');
        f.querySelectorAll('button[data-d]').forEach(function (b) {
            b.addEventListener('click', function () {
                var v = (parseInt(input.value, 10) || 1) + parseInt(b.dataset.d, 10);
                v = Math.min(Math.max(v, 1), parseInt(input.max, 10) || 99);
                if (String(v) !== input.value) { input.value = v; f.submit(); }
            });
        });
        input.addEventListener('change', function () { f.submit(); });
    });
</script>
@endsection