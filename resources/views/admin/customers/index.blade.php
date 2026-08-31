@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-3">Data Pelanggan</h4>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Email</th>
                <th>No. Telepon</th>
                <th width="120">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($customers as $customer)
            <tr>
                <td>{{ $customer->nama }}</td>
                <td>{{ $customer->email }}</td>
                <td>{{ $customer->phone ?? '-' }}</td>
                <td><a href="{{ route('customers.show', $customer) }}" class="btn btn-sm btn-info"></a></td>
            </tr>
                
            @empty
                <tr><td colspan="4" class="text-center">Belum ada pelanggan terdaftar.</td></tr>
            @endforelse
        </tbody>
    </table>

    {{ $customers->links() }}
</div>
@endsection