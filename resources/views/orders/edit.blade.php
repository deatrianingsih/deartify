@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-3">Ubah Status Pesanan #{{ $order->id }}</h4>

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

        <button type="submit" class="btn btn-primary">Update Status</button>
        <a href="{{ route('orders.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection