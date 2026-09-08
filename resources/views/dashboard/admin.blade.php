@extends('layouts.dashboard')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-semibold mb-0">Laporan & Grafik</h4>
    <form method="GET" class="d-flex gap-2">
        <input type="month" name="month" value="{{ $month }}" class="form-control form-control-sm" onchange="this.form.submit()">
        <button type="submit" class="btn btn-sm text-white" style="background-color: #8B6F5B;">Filter</button>
    </form>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm p-3" style="border-radius: 16px;">
            <div class="fs-4 fw-semibold">Rp{{ number_format($totalRevenue, 0, ',', '.') }}</div>
            <div class="text-muted small">Total Pendapatan</div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card border-0 shadow-sm p-3" style="border-radius: 16px;">
            <div class="fs-4 fw-semibold">{{ $totalTransactions }}</div>
            <div class="text-muted small">Total Transaksi</div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-7">
        <div class="card border-0 shadow-sm p-3" style="border-radius: 16px;">
            <h6 class="mb-3">Grafik Pendapatan (Rp/Bulan)</h6>
            <canvas id="revenueChart" height="150"></canvas>
        </div>
    </div>
    <div class="col-md-5">
        <div class="card border-0 shadow-sm p-3" style="border-radius: 16px;">
            <h6 class="mb-3">Status Pesanan</h6>
            <canvas id="statusChart" height="180"></canvas>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm" style="border-radius: 16px;">
    <div class="card-body">
        <h6 class="mb-3">Pesanan Terbaru</h6>
        <table class="table mb-0">
            <thead>
                <tr class="text-muted">
                    <th>Customer</th>
                    <th>Layanan</th>
                    <th>Status</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($recentOrders as $order)
                    <tr>
                        <td>{{ $order->user->name }}</td>
                        <td>{{ $order->servicePrice->name }}</td>
                        <td><span class="badge" style="background-color: #C9AF9A; color: #4A3B32;">{{ $order->status }}</span></td>
                        <td>Rp{{ number_format($order->total_price, 0, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center text-muted py-3">Belum ada pesanan terbaru.</td></tr>
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
                backgroundColor: 'rgba(139, 111, 91, 0.1)',
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
                backgroundColor: ['#C9AF9A', '#8B6F5B', '#6B4F3F', '#4A3B32'],
            }]
        },
        options: {
            plugins: {
                legend: { position: 'right' }
            }
        }
    });
</script>
@endsection