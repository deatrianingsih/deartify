@extends('layouts.dashboard')

@section('content')
<div class="d-flex justify-content-between align-items-start mb-4 flex-wrap gap-2">
    <div>
        <h4 class="fw-semibold mb-1"><i class="bi bi-people-fill me-2" style="color: #8B6F5B;"></i>Data Pelanggan</h4>
        <p class="text-muted small mb-0">Kelola data pelanggan yang menggunakan layanan ilustrasi</p>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm p-3 d-flex flex-row align-items-center gap-3" style="border-radius: 16px;">
            <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background-color: #EDDECA; color: #8B6F5B;">
                <i class="bi bi-people-fill"></i>
            </div>
            <div>
                <div class="fs-4 fw-semibold">{{ $totalCustomers }}</div>
                <div class="text-muted small">Total Pelanggan</div>
            </div>
        </div>
    </div>
</div>

<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
    <form method="GET" style="max-width: 320px; width: 100%;">
        <div class="input-group">
            <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
            <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari nama atau email..." class="form-control border-start-0">
        </div>
    </form>
</div>

<div class="card border-0 shadow-sm" style="border-radius: 16px;">
    <div class="card-body p-0">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th class="py-2 px-3" style="background-color: #EDDECA; border-radius: 8px 0 0 8px;">No</th>
                    <th class="py-2 px-3" style="background-color: #EDDECA;">Nama</th>
                    <th class="py-2 px-3" style="background-color: #EDDECA;">Email</th>
                    <th class="py-2 px-3" style="background-color: #EDDECA;">No. Telepon</th>
                    <th class="py-2 px-3" style="background-color: #EDDECA;">Tanggal Daftar</th>
                    <th class="py-2 px-3" style="background-color: #EDDECA; border-radius: 0 8px 8px 0;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($customers as $customer)
                    <tr>
                        <td class="px-3 py-3">{{ $loop->iteration + ($customers->currentPage() - 1) * $customers->perPage() }}</td>
                        <td class="px-3 py-3">
                            <div class="d-flex align-items-center gap-2">
                                <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-semibold" style="width: 32px; height: 32px; background-color: #8B6F5B; font-size: 0.8rem;">
                                    {{ strtoupper(substr($customer->name, 0, 1)) }}
                                </div>
                                {{ $customer->name }}
                            </div>
                        </td>
                        <td class="px-3 py-3">{{ $customer->email }}</td>
                        <td class="px-3 py-3">{{ $customer->phone ?? '-' }}</td>
                        <td class="px-3 py-3">{{ $customer->created_at->format('d M Y') }}</td>
                        <td class="px-3 py-3">
                            <a href="{{ route('customers.show', $customer) }}" class="btn btn-sm text-white" style="background-color: #8B6F5B;">
                                <i class="bi bi-eye"></i> Lihat Detail
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-muted py-4">Belum ada pelanggan terdaftar.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="d-flex justify-content-between align-items-center mt-3">
    <span class="small text-muted">Menampilkan {{ $customers->count() }} dari {{ $customers->total() }} pelanggan</span>
    {{ $customers->links() }}
</div>
@endsection