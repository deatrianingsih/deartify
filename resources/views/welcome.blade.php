@extends('layouts.public')

@section('content')
@php
    $featured = $services ?? $servicePrices ?? \App\Models\ServicePrice::latest()->take(4)->get();
@endphp
<header class="hero" id="beranda">
    <div class="wrap">
        <div class="hero-box">
            <span class="hero-tag"><i class="bi bi-stars"></i>Jasa gambar online terpercaya</span>
            <h1>Wujudkan gambar impianmu bersama <span>DeArtify</span></h1>
            <p>Pilih layanan, ceritakan gambar yang kamu mau, lalu pantau pesananmu sampai selesai. Mudah, aman, dan praktis.</p>
            <div class="hero-btns">
                <a href="#layanan" class="btn-d">Lihat Layanan <i class="bi bi-arrow-right"></i></a>
                <a href="{{ route('register') }}" class="btn-l">Daftar Sekarang</a>
            </div>
            <div class="hero-stats">
                <div><strong>{{ \App\Models\ServicePrice::count() }}+</strong><small>Pilihan layanan</small></div>
                <div><strong>COD</strong><small>Bayar di tempat</small></div>
                <div><strong><i class="bi bi-star-fill"></i> 5.0</strong><small>Ulasan pelanggan</small></div>
            </div>
        </div>
    </div>
</header>

<section class="sec">
    <div class="wrap">
        <div class="sec-head">
            <div class="kicker">Keunggulan</div>
            <h2>Kenapa Memilih DeArtify?</h2>
        </div>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 g-4">
            <div class="col"><div class="feat"><div class="ico"><i class="bi bi-brush"></i></div><h5>Hasil Berkualitas</h5><p>Dikerjakan oleh tim profesional dengan hasil terbaik.</p></div></div>
            <div class="col"><div class="feat"><div class="ico"><i class="bi bi-shield-check"></i></div><h5>Proses Aman</h5><p>Data dan transaksi kamu terlindungi.</p></div></div>
            <div class="col"><div class="feat"><div class="ico"><i class="bi bi-clock-history"></i></div><h5>Tepat Waktu</h5><p>Sesuai dengan estimasi waktu yang diberikan.</p></div></div>
            <div class="col"><div class="feat"><div class="ico"><i class="bi bi-tag"></i></div><h5>Harga Terjangkau</h5><p>Kualitas terbaik dengan harga yang bersahabat.</p></div></div>
        </div>
    </div>
</section>

<section class="sec alt" id="layanan">
    <div class="wrap">
        <div class="sec-head">
            <div class="kicker">Layanan</div>
            <h2>Layanan & Produk Kami</h2>
            <p>Lihat-lihat dulu, kalau sudah cocok tinggal login untuk memesan.</p>
        </div>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 g-4">
            @forelse ($featured as $s)
                <div class="col">
                    <a href="{{ route('login') }}" class="svc">
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
                    </a>
                </div>
            @empty
                <div class="col-12 text-center text-muted">Layanan belum tersedia.</div>
            @endforelse
        </div>
        <div class="more"><a href="{{ url('/layanan') }}" class="btn-p">Lihat Semua Layanan & Produk <i class="bi bi-arrow-right"></i></a></div>
    </div>
</section>

<section class="sec" id="cara">
    <div class="wrap">
        <div class="sec-head">
            <div class="kicker">Langkah mudah</div>
            <h2>Cara Pesan</h2>
        </div>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 g-4 steps">
            <div class="col"><div class="step"><span class="no">1</span><div class="ico"><i class="bi bi-palette"></i></div><h5>Pilih Layanan</h5><p>Lihat daftar jasa gambar beserta harganya, lalu pilih yang kamu suka.</p></div></div>
            <div class="col"><div class="step"><span class="no">2</span><div class="ico"><i class="bi bi-cloud-arrow-up"></i></div><h5>Isi Detail & Referensi</h5><p>Ceritakan gambar yang kamu mau dan unggah gambar referensi.</p></div></div>
            <div class="col"><div class="step"><span class="no">3</span><div class="ico"><i class="bi bi-truck"></i></div><h5>Pantau Pesanan</h5><p>Cek status pesananmu dari menunggu, diproses, dikirim, sampai selesai.</p></div></div>
            <div class="col"><div class="step"><span class="no">4</span><div class="ico"><i class="bi bi-star"></i></div><h5>Terima & Beri Ulasan</h5><p>Bayar di tempat (COD), lalu beri rating dan ulasan atas hasilnya.</p></div></div>
        </div>
    </div>
</section>

<section class="sec alt" id="tentang">
    <div class="wrap about">
        <div>
            <div class="kicker" style="color:var(--p);font-weight:800;letter-spacing:.12em;text-transform:uppercase;font-size:.8rem;">Tentang Kami</div>
            <h2>Satu tempat untuk semua kebutuhan gambarmu</h2>
            <p>DeArtify adalah aplikasi pemesanan jasa gambar online. Kamu bisa memilih layanan, menceritakan gambar yang kamu mau, mengirim referensi, lalu memantau pesananmu sampai selesai dengan mudah dan aman, semuanya dalam satu tempat.</p>
        </div>
        <div class="about-card">
            <div class="script">Siap memesan?</div>
            <p>Daftar gratis dan mulai pesan gambar pertamamu hari ini.</p>
            <a href="{{ route('register') }}" class="btn-d">Daftar Sekarang <i class="bi bi-arrow-right"></i></a>
        </div>
    </div>
</section>
@endsection