@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-3">Daftar Pesanan</h4>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @auth
        @if (!auth()->user()->isAdmin())
            <a href="{{ route('orders.create') }}" class="btn btn-primary mb-3">Buat Pesanan Baru</a>
        @endif
    @endauth

    <table class="table table-bordered">
        <thead>
            <tr>
                @if (auth()->user()->isAdmin())
                    <th>Customer</th>
                @endif
                <th>Jasa</th>
                <th>Status</th>
                <th>Total</th>
                <th width="200">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($orders as $order)
                <tr>
                    @if (auth()->user()->isAdmin())
                        <td>{{ $order->user->nama }}</td>
                    @endif
                    <td>{{ $order->servicePrice->name }}</td>
                    <td><span class="badge bg-secondary">{{ $order->status }}</span></td>
                    <td>Rp{{ number_format($order->total_price, 0, ',', '.') }}</td>
                    <td>
                        <a href="{{ route('orders.show', $order) }}" class="btn btn-sm btn-info">Detail</a>
                        @if (auth()->user()->isAdmin())
                            <a href="{{ route('orders.edit', $order) }}" class="btn btn-sm btn-warning">Ubah Status</a>
                        @endif
                        @if (!auth()->user()->isAdmin() && $order->status === 'completed')
                            <a href="{{ route('reviews.create', $order) }}" class="btn btn-sm btn-success">Beri Ulasan</a>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center">Belum ada pesanan.</td></tr>
            @endforelse
        </tbody>
    </table>

    {{ $orders->links() }}
</div>
@endsection