<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Penjualan DeArtify</title>
    @php
        $rp = fn ($v) => 'Rp' . number_format($v, 0, ',', '.');
        $tgl = fn ($d) => $d->copy()->locale('id')->translatedFormat('j F Y');
        $statusLabels = ['pending' => 'Menunggu', 'in_progress' => 'Diproses', 'shipped' => 'Dikirim', 'completed' => 'Selesai', 'cancelled' => 'Dibatalkan'];
        $maxRevenue = max(1, (float) collect($periods)->max('revenue'));
        $maxService = max(1, (float) ($topServices->max('revenue') ?? 0));
        $sales = collect($sales)->sortBy('updated_at')->values();
        $totalSales = $sales->sum('total_price');
        $avg = $sales->count() ? $totalSales / $sales->count() : 0;
        $barH = 110;
        $n = max(1, count($periods));
    @endphp
    <style>
       
/* PAGE & GLOBAL */
@page {
    margin: 30px 34px;
}

* {
    box-sizing: border-box;
}

body {
    font-family: DejaVu Sans, sans-serif;
    font-size: 10px;
    color: #4A3B32;
    margin: 0;
}

.muted {
    color: #85766B;
}

.r {
    text-align: right;
}

.c {
    text-align: center;
}

table {
    width: 100%;
    border-collapse: collapse;
}

/* HEADER / KOP */
.kop {
    border-bottom: 3px solid #5E4334;
    padding-bottom: 10px;
    margin-bottom: 4px;
}

.kop td {
    vertical-align: middle;
}

.brand {
    font-size: 22px;
    font-weight: bold;
    color: #5E4334;
}

.brand small {
    display: block;
    font-size: 9px;
    font-weight: normal;
    color: #85766B;
    margin-top: 2px;
}

.doc-title {
    text-align: right;
}

.doc-title b {
    display: block;
    font-size: 15px;
    color: #5E4334;
    letter-spacing: .5px;
}

.line2 {
    border-bottom: 1px solid #C9AF9A;
    margin-bottom: 14px;
}

/* DOCUMENT META */
.meta td {
    padding: 2px 0;
    font-size: 10px;
}

.meta td:first-child {
    width: 90px;
    color: #85766B;
}

/* SECTION TITLE */
h2 {
    font-size: 11px;
    margin: 18px 0 7px;
    color: #fff;
    background: #8B6F5B;
    padding: 5px 9px;
    letter-spacing: .4px;
}

/* SUMMARY CARDS */
.cards td {
    width: 25%;
    padding: 0 5px 0 0;
    border: 0;
}

.cards td:last-child {
    padding-right: 0;
}

.card {
    border: 1px solid #E5D2B8;
    border-top: 3px solid #8B6F5B;
    background: #FBF3E8;
    padding: 8px 10px;
}

.card .l {
    color: #85766B;
    font-size: 9px;
}

.card .v {
    font-size: 14px;
    font-weight: bold;
    color: #4A3B32;
    margin-top: 3px;
}

.card.hi {
    background: #5E4334;
    border-color: #5E4334;
    border-top-color: #E0A21B;
}

.card.hi .l {
    color: #E9D6BE;
}

.card.hi .v {
    color: #fff;
}

/* CHART */
.chart {
    border: 1px solid #E5D2B8;
    background: #FFFDF9;
    padding: 10px 10px 6px;
}

.chart table {
    table-layout: fixed;
}

.chart td {
    padding: 0 1px;
    vertical-align: bottom;
    text-align: center;
    border: 0;
}

.bar {
    background: #8B6F5B;
    margin: 0 auto;
    width: 100%;
}

.bar.zero {
    background: #EADCC8;
}

.lbl {
    font-size: 7px;
    color: #85766B;
    padding-top: 3px !important;
}

.val {
    font-size: 7px;
    color: #5E4334;
    font-weight: bold;
}

.axis {
    border-top: 1px solid #C9AF9A;
}

/* DATA TABLE */
.tbl th {
    background: #EDDECA;
    color: #4A3B32;
    text-align: left;
    padding: 6px 7px;
    font-size: 9px;
    border-bottom: 2px solid #C9AF9A;
}

.tbl td {
    padding: 5px 7px;
    border-bottom: 1px solid #EFE3D3;
}

.tbl tr:nth-child(even) td {
    background: #FDFAF5;
}

.tbl tfoot td {
    background: #F5EAD8;
    font-weight: bold;
    border-top: 2px solid #8B6F5B;
    font-size: 11px;
}

/* MINI PROGRESS */
.mini-bg {
    background: #F1E6D6;
    height: 7px;
}

.mini {
    background: #8B6F5B;
    height: 7px;
}

/* STATISTICS */
.stat td {
    border: 1px solid #E5D2B8;
    padding: 6px 8px;
    text-align: center;
    background: #FBF3E8;
}

.stat b {
    display: block;
    font-size: 13px;
    color: #5E4334;
}

/* SIGNATURE */
.sign {
    margin-top: 28px;
    width: 100%;
}

.sign td {
    width: 50%;
    vertical-align: top;
}

.sign .box {
    width: 190px;
    text-align: center;
    margin-left: auto;
}

.sign .gap {
    height: 55px;
}

/* NOTE */
.note {
    margin-top: 16px;
    font-size: 8.5px;
    color: #85766B;
    border-top: 1px dashed #C9AF9A;
    padding-top: 6px;
}

/* TOOLBAR */
.toolbar {
    background: #5E4334;
    color: #fff;
    padding: 10px 16px;
    font-family: sans-serif;
    font-size: 13px;
    margin: -30px -34px 18px;
}

.toolbar button {
    margin-left: 10px;
    padding: 5px 14px;
    border: 0;
    border-radius: 6px;
    background: #FFF3E0;
    color: #5E4334;
    font-weight: bold;
    cursor: pointer;
}

/* PRINT */
@media print {
    .toolbar {
        display: none;
    }

    * {
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }
}

/* SCREEN */
@media screen {
    body {
        max-width: 900px;
        margin: 0 auto;
        padding: 0 34px 40px;
    }
}

    </style>
</head>
<body>
@if ($printMode)
    <div class="toolbar">Pratinjau cetak — pilih <b>Save as PDF</b> di jendela cetak.
        <button onclick="window.print()">Cetak / Simpan PDF</button>
    </div>
@endif

<table class="kop">
    <tr>
        <td class="brand">DeArtify<small>Jasa Gambar Online</small></td>
        <td class="doc-title"><b>LAPORAN PENJUALAN</b><span class="muted">Rekap penghasilan dari pesanan selesai</span></td>
    </tr>
</table>
<div class="line2"></div>

<table class="meta">
    <tr><td>Periode</td><td>: {{ $tgl($from) }} s/d {{ $tgl($to) }}</td></tr>
    <tr><td>Dicetak pada</td><td>: {{ now()->locale('id')->translatedFormat('j F Y, H:i') }} WIB</td></tr>
    <tr><td>Dicetak oleh</td><td>: {{ auth()->user()->name }}</td></tr>
</table>

<h2>RINGKASAN PENJUALAN</h2>
<table class="cards">
    <tr>
        <td><div class="card hi"><div class="l">Total Penghasilan</div><div class="v">{{ $rp($revenue) }}</div></div></td>
        <td><div class="card"><div class="l">Pesanan Selesai</div><div class="v">{{ $doneCount }}</div></div></td>
        <td><div class="card"><div class="l">Rata-rata / Pesanan</div><div class="v">{{ $rp($avg) }}</div></div></td>
        <td><div class="card"><div class="l">Dibatalkan</div><div class="v">{{ $cancelledCount }}</div></div></td>
    </tr>
</table>

<h2>GRAFIK PENGHASILAN ({{ $byMonth ? 'PER BULAN' : 'PER HARI' }})</h2>
<div class="chart">
    <table>
        <tr>
            @foreach ($periods as $p)
                @php $h = $p['revenue'] > 0 ? max(4, round(($p['revenue'] / $maxRevenue) * $barH)) : 2; @endphp
                <td style="height: {{ $barH + 12 }}px;">
                    @if ($p['revenue'] > 0)<div class="val">{{ $p['revenue'] >= 1000000 ? round($p['revenue'] / 1000000, 1) . 'jt' : round($p['revenue'] / 1000) . 'rb' }}</div>@endif
                    <div class="bar {{ $p['revenue'] > 0 ? '' : 'zero' }}" style="height: {{ $h }}px;"></div>
                </td>
            @endforeach
        </tr>
        <tr class="axis">
            @foreach ($periods as $p)
                <td class="lbl">{{ $byMonth ? $p['label'] : preg_replace('/\s.*/', '', $p['label']) }}</td>
            @endforeach
        </tr>
    </table>
    <div class="muted" style="font-size:8px; margin-top:4px;">Nilai di atas batang dalam ribuan (rb) / jutaan (jt) rupiah.</div>
</div>

<h2>RINCIAN PENJUALAN</h2>
<table class="tbl">
    <thead>
        <tr><th style="width:28px;">No</th><th style="width:70px;">Tanggal</th><th>Customer</th><th>Layanan</th><th class="r" style="width:90px;">Total</th></tr>
    </thead>
    <tbody>
        @forelse ($sales as $order)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $order->updated_at->format('d/m/Y') }}</td>
                <td>{{ $order->user->name ?? '-' }}</td>
                <td>{{ $order->servicePrice?->name ?? '-' }}</td>
                <td class="r">{{ $rp($order->total_price) }}</td>
            </tr>
        @empty
            <tr><td colspan="5" class="muted c" style="padding:14px;">Belum ada penjualan pada periode ini.</td></tr>
        @endforelse
    </tbody>
    @if ($sales->count())
        <tfoot><tr><td colspan="4" class="r">TOTAL PENGHASILAN</td><td class="r">{{ $rp($totalSales) }}</td></tr></tfoot>
    @endif
</table>

<h2>LAYANAN TERLARIS</h2>
<table class="tbl">
    <thead><tr><th>Layanan</th><th class="r" style="width:50px;">Terjual</th><th style="width:30%;"></th><th class="r" style="width:90px;">Penghasilan</th></tr></thead>
    <tbody>
        @forelse ($topServices as $s)
            <tr>
                <td>{{ $s['name'] }}</td>
                <td class="r">{{ $s['count'] }}</td>
                <td><div class="mini-bg"><div class="mini" style="width: {{ ($s['revenue'] / $maxService) * 100 }}%;"></div></div></td>
                <td class="r">{{ $rp($s['revenue']) }}</td>
            </tr>
        @empty
            <tr><td colspan="4" class="muted c" style="padding:12px;">Belum ada data.</td></tr>
        @endforelse
    </tbody>
</table>

<h2>STATUS PESANAN</h2>
<table class="stat">
    <tr>
        @foreach ($statusLabels as $key => $label)
            <td><b>{{ $statusCounts[$key] ?? 0 }}</b><span class="muted">{{ $label }}</span></td>
        @endforeach
    </tr>
</table>

<table class="sign">
    <tr>
        <td></td>
        <td>
            <div class="box">
                Mengetahui,<br>Admin DeArtify
                <div class="gap"></div>
                <b>{{ auth()->user()->name }}</b>
            </div>
        </td>
    </tr>
</table>

<div class="note">Penghasilan dihitung dari pesanan berstatus <b>Selesai</b> pada periode yang dipilih. Pesanan yang dibatalkan tidak dihitung sebagai penghasilan.</div>

@if ($printMode)
    <script>window.addEventListener('load', function () { window.print(); });</script>
@endif
</body>
</html>