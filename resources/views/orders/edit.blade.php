@extends('layouts.dashboard')

@section('content')
<h4 class="fw-semibold mb-4">Ubah Status Pesanan #{{ $order->id }}</h4>

<div class="card border-0 shadow-sm p-4" style="border-radius: 16px; max-width: 500px;">
    <form action="{{ route('orders.update', $order) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-select">
                @foreach (['pending', 'in_progress', 'shipped', 'completed'] as $status)
                    <option value="{{ $status }}" @selected($order->status === $status)>{{ $status }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn text-white" style="background-color: #8B6F5B;">Update Status</button>
        <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary">Batal</a>
    </form>
</div>
@endsection