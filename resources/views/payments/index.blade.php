@extends('layouts.dashboard')

@section('content')
@php
    $methodTabs = ['' => 'Semua', 'cod' => 'COD'] + collect(config('payment.wallets'))->map(fn ($w) => $w['label'])->all();
@endphp
<div class="mb-4">
    <h4 class="fw-semibold mb-1"><i class="bi bi-cash-coin me-2" style="color: #8B6F5B;"></i>Daftar Pembayaran</h4>
    <p class="text-muted small mb-0">Pembayaran COD dan e-wallet (DANA, OVO, GoPay) dari semua pesanan</p>
</div>

<div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
    <div class="d-flex gap-2">
        @foreach ($methodTabs as $value => $label)
            <a href="{{ route('payments.index', array_filter(['method' => $value, 'search' => $search ?? null])) }}"
               class="btn btn-sm {{ ($method ?? '') === $value ? 'text-white' : 'btn-outline-secondary' }}"
               style="{{ ($method ?? '') === $value ? 'background-color: #8B6F5B;' : '' }} border-radius: 20px;">{{ $label }}</a>
        @endforeach
    </div>
    <div class="d-flex gap-2 flex-wrap">
        <form method="GET" style="max-width: 320px;">
            <input type="hidden" name="method" value="{{ $method ?? '' }}">
            <div class="input-group">
                <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
                <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari nama atau email..." class="form-control border-start-0">
            </div>
        </form>
    </div>
</div>

<div class="card border-0 shadow-sm" style="border-radius: 16px;">
    <div class="card-body p-0">
        <div class="table-responsive">
        <table class="table mb-0 align-middle">
            <thead>
                <tr>
                    <th class="py-2 px-3" style="background-color: #EDDECA;">No</th>
                    <th class="py-2 px-3" style="background-color: #EDDECA;">Nama</th>
                    <th class="py-2 px-3" style="background-color: #EDDECA;">Pesanan</th>
                    <th class="py-2 px-3" style="background-color: #EDDECA;">Metode</th>
                    <th class="py-2 px-3" style="background-color: #EDDECA;">Total</th>
                    <th class="py-2 px-3" style="background-color: #EDDECA;">Tanggal</th>
                    <th class="py-2 px-3" style="background-color: #EDDECA;">Status</th>
                    <th class="py-2 px-3" style="background-color: #EDDECA;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($payments as $payment)
                    @php
                        $done = $payment->status !== 'pending';
                        $waitingProof = $payment->isEwallet() && ! $done && ! $payment->proof_path;
                        $needsCheck = $payment->isEwallet() && ! $done && $payment->proof_path;
                    @endphp
                    <tr>
                        <td class="px-3 py-3">{{ $loop->iteration + ($payments->currentPage() - 1) * $payments->perPage() }}</td>
                        <td class="px-3 py-3">
                            <div class="d-flex align-items-center gap-2">
                                <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-semibold" style="width: 32px; height: 32px; background-color: #8B6F5B; font-size: 0.8rem;">
                                    {{ strtoupper(substr($payment->user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div>{{ $payment->user->name }}</div>
                                    <div class="small text-muted">{{ $payment->user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-3 py-3">#{{ $payment->order_id }}</td>
                        <td class="px-3 py-3"><span class="badge" style="background-color: {{ $payment->isEwallet() ? '#DCEBFA' : '#EDDECA' }}; color: #4A3B32;">{{ $payment->methodLabel() }}</span></td>
                        <td class="px-3 py-3">Rp{{ number_format($payment->amount, 0, ',', '.') }}</td>
                        <td class="px-3 py-3">{{ $payment->created_at->format('d M Y') }}</td>
                        <td class="px-3 py-3">
                            @if ($done)
                                <span class="badge" style="background-color: #8FBF8F; color: #4A3B32;"><i class="bi bi-check-circle-fill me-1"></i>Lunas</span>
                            @elseif ($needsCheck)
                                <span class="badge" style="background-color: #F0B33C; color: #4A3B32;"><i class="bi bi-receipt me-1"></i>Perlu dicek</span>
                            @elseif ($waitingProof)
                                <span class="badge" style="background-color: #EAC98B; color: #4A3B32;"><i class="bi bi-hourglass-split me-1"></i>Menunggu bukti</span>
                            @else
                                <span class="badge" style="background-color: #EAC98B; color: #4A3B32;"><i class="bi bi-clock me-1"></i>Menunggu</span>
                            @endif
                        </td>
                        <td class="px-3 py-3">
                            <a href="{{ route('payments.show', $payment) }}" class="btn btn-sm text-white" style="background-color: #8B6F5B;"><i class="bi bi-eye"></i> Detail</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="8" class="text-center text-muted py-4">Belum ada data pembayaran.</td></tr>
                @endforelse
            </tbody>
        </table>
        </div>
    </div>
</div>

<div class="d-flex justify-content-between align-items-center mt-3">
    <span class="small text-muted">Menampilkan {{ $payments->count() }} dari {{ $payments->total() }} data</span>
    {{ $payments->links('pagination::bootstrap-5') }}
</div>
@endsection