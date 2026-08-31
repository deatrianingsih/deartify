@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-3">Ulasan Pelanggan</h4>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Customer</th>
                <th>Jasa</th>
                <th>Rating</th>
                <th>Komentar</th>
                @if (auth()->user()->isAdmin())
                    <th width="100">Aksi</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @forelse ($reviews as $review)
            <tr>
                <td>{{ $review->user->nama }}</td>
                <td>{{ $review->order->servicePrice->name }}</td>
                <td>{{ str_repeat("\u{2B50}", $review->rating) }}</td>
                <td>{{ $review->comment }}</td>
                @if (auth()->user()->isAdmin())
                <td>
                    <form action="{{ route('reviews.destroy', $review) }}" method="POST" onsubmit="return confirm('Yakin hapus?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                    </form>
                </td>
                @endif
            </tr>
            @empty
            <tr><td colspan="5" class="text-center">Belum ada ulasan.</td></tr>
            @endforelse
        </tbody>
    </table>
    {{  $reviews->links }}
</div>
@endsection