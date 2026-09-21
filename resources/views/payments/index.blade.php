@extends('layouts.dashboard')

@section('content')
<div class="mb-4">
    <h4 class="fw-semibold mb-1"><i class="bi bi-cash-coin me-2" style="color: #8B6F5B;"></i>Daftar Pembayaran COD</h4>
    <p class="text-muted small mb-0">Daftar pesanan yang menggunakan metode pembayaran COD</p>
</div>

<form method="GET" class="mb-3" style="max-width: 320px;">
    <div class="input-group">
        <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
        <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari nama, email, atau nomor telepon..." class="form-control border-start-0">
    </div>
</form>

<div class="card border-0 shadow-sm" style="border-radius: 16px;">
    <div class="card-body p-0">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th class="py-2 px-3" style="background-color: #EDDECA; border-radius: 8px 0 0 8px;">No</th>
                    <th class="py-2 px-3" style="background-color: #EDDECA;">Nama</th>
                    <th class="py-2 px-3" style="background-color: #EDDECA;">Email</th>
                    <th class="py-2 px-3" style="background-color: #EDDECA;">No. Telepon</th>
                    <th class="py-2 px-3" style="background-color: #EDDECA;">Tanggal Pesan</th>
                    <th class="py-2 px-3" style="background-color: #EDDECA;">Status</th>
                    <th class="py-2 px-3" style="background-color: #EDDECA; border-radius: 0 8px 8px 0;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($payments as $payment)
                    <tr>
                        <td class="px-3 py-3">{{ $loop->iteration + ($payments->currentPage() - 1) * $payments->perPage() }}</td>
                        <td class="px-3 py-3">
                            <div class="d-flex align-items-center gap-2">
                                <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-semibold" style="width: 32px; height: 32px; background-color: #8B6F5B; font-size: 0.8rem;">
                                    {{ strtoupper(substr($payment->user->name, 0, 1)) }}
                                </div>
                                {{ $payment->user->name }}
                            </div>
                        </td>
                        <td class="px-3 py-3">{{ $payment->user->email }}</td>
                        <td class="px-3 py-3">{{ $payment->user->phone ?? '-' }}</td>
                        <td class="px-3 py-3">{{ $payment->created_at->format('d M Y') }}</td>
                        <td class="px-3 py-3">
                            <span class="badge" style="background-color: {{ $payment->status === 'pending' ? '#EAC98B' : '#8FBF8F' }}; color: #4A3B32;">
                                <i class="bi {{ $payment->status === 'pending' ? 'bi-clock' : 'bi-check-circle-fill' }} me-1"></i>{{ $payment->status === 'pending' ? 'Menunggu' : 'Selesai' }}
                            </span>
                        </td>
                        <td class="px-3 py-3">
                            <a href="{{ route('payments.show', $payment) }}" class="btn btn-sm text-white" style="background-color: #8B6F5B;">
                                <i class="bi bi-eye"></i> Detail
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center text-muted py-4">Belum ada data pembayaran.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="d-flex justify-content-between align-items-center mt-3">
    <span class="small text-muted">Menampilkan {{ $payments->count() }} - {{ $payments->total() }} data</span>
    {{ $payments->links() }}
</div>
@endsection