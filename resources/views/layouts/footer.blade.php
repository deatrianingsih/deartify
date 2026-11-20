{{-- Footer bersama (customer & halaman publik). Simpan di resources/views/layouts/footer.blade.php --}}
@php
    // ====== GANTI DI SINI ======
    $ftIg = 'de4.1479';              // username Instagram (tanpa @)
    $ftTiktok = 'x.dea07';          // username TikTok (tanpa @)
    $ftWa = '6281574793771';         // nomor WhatsApp, format 62..., tanpa 0 di depan dan tanpa +
    $ftWaText = 'Halo admin DeArtify, saya mau tanya soal pesanan.';
    // ===========================
@endphp
<style>
    .dx-foot {
    background: #5E4334;
    color: #E9D6BE;
    margin-top: auto;
    flex-shrink: 0;
    font-family: 'Nunito', sans-serif;
}

.dx-foot-in {
    max-width: 1100px;
    margin: 0 auto;
    padding: 1.8rem 1.25rem 1.2rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1.2rem;
    flex-wrap: wrap;
}

.dx-foot-brand {
    font-family: 'Caveat', cursive;
    font-size: 1.9rem;
    font-weight: 700;
    color: #FFD9A0;
    line-height: 1;
}

.dx-foot-brand small {
    display: block;
    font-family: 'Nunito', sans-serif;
    font-size: .82rem;
    font-weight: 600;
    color: #E9D6BE;
    margin-top: .3rem;
}

.dx-foot-soc {
    display: flex;
    gap: .7rem;
    flex-wrap: wrap;
}

.dx-foot-soc a {
    display: inline-flex;
    align-items: center;
    gap: .5rem;
    padding: .55rem 1rem;
    border-radius: 999px;
    background: rgba(255, 243, 224, .12);
    color: #FFF3E0;
    font-weight: 700;
    font-size: .9rem;
    text-decoration: none;
    transition: *background* .2s, transform .2s;
}

.dx-foot-soc a:hover {
    background: #FFF3E0;
    color: #5E4334;
    transform: translateY(-2px);
}

.dx-foot-soc i {
    font-size: 1.1rem;
}

.dx-foot-copy {
    border-top: 1px solid rgba(255, 243, 224, .15);
    text-align: center;
    padding: .9rem 1rem;
    font-size: .85rem;
}

.dx-foot-copy b {
    color: #FFD9A0;
}

@media (max-width: 575.98px) {
    .dx-foot-in {
        flex-direction: column;
        text-align: center;
    }

    .dx-foot-soc {
        justify-content: center;
    }
}
</style>
<footer class="dx-foot">
    <div class="dx-foot-in">
        <div class="dx-foot-brand">DeArtify<small>Jasa ilustrasi digital &amp; produk alat gambar</small></div>
        <div class="dx-foot-soc">
            <a href="https://www.instagram.com/{{ $ftIg }}" target="_blank" rel="noopener"><i class="bi bi-instagram"></i>Instagram</a>
            <a href="https://www.tiktok.com/@x.dea07{{ $ftTiktok }}" target="_blank" rel="noopener"><i class="bi bi-tiktok"></i>TikTok</a>
            <a href="https://wa.me/{{ $ftWa }}?text={{ urlencode($ftWaText) }}" target="_blank" rel="noopener"><i class="bi bi-whatsapp"></i>WhatsApp</a>
        </div>
    </div>
    <div class="dx-foot-copy">© {{ date('Y') }} <b>DeArtify</b>. Semua hak dilindungi.</div>
</footer>