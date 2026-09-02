@extends('layouts.dashboard')

@section('content')
    <h4 class="fw-semibold mb-4">Detail Pelanggan: {{ $customer->name }}</h4>

    <div class="card border-0 shadow-sm p-4 mb-4" style="border-radius: 16px; max-width: 500px;">
    <table class="table table-borderless mb-0">
        <tr><th width="150">Name</th><td>{{ $customer->name }}</td></tr>
        <tr><th>Email</th><td>{{ $customer->email }}</td></tr>
        <tr><th>No. Telepon</th><td>{{ $customer->phone ?? '-' }}</td></tr>
    </table>

    <h6 class="mb-3">Riwayat Pesanan</h6>
    <div class="card border-0 shadow-sm" style="border-radius: 16px;">
        <div class="card-body p-0">
    <table class="table mb-0">
        <thead>
            <tr class="text-muted">
            <th class="px-4 py-3">Jasa</th>
            <th class="px-4 py-3">Status</th>
            <th class="px-4 py-3">Total</th>
        </tr>
        </thead>
        <tbody>
            @forelse ($customer->order as $order)
                <tr>
                    <td class="px-4 py-3">{{ $order->servicePrice->name }}</td>
                    <td class="px-4 py-3">
                        <span class="badge" style="background-color: #4A3B32;">{{ $order->status }}</span>
                    </td>
                    <td class="px-4 py-3">Rp{{ number_format($order->total_price, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center text-muted py-4">Belum pernah pesan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    </div>
    </div>

    <a href="{{ route('customers.index') }}" class="btn btn-outline-secondary mt-3">Kembali</a>
@endsection