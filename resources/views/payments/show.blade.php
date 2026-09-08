@extends('layouts.dashboard')

@section('content')
<h4 class="fw-semibold mb-4">Konfirmasi Pembayaran (COD)</h4>

<div class="card border-0 shadow-sm p-4" style="border-radius: 16px; max-width: 500px;">
    <table class="table table-borderless mb-4">
        <tr><th width="160" class="text-muted fw-normal">Customer</th><td>{{ $payment->user->name }}</td></tr>
        <tr><th class="text-muted fw-normal">Pesanan</th><td>#{{ $payment->order_id }}</td></tr>
        <tr><th class="text-muted fw-normal">Total Pembayaran</th><td class="fs-5 fw-semibold">Rp{{ number_format($payment->amount, 0, ',', '.') }}</td></tr>
        <tr><th class="text-muted fw-normal">Metode Pembayaran</th><td>{{ strtoupper($payment->method) }}</td></tr>
        <tr>
            <th class="text-muted fw-normal">Status</th>
            <td><span class="badge" style="background-color: #4A3B32;">{{ $payment->status }}</span></td>
        </tr>
        @if ($payment->received_at)
        <tr><th class="text-muted fw-normal">Diterima Pada</th><td>{{ $payment->received_at }}</td></tr>
        @endif
    </table>

    @if ($payment->status == 'pending')
    <form action="{{ route('payments.confirm', $payment) }}" method="POST">
        @csrf
        @method('PATCH')
        <button type="submit" class="btn text-white w-100" style="background-color: #8B6F5B;">
            Konfirmasi Pembayaran Diterima
        </button>
    </form>
    @else
        <div class="alert alert-success mb-0">Pembayaran sudah dikonfirmasi diterima.</div>
    @endif
</div>

<a href="{{ route('payments.index') }}" class="btn btn-outline-secondary mt-3">Kembali</a>
@endsection