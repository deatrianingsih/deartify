@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-3">Daftar Pembayaran COD</h4>

    @if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Customer</th>
                <th>Pesanan</th>
                <th>Jumlah</th>
                <th>Metode</th>
                <th>Status</th>
                <th width="150">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($payments as $payment)
            <tr>
                <td>{{ $payment->user->nama }}</td>
                <td>#{{ $payment->order_id }}</td>
                <td>Rp{{ number_format($payment->amount, 0, ',', '.') }}</td>
                <td>{{ strtoupper($payment->method) }}</td>
                <td><span class="badge bg-secondary">{{ $payment->status}}</span></td>
                <td>
                    @if ($payment->status === 'pending')
                    <form action="{{ route('payments.confirm', $payment) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-sm btn-success">Konfirmasi Diterima</button>
                    </form>
                    @else
                    <span class="text-muted">Sudah Diterima</span>
                    @endif
                </td>
            </tr>
                
            @empty
                <tr><td colspan="6" class="text-center">Belum ada data pembayaran.</td></tr>
            @endforelse
        </tbody>
    </table>

    {{ $payments->links() }}
</div>
@endsection