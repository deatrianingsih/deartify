@extends('layouts.dashboard')

@section('content')
<div class="mb-4">
    <h4 class="fw-semibold mb-1"><i class="bi bi-clipboard-check me-2" style="color: #8B6F5B;"></i>Pesanan Saya</h4>
    <p class="text-muted small mb-0">Lihat dan pantau semua pesanan ilustrasi kamu di sini</p>
</div>

@if (!auth()->user()->isAdmin())
    <a href="{{ route('orders.create') }}" class="btn text-white mb-3" style="background-color: #8B6F5B;">
        + Buat Pesanan Baru
    </a>
@endif

<div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
    <ul class="nav" style="gap: 8px;">
        @php
            $tabs = [
                '' => ['label' => 'Semua', 'icon' => 'bi-grid'],
                'pending' => ['label' => 'Menunggu', 'icon' => 'bi-clock'],
                'in_progress' => ['label' => 'Diproses', 'icon' => 'bi-hourglass-split'],
                'shipped' => ['label' => 'Dikirim', 'icon' => 'bi-truck'],
                'completed' => ['label' => 'Selesai', 'icon' => 'bi-check-circle'],
            ];
        @endphp
        @foreach ($tabs as $value => $tab)
            <li>
                <a href="{{ route('orders.index', array_filter(['status' => $value, 'search' => $search ?? null])) }}"
                   class="btn btn-sm {{ ($status ?? '') === $value ? 'text-white' : 'btn-outline-secondary' }}"
                   style="{{ ($status ?? '') === $value ? 'background-color: #8B6F5B;' : '' }} border-radius: 20px;">
                    <i class="bi {{ $tab['icon'] }} me-1"></i>{{ $tab['label'] }}
                </a>
            </li>
        @endforeach
    </ul>

    <form method="GET" class="d-flex" style="max-width: 260px;">
        <input type="hidden" name="status" value="{{ $status ?? '' }}">
        <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari pesanan..." class="form-control form-control-sm">
    </form>
</div>

<div class="card border-0 shadow-sm" style="border-radius: 16px;">
    <div class="card-body p-0">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th class="py-2 px-3" style="background-color: #EDDECA; border-radius: 8px 0 0 8px;">No</th>
                    <th class="py-2 px-3" style="background-color: #EDDECA;">Gambar</th>
                    <th class="py-2 px-3" style="background-color: #EDDECA;">Detail Pesanan</th>
                    @if (auth()->user()->isAdmin())
                        <th class="py-2 px-3" style="background-color: #EDDECA;">Customer</th>
                    @endif
                    <th class="py-2 px-3" style="background-color: #EDDECA;">Status</th>
                    <th class="py-2 px-3" style="background-color: #EDDECA;">Total</th>
                    <th class="py-2 px-3" style="background-color: #EDDECA; border-radius: 0 8px 8px 0;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $statusIcons = ['pending' => 'bi-clock', 'in_progress' => 'bi-hourglass-split', 'shipped' => 'bi-truck', 'completed' => 'bi-check-circle-fill'];
                @endphp
                @forelse ($orders as $order)
                    <tr>
                        <td class="px-3 py-3">{{ $loop->iteration + ($orders->currentPage() - 1) * $orders->perPage() }}</td>
                        <td class="px-3 py-3">
                            @if ($order->servicePrice->image)
                                <img src="{{ Storage::url($order->servicePrice->image) }}" width="48" height="48" class="rounded" style="object-fit: cover;">
                            @else
                                <div class="rounded" style="width: 48px; height: 48px; background-color: #F5EAD8;"></div>
                            @endif
                        </td>
                        <td class="px-3 py-3">
                            <div class="fw-semibold">{{ $order->servicePrice->name }}</div>
                            <div class="small text-muted mb-1">{{ Str::limit($order->description, 40) }}</div>
                            <a href="{{ route('orders.show', $order) }}" class="small text-decoration-none" style="color: #6B4F3F;">Lihat Detail <i class="bi bi-arrow-right"></i></a>
                        </td>
                        @if (auth()->user()->isAdmin())
                            <td class="px-3 py-3">{{ $order->user->name }}</td>
                        @endif
                        <td class="px-3 py-3">
                            <span class="badge" style="background-color: #C9AF9A; color: #4A3B32;">
                                <i class="bi {{ $statusIcons[$order->status] ?? 'bi-circle' }} me-1"></i>{{ $order->status }}
                            </span>
                        </td>
                        <td class="px-3 py-3">Rp{{ number_format($order->total_price, 0, ',', '.') }}</td>
                        <td class="px-3 py-3">
                            <a href="{{ route('orders.show', $order) }}" class="btn btn-sm text-white me-1" style="background-color: #8B6F5B;">
                                <i class="bi bi-eye"></i> Lihat Detail
                            </a>
                            @if (auth()->user()->isAdmin())
                                <a href="{{ route('orders.edit', $order) }}" class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-three-dots"></i>
                                </a>
                            @endif
                            @if (!auth()->user()->isAdmin() && $order->status === 'completed')
                                <a href="{{ route('reviews.create', $order) }}" class="btn btn-sm btn-outline-secondary" title="Beri Ulasan">
                                    <i class="bi bi-star"></i>
                                </a>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">Belum ada pesanan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="d-flex justify-content-between align-items-center mt-3">
    <span class="small text-muted">Menampilkan {{ $orders->count() }} dari {{ $orders->total() }} pesanan</span>
    {{ $orders->links() }}
</div>
@endsection