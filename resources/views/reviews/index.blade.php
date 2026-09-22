@extends('layouts.dashboard')

@section('content')
<div class="mb-4">
    <h4 class="fw-semibold mb-1"><i class="bi bi-star-fill me-2" style="color: #8B6F5B;"></i>{{ auth()->user()->isAdmin() ? 'Ulasan Pelanggan' : 'Ulasan Saya' }}</h4>
    <p class="text-muted small mb-0">{{ auth()->user()->isAdmin() ? 'Lihat apa yang pelanggan katakan tentang layanan kamu' : 'Riwayat ulasan yang sudah kamu berikan' }}</p>
</div>

<div class="card border-0 shadow-sm" style="border-radius: 16px;">
    <div class="card-body p-0">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th class="py-2 px-3" style="background-color: #EDDECA; border-radius: 8px 0 0 8px;">Customer</th>
                    <th class="py-2 px-3" style="background-color: #EDDECA;">Jasa</th>
                    <th class="py-2 px-3" style="background-color: #EDDECA;">Rating</th>
                    <th class="py-2 px-3" style="background-color: #EDDECA; {{ auth()->user()->isAdmin() ? '' : 'border-radius: 0 8px 8px 0;' }}">Komentar</th>
                    @if (auth()->user()->isAdmin())
                        <th class="py-2 px-3" style="background-color: #EDDECA; border-radius: 0 8px 8px 0;">Aksi</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse ($reviews as $review)
                    <tr>
                        <td class="px-3 py-3">
                            <div class="d-flex align-items-center gap-2">
                                <div class="rounded-circle d-flex align-items-center justify-content-center"
                                     style="width: 36px; height: 36px; background-color: #EDDECA; color: #8B6F5B;">
                                    <i class="bi bi-person-fill"></i>
                                </div>
                                <span class="fw-semibold">{{ $review->user->name }}</span>
                            </div>
                        </td>
                        <td class="px-3 py-3">{{ $review->order->servicePrice->name }}</td>
                        <td class="px-3 py-3" style="color: #E8B84B;">{{ str_repeat('★', $review->rating) }}</td>
                        <td class="px-3 py-3 text-muted">{{ $review->comment }}</td>
                        @if (auth()->user()->isAdmin())
                            <td class="px-3 py-3">
                                <form action="{{ route('reviews.destroy', $review) }}" method="POST" onsubmit="return confirm('Yakin hapus?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">Belum ada ulasan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">
    {{ $reviews->links() }}
</div>
@endsection