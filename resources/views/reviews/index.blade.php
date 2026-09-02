@extends('layouts.dashboard')

@section('content')
    <h4 class="fw-semibold mb-4">Ulasan Pelanggan</h4>

    <div class="card border-0 shadow-sm" style="border-radius: 16px;">
        <div class="card-body p-0">
    <table class="table mb-0">
        <thead>
            <tr class="text-muted">
                <th class="px-4 py-3">Customer</th>
                <th class="px-4 py-3">Jasa</th>
                <th class="px-4 py-3">Rating</th>
                <th class="px-4 py-3">Komentar</th>
                @if (auth()->user()->isAdmin())
                    <th class="px-4 py-3">Aksi</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @forelse ($reviews as $review)
            <tr>
                <td class="px-4 py-3">{{ $review->user->nama }}</td>
                <td class="px-4 py-3">{{ $review->order->servicePrice->name }}</td>
                <td class="px-4 py-3" style="color: #E8B84B">{{ str_repeat("\u{2B50}", $review->rating) }}</td>
                <td class="px-4 py-3 text-muted">{{ $review->comment }}</td>
                @if (auth()->user()->isAdmin())
                <td class="px-4 py-3">
                    <form action="{{ route('reviews.destroy', $review) }}" method="POST" onsubmit="return confirm('Yakin hapus?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-link text-danger p-0">Hapus</button>
                    </form>
                </td>
                @endif
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center text-muted py-5">Belum ada ulasan.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    </div>
    </div>
    {{  $reviews->links }}
</div>
@endsection