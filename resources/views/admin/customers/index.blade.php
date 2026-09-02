@extends('layouts.dashboard')

@section('content')
    <h4 class="fw-semibold mb-4">Data Pelanggan</h4>

    <div class="card border-0 shadow-sm" style="border-radius: 16px;">
        <div class="card-body p-0">
    <table class="table mb-0">
        <thead>
            <tr class="text-muted">
                <th class="px-4 py-3">Name</th>
                <th class="px-4 py-3">Email</th>
                <th class="px-4 py-3">No. Telepon</th>
                <th class="px-4 py-3">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($customers as $customer)
            <tr>
                <td class="px-4 py-3">{{ $customer->name }}</td>
                <td class="px-4 py-3">{{ $customer->email }}</td>
                <td class="px-4 py-3">{{ $customer->phone ?? '-' }}</td>
                <td class="px-4 py-3">
                    <a href="{{ route('customers.show', $customer) }}" style="color: #6B4F3F;">Detail</a>
                </td>
            </tr>
                
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted py-4">Belum ada pelanggan terdaftar.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">
    {{ $customers->links() }}
</div>
@endsection