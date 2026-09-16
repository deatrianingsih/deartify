@extends('layouts.dashboard')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="fw-semibold mb-0">Daftar Pesanan</h4>
    @if (!auth()->user()->isAdmin())
        <a href="{{ route('orders.create') }}" class="btn text-white" style="background-color: #8B6F5B;">
            + Buat Pesanan Baru
        </a>
    @endif
</div>

<ul class="nav mb-3" style="gap: 8px;">
    @php
        $tabs = [
            '' => 'Semua',
            'pending' => 'Menunggu',
            'in_progress' => 'Diproses',
            'shipped' => 'Dikirim',
            'completed' => 'Selesai',
        ];
    @endphp
    @foreach ($tabs as $value => $label)
        <li>
            <a href="{{ route('orders.index', $value ? ['status' => $value] : []) }}"
               class="btn btn-sm {{ ($status ?? '') === $value ? 'text-white' : 'btn-outline-secondary' }}"
               style="{{ ($status ?? '') === $value ? 'background-color: #8B6F5B;' : '' }}">
                {{ $label }}
            </a>
        </li>
    @endforeach
</ul>

<div class="card border-0 shadow-sm" style="border-radius: 16px;">
    <div class="card-body p-0">
        <table class="table mb-0">
            <thead>
                <tr>
                    @if (auth()->user()->isAdmin())
                        <th class="py-2 px-2" style="background-color: #EDDECA; border-radius: 8px 0 0 8px;">Customer</th>
                        <th class="py-2 px-2" style="background-color: #EDDECA;">Jasa</th>
                    @else
                        <th class="py-2 px-2" style="background-color: #EDDECA; border-radius: 8px 0 0 8px;">Jasa</th>
                    @endif
                    <th class="py-2 px-2" style="background-color: #EDDECA;">Status</th>
                    <th class="py-2 px-2" style="background-color: #EDDECA;">Total</th>
                    <th class="py-2 px-2" style="background-color: #EDDECA; border-radius: 0 8px 8px 0;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($orders as $order)
                    <tr>
                        @if (auth()->user()->isAdmin())
                            <td class="px-4 py-3">{{ $order->user->name }}</td>
                        @endif
                        <td class="px-4 py-3">{{ $order->servicePrice->name }}</td>
                        <td class="px-4 py-3">
                            <span class="badge" style="background-color: #C9AF9A; color: #4A3B32;">
                                {{ $order->status }}
                            </span>
                        </td>
                        <td class="px-4 py-3">Rp{{ number_format($order->total_price, 0, ',', '.') }}</td>
                        <td class="px-4 py-3">
                            <a href="{{ route('orders.show', $order) }}" class="text-decoration-none me-3" style="color: #6B4F3F;" title="Lihat Detail">
                                <i class="bi bi-eye fs-5"></i>
                            </a>
                            @if (auth()->user()->isAdmin())
                                <a href="{{ route('orders.edit', $order) }}" class="text-decoration-none me-3" style="color: #6B4F3F;" title="Ubah Status">
                                    <i class="bi bi-pencil-square fs-5"></i>
                                </a>
                            @endif
                            @if (!auth()->user()->isAdmin() && $order->status === 'completed')
                                <a href="{{ route('reviews.create', $order) }}" class="text-decoration-none" style="color: #6B4F3F;" title="Beri Ulasan">
                                    <i class="bi bi-star fs-5"></i>
                                </a>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">Belum ada pesanan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">
    {{ $orders->links() }}
</div>
@endsection