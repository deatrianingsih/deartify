@extends('layouts.dashboard')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-semibold mb-0">Daftar Pesanan</h4>
        @if (!auth()->user()->isAdmin())
            <a href="{{ route('orders.create') }}" class="btn text-white" style="background-color: #8B6F5B;">
                + Buat Pesanan Baru
            </a>
        @endif
    </div>

    <div class="card border-0 shadow-sm" style="border-radius: 16px;">
        <div class="card-body p-0">
        <table class="table mb-0">
            <thead>
                <tr class="text-muted">
                    @if (auth()->user()->isAdmin())
                        <th class="px-4 py-3">Customer</th>
                    @endif
                    <th class="px-4 py-3">Jasa</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Total</th>
                    <th class="px-4 py-3">Aksi</th>
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
                        <a href="{{ route('orders.show', $order) }}" style="color: #6B4F3F;">Detail</a>
                        @if (auth()->user()->isAdmin())
                            <a href="{{ route('orders.edit', $order) }}" class="ms-3" style="color: #6B4F3F;">Ubah Status</a>
                        @endif
                        @if (!auth()->user()->isAdmin() && $order->status === 'completed')
                            <a href="{{ route('reviews.create', $order) }}" class="ms-3" style="color: #6B4F3F;">Beri Ulasan</a>
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