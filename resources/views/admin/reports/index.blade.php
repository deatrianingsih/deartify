@extends('layouts.dashboard')

@section('content')
@php
    $rp = fn ($v) => 'Rp' . number_format($v, 0, ',', '.');
    $statusLabels = ['pending' => 'Menunggu', 'in_progress' => 'Diproses', 'shipped' => 'Dikirim', 'completed' => 'Selesai', 'cancelled' => 'Dibatalkan'];
    $statusColors = ['pending' => '#EDDECA', 'in_progress' => '#FCE9C4', 'shipped' => '#DCEBFA', 'completed' => '#DDF1E3', 'cancelled' => '#F8D7DA'];
    $query = ['from' => $from->toDateString(), 'to' => $to->toDateString()];
    $maxService = max(1, (float) ($topServices->max('revenue') ?? 0));
@endphp

<div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-4">
    <div>
        <h4 class="fw-semibold mb-1"><i class="bi bi-bar-chart-line me-2" style="color: #8B6F5B;"></i>Laporan Penjualan</h4>
        <p class="text-muted small mb-0">Periode {{ $from->copy()->locale('id')->translatedFormat('j F Y') }} – {{ $to->copy()->locale('id')->translatedFormat('j F Y') }}</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.reports.pdf', $query) }}" class="btn text-white" style="background-color: #8B6F5B;"><i class="bi bi-file-earmark-pdf"></i> Download PDF</a>
    </div>
</div>

{{-- Filter --}}
<form method="GET" class="card border-0 shadow-sm p-3 mb-4" style="border-radius: 16px;">
    <div class="row g-2 align-items-end">
        <div class="col-6 col-md-3">
            <label class="form-label small fw-semibold mb-1">Dari tanggal</label>
            <input type="date" name="from" value="{{ $from->toDateString() }}" class="form-control">
        </div>
        <div class="col-6 col-md-3">
            <label class="form-label small fw-semibold mb-1">Sampai tanggal</label>
            <input type="date" name="to" value="{{ $to->toDateString() }}" class="form-control">
        </div>
        <div class="col-12 col-md-6 d-flex gap-2 flex-wrap">
            <button class="btn text-white" style="background-color: #8B6F5B;"><i class="bi bi-funnel"></i> Terapkan</button>
            <a class="btn btn-outline-secondary" href="{{ route('admin.reports.index', ['from' => now()->startOfMonth()->toDateString(), 'to' => now()->toDateString()]) }}">Bulan ini</a>
            <a class="btn btn-outline-secondary" href="{{ route('admin.reports.index', ['from' => now()->subDays(29)->toDateString(), 'to' => now()->toDateString()]) }}">30 hari</a>
            <a class="btn btn-outline-secondary" href="{{ route('admin.reports.index', ['from' => now()->startOfYear()->toDateString(), 'to' => now()->toDateString()]) }}">Tahun ini</a>
        </div>
    </div>
    @error('to') <div class="text-danger small mt-2">{{ $message }}</div> @enderror
</form>

{{-- Ringkasan --}}
<div class="row g-3 mb-4">
    @foreach ([
        ['Total Pendapatan', $rp($revenue), 'bi-cash-stack', 'Dari pesanan selesai'],
        ['Total Pesanan', $ordersCount, 'bi-bag', 'Tidak termasuk dibatalkan'],
        ['Pesanan Selesai', $doneCount, 'bi-check-circle', 'Rata-rata ' . $rp($average)],
        ['Dibatalkan', $cancelledCount, 'bi-x-circle', 'Pada periode ini'],
    ] as [$label, $value, $icon, $hint])
        <div class="col-6 col-lg-3">
            <div class="card border-0 shadow-sm p-3 h-100" style="border-radius: 16px;">
                <div class="d-flex align-items-center gap-2 text-muted small mb-1"><i class="bi {{ $icon }}" style="color: #8B6F5B;"></i>{{ $label }}</div>
                <div class="fs-4 fw-semibold" style="color: #4A3B32;">{{ $value }}</div>
                <div class="small text-muted">{{ $hint }}</div>
            </div>
        </div>
    @endforeach
</div>

{{-- Grafik --}}
<div class="card border-0 shadow-sm p-4 mb-4" style="border-radius: 16px;">
    <h6 class="mb-3">Grafik Penjualan <span class="text-muted fw-normal small">({{ $byMonth ? 'per bulan' : 'per hari' }})</span></h6>
    <div style="position: relative; height: 340px;">
        <canvas id="salesChart"></canvas>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm p-4 h-100" style="border-radius: 16px;">
            <h6 class="mb-3">Layanan Terlaris</h6>
            @forelse ($topServices as $service)
                <div class="mb-3">
                    <div class="d-flex justify-content-between small mb-1">
                        <span class="fw-semibold">{{ $service['name'] }} <span class="text-muted fw-normal">· {{ $service['count'] }} pesanan</span></span>
                        <span>{{ $rp($service['revenue']) }}</span>
                    </div>
                    <div class="progress" style="height: 8px; background-color: #F5EAD8;">
                        <div class="progress-bar" style="width: {{ ($service['revenue'] / $maxService) * 100 }}%; background-color: #8B6F5B;"></div>
                    </div>
                </div>
            @empty
                <p class="text-muted mb-0">Belum ada pesanan selesai pada periode ini.</p>
            @endforelse
        </div>
    </div>
    <div class="col-lg-5">
        <div class="card border-0 shadow-sm p-4 h-100" style="border-radius: 16px;">
            <h6 class="mb-3">Status Pesanan</h6>
            @foreach ($statusLabels as $key => $label)
                <div class="d-flex justify-content-between align-items-center py-2" style="border-bottom: 1px solid #EFE3D3;">
                    <span><span class="badge" style="background-color: {{ $statusColors[$key] }}; color: #4A3B32;">{{ $label }}</span></span>
                    <strong>{{ $statusCounts[$key] ?? 0 }}</strong>
                </div>
            @endforeach
        </div>
    </div>
</div>

{{-- Rekap pesanan --}}
<div class="card border-0 shadow-sm" style="border-radius: 16px;">
    <div class="card-body p-0">
        <div class="p-3 pb-2"><h6 class="mb-0">Rekap Pesanan ({{ $orders->count() }})</h6></div>
        <div class="table-responsive">
            <table class="table mb-0 align-middle">
                <thead>
                    <tr>
                        <th class="py-2 px-3" style="background-color: #EDDECA;">No</th>
                        <th class="py-2 px-3" style="background-color: #EDDECA;">Tanggal</th>
                        <th class="py-2 px-3" style="background-color: #EDDECA;">Customer</th>
                        <th class="py-2 px-3" style="background-color: #EDDECA;">Layanan</th>
                        <th class="py-2 px-3" style="background-color: #EDDECA;">Status</th>
                        <th class="py-2 px-3 text-end" style="background-color: #EDDECA;">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orders as $order)
                        <tr>
                            <td class="px-3 py-2">{{ $loop->iteration }}</td>
                            <td class="px-3 py-2">{{ $order->created_at->format('d/m/Y') }}</td>
                            <td class="px-3 py-2">{{ $order->user->name }}</td>
                            <td class="px-3 py-2">{{ $order->servicePrice?->name ?? '-' }}</td>
                            <td class="px-3 py-2"><span class="badge" style="background-color: {{ $statusColors[$order->status] ?? '#EDDECA' }}; color: #4A3B32;">{{ $statusLabels[$order->status] ?? $order->status }}</span></td>
                            <td class="px-3 py-2 text-end">{{ $rp($order->total_price) }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center text-muted py-4">Tidak ada pesanan pada periode ini.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
<script>
    (function () {
        var periods = @json($periods);
        var rupiah = function (v) { return 'Rp' + Number(v).toLocaleString('id-ID'); };

        new Chart(document.getElementById('salesChart'), {
            data: {
                labels: periods.map(function (p) { return p.label; }),
                datasets: [
                    {
                        type: 'bar',
                        label: 'Pendapatan',
                        data: periods.map(function (p) { return p.revenue; }),
                        backgroundColor: '#C9AF9A',
                        borderRadius: 6,
                        yAxisID: 'y'
                    },
                    {
                        type: 'line',
                        label: 'Jumlah Pesanan',
                        data: periods.map(function (p) { return p.orders; }),
                        borderColor: '#6B4F3F',
                        backgroundColor: '#6B4F3F',
                        tension: .3,
                        yAxisID: 'y1'
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: { mode: 'index', intersect: false },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function (ctx) {
                                return ctx.dataset.label + ': ' + (ctx.dataset.yAxisID === 'y' ? rupiah(ctx.parsed.y) : ctx.parsed.y);
                            }
                        }
                    }
                },
                scales: {
                    y: { beginAtZero: true, ticks: { callback: rupiah }, grid: { color: '#EFE3D3' } },
                    y1: { beginAtZero: true, position: 'right', grid: { drawOnChartArea: false }, ticks: { precision: 0 } }
                }
            }
        });
    })();
</script>
@endsection