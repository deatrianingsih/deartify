@extends('layouts.dashboard')

@section('content')
<div class="d-flex justify-content-between align-items-start mb-4 flex-wrap gap-2">
    <div>
        <h4 class="fw-semibold mb-1"><i class="bi bi-bar-chart-fill me-2" style="color: #8B6F5B;"></i>Laporan & Grafik</h4>
        <p class="text-muted small mb-0">Ringkasan data penjualan dan aktivitas aplikasi</p>
    </div>
    <form method="GET" class="d-flex gap-2">
        <input type="month" name="month" value="{{ $month }}" class="form-control form-control-sm" onchange="this.form.submit()">
        <button type="submit" class="btn btn-sm text-white d-flex align-items-center gap-1" style="background-color: #8B6F5B;">
            <i class="bi bi-funnel"></i> Filter
        </button>
    </form>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm p-3" style="border-radius: 16px;">
            <div class="d-flex align-items-center gap-2 mb-2">
                <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; background-color: #EDDECA; color: #8B6F5B;">
                    <i class="bi bi-wallet2"></i>
                </div>
                <span class="text-muted small">Total Pendapatan</span>
            </div>
            <div class="fs-4 fw-semibold">Rp{{ number_format($totalRevenue, 0, ',', '.') }}</div>
            <div class="small {{ $revenueChange >= 0 ? 'text-success' : 'text-danger' }}">
                <i class="bi {{ $revenueChange >= 0 ? 'bi-arrow-up' : 'bi-arrow-down' }}"></i> {{ abs($revenueChange) }}% dari bulan lalu
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card border-0 shadow-sm p-3" style="border-radius: 16px;">
            <div class="d-flex align-items-center gap-2 mb-2">
                <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; background-color: #EDDECA; color: #8B6F5B;">
                    <i class="bi bi-receipt"></i>
                </div>
                <span class="text-muted small">Total Transaksi</span>
            </div>
            <div class="fs-4 fw-semibold">{{ $totalTransactions }}</div>
            <div class="small {{ $transactionChange >= 0 ? 'text-success' : 'text-danger' }}">
                <i class="bi {{ $transactionChange >= 0 ? 'bi-arrow-up' : 'bi-arrow-down' }}"></i> {{ abs($transactionChange) }}% dari bulan lalu
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-7">
        <div class="card border-0 shadow-sm p-3" style="border-radius: 16px;">
            <h6 class="mb-3"><i class="bi bi-graph-up me-2" style="color: #8B6F5B;"></i>Grafik Pendapatan (Rp/Bulan)</h6>
            <canvas id="revenueChart" height="240"></canvas>
        </div>
    </div>
    <div class="col-md-5">
    <div class="card border-0 shadow-sm p-3" style="border-radius: 16px;">
        <h6 class="mb-3"><i class="bi bi-pie-chart-fill me-2" style="color: #8B6F5B;"></i>Status Pesanan</h6>
        <div style="height: 250px; display: flex; align-items: center; justify-content: center;">
            <canvas id="statusChart" style="max-height: 200px;"></canvas>
        </div>
    </div>
</div>
</div>

<div class="card border-0 shadow-sm" style="border-radius: 16px;">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="mb-0"><i class="bi bi-clipboard-data me-2" style="color: #8B6F5B;"></i>Pesanan Terbaru</h6>
            <a href="{{ route('orders.index') }}" class="btn btn-sm text-white" style="background-color: #8B6F5B;">Lihat Semua <i class="bi bi-arrow-right"></i></a>
        </div>
        <table class="table mb-0">
            <thead>
                <tr>
                    <th class="py-2 px-2" style="background-color: #EDDECA; border-radius: 8px 0 0 8px;">No</th>
                    <th class="py-2 px-2" style="background-color: #EDDECA;">Customer</th>
                    <th class="py-2 px-2" style="background-color: #EDDECA;">Jasa</th>
                    <th class="py-2 px-2" style="background-color: #EDDECA;">Tanggal</th>
                    <th class="py-2 px-2" style="background-color: #EDDECA;">Status</th>
                    <th class="py-2 px-2" style="background-color: #EDDECA;">Total</th>
                    <th class="py-2 px-2" style="background-color: #EDDECA; border-radius: 0 8px 8px 0;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($recentOrders as $order)
                    <tr>
                        <td class="py-3">{{ $loop->iteration }}</td>
                        <td class="py-3">
                            <div class="d-flex align-items-center gap-2">
                                <div class="rounded-circle d-flex align-items-center justify-content-center text-white" style="width: 28px; height: 28px; background-color: #8B6F5B; font-size: 0.75rem;">
                                    {{ strtoupper(substr($order->user->name, 0, 1)) }}
                                </div>
                                {{ $order->user->name }}
                            </div>
                        </td>
                        <td class="py-3">{{ $order->servicePrice->name }}</td>
                        <td class="py-3">{{ $order->created_at->format('d M Y') }}</td>
                        <td class="py-3"><span class="badge" style="background-color: #C9AF9A; color: #4A3B32;">{{ $order->status }}</span></td>
                        <td class="py-3">Rp{{ number_format($order->total_price, 0, ',', '.') }}</td>
                        <td class="py-3">
                            <a href="{{ route('orders.show', $order) }}" class="btn btn-sm text-white" style="background-color: #8B6F5B;">
                                <i class="bi bi-eye"></i> Lihat Detail
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center text-muted py-3">Belum ada pesanan terbaru.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
    new Chart(document.getElementById('revenueChart'), {
        type: 'line',
        data: {
            labels: @json($revenueLabels),
            datasets: [{
                label: 'Pendapatan',
                data: @json($revenueData),
                borderColor: '#8B6F5B',
                backgroundColor: 'rgba(139, 111, 91, 0.15)',
                tension: 0.3,
                fill: true,
                pointRadius: 0,
            }]
        },
        options: { plugins: { legend: { display: false } } }
    });

    new Chart(document.getElementById('statusChart'), {
        type: 'doughnut',
        data: {
            labels: ['Menunggu', 'Diproses', 'Dikirim', 'Selesai'],
            datasets: [{
                data: [
                    {{ $statusCounts['pending'] }},
                    {{ $statusCounts['in_progress'] }},
                    {{ $statusCounts['shipped'] }},
                    {{ $statusCounts['completed'] }}
                ],
                backgroundColor: ['#EDDECA', '#C9AF9A', '#8B6F5B', '#6B4F3F'],
            }]
        },
        options: { plugins: { legend: { position: 'right' } } }
    });
</script>
@endsection