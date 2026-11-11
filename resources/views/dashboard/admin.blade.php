@extends('layouts.dashboard')

@push('styles')
<style>
    .db-wrap { max-width: 1320px; margin: 0 auto; }
    .db-head { display: flex; justify-content: space-between; align-items: flex-end; gap: 1rem; flex-wrap: wrap; margin-bottom: 1.3rem; }
    .db-head h3 { margin: 0 0 .2rem; font-weight: 800; color: #4A3B32; display: flex; align-items: center; gap: .6rem; }
    .db-head h3 i { color: #8B6F5B; }
    .db-head p { margin: 0; color: #85766B; }
    .db-month { display: flex; align-items: center; gap: .6rem; background: #fff; border: 1px solid #EFE3D3; border-radius: 14px; padding: .45rem .5rem .45rem 1rem; box-shadow: 0 2px 10px rgba(74, 59, 50, .06); }
    .db-month label { margin: 0; color: #85766B; font-weight: 700; font-size: .85rem; }
    .db-month input { border: 0; background: #F5EAD8; border-radius: 10px; padding: .45rem .8rem; font-weight: 800; color: #5E4334; }
    .db-month input:focus { outline: 2px solid #8B6F5B; }

    .db-hero { display: grid; grid-template-columns: 1.4fr 1fr; gap: 1rem; margin-bottom: 1rem; }
    .db-big { border-radius: 24px; padding: 1.5rem 1.7rem; position: relative; overflow: hidden; }
    .db-big.rev { background: linear-gradient(135deg, #8B6F5B, #5E4334); color: #fff; box-shadow: 0 14px 30px rgba(94, 67, 52, .3); }
    .db-big.ord { background: #fff; border: 1px solid #EFE3D3; box-shadow: 0 2px 14px rgba(74, 59, 50, .07); }
    .db-big::after { content: ''; position: absolute; right: -40px; top: -40px; width: 150px; height: 150px; border-radius: 50%; background: rgba(255, 243, 224, .1); }
    .db-big.ord::after { background: #F5EAD8; opacity: .6; }
    .db-big .lbl { display: flex; align-items: center; gap: .6rem; font-weight: 700; font-size: .92rem; opacity: .95; position: relative; z-index: 1; }
    .db-big .ic { width: 40px; height: 40px; border-radius: 13px; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; }
    .rev .ic { background: rgba(255, 243, 224, .2); color: #FFD9A0; }
    .ord .ic { background: #F5EAD8; color: #8B6F5B; }
    .db-big .num { font-size: 2.3rem; font-weight: 800; line-height: 1.15; margin: .7rem 0 .4rem; position: relative; z-index: 1; }
    .ord .num { color: #4A3B32; }
    .db-trend { display: inline-flex; align-items: center; gap: .35rem; font-size: .85rem; font-weight: 800; padding: .22rem .75rem; border-radius: 999px; position: relative; z-index: 1; }
    .db-trend.up { background: #E3F4E6; color: #2F7A3D; }
    .db-trend.down { background: #FBEAEA; color: #B3402F; }
    .rev .db-trend.up { background: rgba(120, 220, 140, .22); color: #C6F3D0; }
    .rev .db-trend.down { background: rgba(255, 140, 130, .25); color: #FFD3CD; }

    .db-mini { display: grid; grid-template-columns: repeat(4, 1fr); gap: .8rem; margin-bottom: 1rem; }
    .db-m { background: #fff; border: 1px solid #EFE3D3; border-radius: 18px; padding: .9rem 1rem; display: flex; align-items: center; gap: .8rem; text-decoration: none; color: inherit; box-shadow: 0 2px 10px rgba(74, 59, 50, .05); transition: transform .2s, box-shadow .2s; }
    .db-m:hover { transform: translateY(-3px); box-shadow: 0 12px 24px rgba(74, 59, 50, .13); color: inherit; }
    .db-m .ic { width: 42px; height: 42px; border-radius: 13px; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; flex-shrink: 0; }
    .db-m strong { display: block; font-size: 1.35rem; line-height: 1.1; color: #4A3B32; }
    .db-m small { color: #85766B; font-weight: 700; }
    .m-pending .ic { background: #FFF1D6; color: #9A6A0B; } .m-progress .ic { background: #E4EEFB; color: #2F5FA3; }
    .m-shipped .ic { background: #EDE4FA; color: #5B3FA3; } .m-done .ic { background: #E3F4E6; color: #2F7A3D; }

    .db-grid { display: grid; grid-template-columns: 1.6fr 1fr; gap: 1rem; margin-bottom: 1rem; }
    .db-card { background: #fff; border: 1px solid #EFE3D3; border-radius: 22px; box-shadow: 0 2px 14px rgba(74, 59, 50, .07); padding: 1.2rem 1.4rem; }
    .db-title { display: flex; align-items: center; justify-content: space-between; gap: .6rem; font-weight: 800; color: #4A3B32; margin-bottom: 1rem; }
    .db-title span.t { display: flex; align-items: center; gap: .55rem; }
    .db-title i { color: #8B6F5B; }
    .db-chart { position: relative; height: 290px; }
    .db-empty-chart { position: absolute; inset: 0; display: none; flex-direction: column; align-items: center; justify-content: center; color: #9A8B80; text-align: center; pointer-events: none; }
    .db-empty-chart i { font-size: 2.4rem; color: #C9AF9A; }
    .db-donut { position: relative; height: 200px; }
    .db-legend { margin-top: 1rem; display: flex; flex-direction: column; gap: .5rem; }
    .db-legend div { display: flex; align-items: center; gap: .6rem; font-size: .9rem; color: #5C4E44; font-weight: 600; }
    .db-legend i.dot { width: 12px; height: 12px; border-radius: 4px; flex-shrink: 0; }
    .db-legend b { margin-left: auto; color: #4A3B32; }

    .db-all { display: inline-flex; align-items: center; gap: .4rem; background: #8B6F5B; color: #fff; font-weight: 800; font-size: .85rem; padding: .5rem 1rem; border-radius: 11px; text-decoration: none; transition: background .2s; }
    .db-all:hover { background: #5E4334; color: #fff; }
    .db-table { width: 100%; border-collapse: collapse; }
    .db-table th { background: #FBF3E8; color: #85766B; font-size: .75rem; font-weight: 800; letter-spacing: .07em; text-transform: uppercase; padding: .8rem 1rem; text-align: left; white-space: nowrap; }
    .db-table th:first-child { border-radius: 12px 0 0 12px; } .db-table th:last-child { border-radius: 0 12px 12px 0; }
    .db-table td { padding: .8rem 1rem; border-bottom: 1px solid #F3E9DA; vertical-align: middle; }
    .db-table tbody tr:last-child td { border-bottom: 0; }
    .db-table tbody tr:hover { background: #FDF6EA; }
    .db-user { display: flex; align-items: center; gap: .65rem; font-weight: 700; color: #4A3B32; }
    .db-ava { width: 34px; height: 34px; border-radius: 50%; background: linear-gradient(135deg, #A78468, #5E4334); color: #fff; font-weight: 800; font-size: .85rem; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .db-st { display: inline-flex; align-items: center; gap: .35rem; padding: .28rem .8rem; border-radius: 999px; font-size: .78rem; font-weight: 800; white-space: nowrap; }
    .st-pending { background: #FFF1D6; color: #9A6A0B; } .st-in_progress { background: #E4EEFB; color: #2F5FA3; }
    .st-shipped { background: #EDE4FA; color: #5B3FA3; } .st-completed { background: #E3F4E6; color: #2F7A3D; } .st-cancelled { background: #FBEAEA; color: #B3402F; }
    .db-det { display: inline-flex; align-items: center; gap: .35rem; padding: .42rem .9rem; border-radius: 10px; background: #F5EAD8; color: #5E4334; font-weight: 800; font-size: .84rem; text-decoration: none; transition: background .2s, color .2s; white-space: nowrap; }
    .db-det:hover { background: #8B6F5B; color: #fff; }
    .db-none { text-align: center; padding: 2rem; color: #85766B; }

    @media (max-width: 991.98px) { .db-hero, .db-grid { grid-template-columns: 1fr; } .db-mini { grid-template-columns: repeat(2, 1fr); } }
</style>
@endpush

@section('content')
@php
    $bulanIndo = [1=>'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
    $monthParts = explode('-', $month);
    $monthLabel = $bulanIndo[(int) $monthParts[1]] . ' ' . $monthParts[0];
    $labels = ['pending' => ['Menunggu', 'bi-hourglass-split'], 'in_progress' => ['Diproses', 'bi-brush'], 'shipped' => ['Dikirim', 'bi-truck'], 'completed' => ['Selesai', 'bi-check-circle'], 'cancelled' => ['Dibatalkan', 'bi-x-circle']];
    $sc = fn ($k) => (int) ($statusCounts[$k] ?? 0);
    $cancelledCount = $sc('cancelled');
    $hasRevenue = collect($revenueData)->sum() > 0;
@endphp

<div class="db-wrap">
    <div class="db-head">
        <div>
            <h3><i class="bi bi-speedometer2"></i>Dashboard</h3>
            <p>Ringkasan penjualan dan aktivitas aplikasi.</p>
        </div>
        <form method="GET" action="{{ route('home') }}" class="db-month">
            <label for="month">Bulan</label>
            <input type="month" id="month" name="month" value="{{ $month }}" max="{{ now()->format('Y-m') }}" onchange="this.form.submit()">
        </form>
    </div>

    {{-- Angka utama --}}
    <div class="db-hero">
        <div class="db-big rev">
            <div class="lbl"><span class="ic"><i class="bi bi-wallet2"></i></span>Total Pendapatan &middot; {{ $monthLabel }}</div>
            <div class="num">Rp{{ number_format($totalRevenue, 0, ',', '.') }}</div>
            <span class="db-trend {{ $revenueChange >= 0 ? 'up' : 'down' }}"><i class="bi {{ $revenueChange >= 0 ? 'bi-arrow-up-right' : 'bi-arrow-down-right' }}"></i>{{ abs($revenueChange) }}% dari bulan lalu</span>
        </div>
        <div class="db-big ord">
            <div class="lbl"><span class="ic"><i class="bi bi-receipt"></i></span>Total Pesanan Masuk</div>
            <div class="num">{{ $totalTransactions }}</div>
            <span class="db-trend {{ $transactionChange >= 0 ? 'up' : 'down' }}"><i class="bi {{ $transactionChange >= 0 ? 'bi-arrow-up-right' : 'bi-arrow-down-right' }}"></i>{{ abs($transactionChange) }}% dari bulan lalu</span>
        </div>
    </div>

    {{-- Status singkat (klik untuk filter pesanan) --}}
    <div class="db-mini">
        <a href="{{ route('orders.index', ['status' => 'pending']) }}" class="db-m m-pending"><span class="ic"><i class="bi bi-hourglass-split"></i></span><div><strong>{{ $sc('pending') }}</strong><small>Menunggu</small></div></a>
        <a href="{{ route('orders.index', ['status' => 'in_progress']) }}" class="db-m m-progress"><span class="ic"><i class="bi bi-brush"></i></span><div><strong>{{ $sc('in_progress') }}</strong><small>Diproses</small></div></a>
        <a href="{{ route('orders.index', ['status' => 'shipped']) }}" class="db-m m-shipped"><span class="ic"><i class="bi bi-truck"></i></span><div><strong>{{ $sc('shipped') }}</strong><small>Dikirim</small></div></a>
        <a href="{{ route('orders.index', ['status' => 'completed']) }}" class="db-m m-done"><span class="ic"><i class="bi bi-check-circle"></i></span><div><strong>{{ $sc('completed') }}</strong><small>Selesai</small></div></a>
    </div>

    {{-- Grafik --}}
    <div class="db-grid">
        <div class="db-card">
            <div class="db-title"><span class="t"><i class="bi bi-graph-up-arrow"></i>Grafik Pendapatan</span><small class="text-muted fw-semibold">{{ $monthLabel }}</small></div>
            <div class="db-chart">
                <canvas id="revenueChart"></canvas>
                <div class="db-empty-chart" id="revEmpty"><i class="bi bi-bar-chart"></i>Belum ada pendapatan di bulan ini</div>
            </div>
        </div>
        <div class="db-card">
            <div class="db-title"><span class="t"><i class="bi bi-pie-chart-fill"></i>Status Pesanan</span></div>
            <div class="db-donut"><canvas id="statusChart"></canvas></div>
            <div class="db-legend">
                <div><i class="dot" style="background:#E8D9BF"></i>Menunggu<b>{{ $sc('pending') }}</b></div>
                <div><i class="dot" style="background:#C9AF9A"></i>Diproses<b>{{ $sc('in_progress') }}</b></div>
                <div><i class="dot" style="background:#8B6F5B"></i>Dikirim<b>{{ $sc('shipped') }}</b></div>
                <div><i class="dot" style="background:#5E4334"></i>Selesai<b>{{ $sc('completed') }}</b></div>
                @if ($cancelledCount)<div><i class="dot" style="background:#D98A80"></i>Dibatalkan<b>{{ $cancelledCount }}</b></div>@endif
            </div>
        </div>
    </div>

    {{-- Pesanan terbaru --}}
    <div class="db-card">
        <div class="db-title"><span class="t"><i class="bi bi-clock-history"></i>Pesanan Terbaru</span><a href="{{ route('orders.index') }}" class="db-all">Lihat Semua <i class="bi bi-arrow-right"></i></a></div>
        <div class="table-responsive">
            <table class="db-table">
                <thead><tr><th>No</th><th>Customer</th><th>Jasa</th><th>Tanggal</th><th>Status</th><th>Total</th><th style="text-align:right;">Aksi</th></tr></thead>
                <tbody>
                    @forelse ($recentOrders as $order)
                        @php [$lbl, $ico] = $labels[$order->status] ?? [$order->status, 'bi-circle']; @endphp
                        <tr>
                            <td style="color:#9A8B80;font-weight:700;">{{ $loop->iteration }}</td>
                            <td><div class="db-user"><span class="db-ava">{{ strtoupper(mb_substr($order->user->name, 0, 1)) }}</span>{{ $order->user->name }}</div></td>
                            <td>{{ $order->servicePrice->name ?? '-' }}</td>
                            <td style="white-space:nowrap;">{{ $order->created_at->format('d M Y') }}</td>
                            <td><span class="db-st st-{{ $order->status }}"><i class="bi {{ $ico }}"></i>{{ $lbl }}</span></td>
                            <td style="font-weight:800;color:#5E4334;white-space:nowrap;">Rp{{ number_format($order->total_price, 0, ',', '.') }}</td>
                            <td style="text-align:right;"><a href="{{ route('orders.show', $order) }}" class="db-det"><i class="bi bi-eye"></i>Detail</a></td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="db-none">Belum ada pesanan terbaru.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    (function () {
        var rp = function (v) { return v >= 1000000 ? 'Rp' + (v / 1000000).toFixed(v % 1000000 ? 1 : 0) + ' jt' : v >= 1000 ? 'Rp' + Math.round(v / 1000) + ' rb' : 'Rp' + v; };
        var data = @json($revenueData);
        var has = data.some(function (v) { return v > 0; });
        if (!has) { document.getElementById('revEmpty').style.display = 'flex'; }

        var ctx = document.getElementById('revenueChart').getContext('2d');
        var grad = ctx.createLinearGradient(0, 0, 0, 290);
        grad.addColorStop(0, 'rgba(139, 111, 91, .38)');
        grad.addColorStop(1, 'rgba(139, 111, 91, .02)');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($revenueLabels),
                datasets: [{ label: 'Pendapatan', data: data, borderColor: '#8B6F5B', backgroundColor: grad, borderWidth: 3, tension: .35, fill: true, pointRadius: 0, pointHoverRadius: 6, pointHoverBackgroundColor: '#5E4334' }]
            },
            options: {
                maintainAspectRatio: false,
                interaction: { mode: 'index', intersect: false },
                plugins: { legend: { display: false }, tooltip: { callbacks: { label: function (c) { return 'Rp' + c.parsed.y.toLocaleString('id-ID'); } } } },
                scales: {
                    y: { beginAtZero: true, suggestedMax: has ? undefined : 100000, grid: { color: '#F1E6D6' }, border: { display: false }, ticks: { callback: rp, color: '#85766B' } },
                    x: { grid: { display: false }, ticks: { color: '#85766B', maxTicksLimit: 15 } }
                }
            }
        });

        new Chart(document.getElementById('statusChart'), {
            type: 'doughnut',
            data: {
                labels: ['Menunggu', 'Diproses', 'Dikirim', 'Selesai', 'Dibatalkan'],
                datasets: [{
                    data: [{{ $sc('pending') }}, {{ $sc('in_progress') }}, {{ $sc('shipped') }}, {{ $sc('completed') }}, {{ $cancelledCount }}],
                    backgroundColor: ['#E8D9BF', '#C9AF9A', '#8B6F5B', '#5E4334', '#D98A80'],
                    borderWidth: 3, borderColor: '#fff', hoverOffset: 6
                }]
            },
            options: { maintainAspectRatio: false, cutout: '66%', plugins: { legend: { display: false } } }
        });
    })();
</script>
@endsection