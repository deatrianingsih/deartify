@extends('layouts.dashboard')

@section('content')
    <h4 class="fw-semibold mb-4">Daftar Pembayaran COD</h4>

    <div class="card border-0 shadow-sm" style="border-radius: 16px;">
        <div class="card-body p-0">
            <table class="table table-bordered">
                <thead>
                <tr class="text-muted">
                <th class="px-4 py-3">Customer</th>
                <th class="px-4 py-3">Pesanan</th>
                <th class="px-4 py-3">Jumlah</th>
                <th class="px-4 py-3">Metode</th>
                <th class="px-4 py-3">Status</th>
                <th class="px-4 py-3">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($payments as $payment)
            <tr>
                <td class="px-4 py-3">{{ $payment->user->name }}</td>
                <td class="px-4 py-3">#{{ $payment->order_id }}</td>
                <td class="px-4 py-3">Rp{{ number_format($payment->amount, 0, ',', '.') }}</td>
                <td class="px-4 py-3">{{ strtoupper($payment->method) }}</td>
                <td class="px-4 py-3">
                    <span class="badge" style="background-color: #C9AF9A; color: #4A3B32;">
                        {{ $payment->status}}
                    </span>
                </td>
                <td class="px-4 py-3">
                    @if ($payment->status === 'pending')
                    <form action="{{ route('payments.confirm', $payment) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-sm text-white" style="background-color: #6B4F3F;">Konfirmasi Diterima</button>
                    </form>
                    @else
                    <span class="text-muted">Sudah Diterima</span>
                    @endif
                </td>
            </tr>
                
            @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">Belum ada data pembayaran.</td></tr>
            @endforelse
        </tbody>
    </table>
 </div>
 </div>
<div class="mt-3">
    {{ $payments->links() }}
</div>
@endsection