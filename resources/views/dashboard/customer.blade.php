@extends('layouts.dashboard')

@section('content')
<div class="card border-0 shadow-sm p-5 mb-4 overflow-hidden" style="
    border-radius: 16px;
    min-height: 280px;
    background-image: linear-gradient(to right, #F5EAD8 0%, rgba(245,234,216,0.85) 35%, rgba(245,234,216,0.4) 60%, rgba(245,234,216,0) 100%), url('{{ asset('images/lukis.jpg') }}');
    background-size: cover;
    background-position: 75% 65%;
    background-repeat: no-repeat;
">
    <div style="max-width: 55%;">
        <h5 class="fw-semibold mb-1">Selamat datang, {{ auth()->user()->name }}!</h5>
        <p class="mb-0 text-muted">Yuk, pesan ilustrasi impianmu sekarang dan wujudkan ide kreatifmu bersama DeArtify!</p>
        <p class="mb-0 small fst-italic" style="color: #8B6F5B;">
        💡 Tips: sertakan gambar referensi saat memesan biar hasil ilustrasi makin sesuai keinginanmu.
    </p>
    </div>
</div>
<div class="row g-3 mb-4">
    <div class="col">
        <div class="card border-0 shadow-sm p-4" style="border-radius: 16px; background-color: #F5EAD8;">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <i class="bi bi-clipboard-check fs-4" style="color: #8B6F5B;"></i>
                <i class="bi bi-arrow-right-circle text-muted"></i>
            </div>
            <div class="fs-4 fw-semibold">{{ $totalMyOrders }}</div>
            <div class="text-muted small">Total Pesanan</div>
        </div>
    </div>
    <div class="col">
        <div class="card border-0 shadow-sm p-4" style="border-radius: 16px; background-color: #F5EAD8;">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <i class="bi bi-hourglass-split fs-4" style="color: #8B6F5B;"></i>
                <i class="bi bi-arrow-right-circle text-muted"></i>
            </div>
            <div class="fs-4 fw-semibold">{{ $inProgressOrders }}</div>
            <div class="text-muted small">Pesanan Diproses</div>
        </div>
    </div>
    <div class="col">
        <div class="card border-0 shadow-sm p-4" style="border-radius: 16px; background-color: #F5EAD8;">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <i class="bi bi-box-seam fs-4" style="color: #8B6F5B;"></i>
                <i class="bi bi-arrow-right-circle text-muted"></i>
            </div>
            <div class="fs-4 fw-semibold">{{ $completedOrders }}</div>
            <div class="text-muted small">Pesanan Selesai</div>
        </div>
    </div>
    <div class="col">
        <div class="card border-0 shadow-sm p-4 text-white" style="border-radius: 16px; background-color: #8B6F5B;">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <i class="bi bi-star-fill fs-4 text-white"></i>
                <i class="bi bi-arrow-right-circle text-white"></i>
            </div>
            <div class="fs-4 fw-semibold">{{ $avgRating ? number_format($avgRating, 1) : '-' }} ★</div>
            <div class="small" style="opacity: 0.9;">Rating Ulasan</div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm" style="border-radius: 16px;">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="mb-0"><i class="bi bi-file-earmark-text me-2" style="color: #8B6F5B;"></i>Pesanan Terbaru</h6>
            <a href="{{ route('orders.index') }}" class="small fst-italic text-decoration-underline" style="color: #6B4F3F;">Lihat semua <i class="bi bi-arrow-right"></i></a>
        </div>
        <table class="table mb-0">
            <thead>
            <tr>
                <th class="py-2 px-2" style="background-color: #EDDECA; border-radius: 8px 0 0 8px;">Judul Pesanan</th>
                <th class="py-2 px-2" style="background-color: #EDDECA;">Tanggal</th>
                <th class="py-2 px-2" style="background-color: #EDDECA;">Status</th>
                <th class="py-2 px-2" style="background-color: #EDDECA;">Total</th>
                <th class="py-2 px-2" style="background-color: #EDDECA; border-radius: 0 8px 8px 0;"></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($myOrders as $order)
                <tr>
                    <td class="py-3">
                        <div class="d-flex align-items-center gap-2">
                            @if ($order->servicePrice->image)
                                <img src="{{ Storage::url($order->servicePrice->image) }}" width="32" height="32" class="rounded" style="object-fit: cover;">
                            @else
                                <div class="rounded" style="width: 32px; height: 32px; background-color: #F5EAD8;"></div>
                            @endif
                            {{ $order->servicePrice->name }}
                        </div>
                    </td>
                    <td class="py-3"><i class="bi bi-calendar3 me-1 text-muted"></i>{{ $order->created_at->format('d M Y') }}</td>
                    <td class="py-3">
                        <span class="badge" style="background-color: #C9AF9A; color: #4A3B32;">
                            <i class="bi bi-check-circle-fill me-1"></i>{{ $order->status }}
                        </span>
                    </td>
                    <td class="py-3">Rp{{ number_format($order->total_price, 0, ',', '.') }}</td>
                    <td class="py-3 text-end">
                        <a href="{{ route('orders.show', $order) }}" style="color: #8B6F5B;"><i class="bi bi-arrow-right-circle fs-5"></i></a>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center text-muted py-3">Belum ada pesanan.</td></tr>
            @endforelse
        </tbody>
        </table>
    </div>
</div>
@endsection