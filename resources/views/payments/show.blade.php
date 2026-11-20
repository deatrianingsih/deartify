@extends('layouts.dashboard')

@push('styles')
<style>
    .pd-wrap {
    max-width: 1100px;
    margin: 0 auto;
}

.pd-back {
    display: inline-flex;
    align-items: center;
    gap: .4rem;
    color: #8B6F5B;
    font-weight: 800;
    text-decoration: none;
    margin-bottom: .8rem;
}

.pd-back:hover {
    color: #5E4334;
}

.pd-head {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    gap: 1rem;
    flex-wrap: wrap;
    margin-bottom: 1.3rem;
}

.pd-head h3 {
    margin: 0 0 .2rem;
    font-weight: 800;
    color: #4A3B32;
    display: flex;
    align-items: center;
    gap: .6rem;
}

.pd-head h3 i {
    color: #8B6F5B;
}

.pd-head p {
    margin: 0;
    color: #85766B;
}

.pd-badge {
    display: inline-flex;
    align-items: center;
    gap: .4rem;
    padding: .5rem 1.1rem;
    border-radius: 999px;
    font-weight: 800;
    font-size: .9rem;
}

.pd-badge.wait {
    background: #FFF1D6;
    color: #9A6A0B;
}

.pd-badge.ok {
    background: #E3F4E6;
    color: #2F7A3D;
}

.pd-badge.no {
    background: #FBEAEA;
    color: #B3402F;
}

.pd-card {
    background: #fff;
    border: 1px solid #EFE3D3;
    border-radius: 22px;
    box-shadow: 0 2px 14px rgba(74, 59, 50, .07);
    overflow: hidden;
    height: 100%;
}

.pd-sec {
    padding: 1.1rem 1.4rem .4rem;
    font-size: .74rem;
    font-weight: 800;
    letter-spacing: .1em;
    text-transform: uppercase;
    color: #9A7B66;
}

.pd-total {
    margin: .4rem 1.4rem 1rem;
    background: linear-gradient(135deg, #8B6F5B, #5E4334);
    color: #fff;
    border-radius: 18px;
    padding: 1.1rem 1.3rem;
    box-shadow: 0 10px 22px rgba(94, 67, 52, .28);
}

.pd-total small {
    color: #F1D9B8;
    font-weight: 700;
}

.pd-total strong {
    display: block;
    font-size: 2rem;
    line-height: 1.15;
}

.pd-rows {
    padding: 0 1.4rem .4rem;
}

.pd-row {
    display: flex;
    align-items: center;
    gap: .9rem;
    padding: .75rem 0;
    border-bottom: 1px solid #F3E9DA;
}

.pd-row:last-child {
    border-bottom: 0;
}

.pd-ic {
    width: 38px;
    height: 38px;
    border-radius: 12px;
    background: #F5EAD8;
    color: #8B6F5B;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.pd-row small {
    display: block;
    color: #9A8B80;
    font-weight: 600;
    font-size: .78rem;
}

.pd-row b {
    color: #4A3B32;
}

.pd-act {
    padding: .6rem 1.4rem 1.4rem;
}

.pd-note {
    border-radius: 14px;
    padding: .9rem 1rem;
    font-size: .92rem;
    display: flex;
    gap: .7rem;
    align-items: flex-start;
}

.pd-note i {
    font-size: 1.2rem;
    margin-top: .05rem;
}

.pd-note.warn {
    background: #FFF6E3;
    color: #8A5E0A;
}

.pd-note.bad {
    background: #FBEAEA;
    color: #A8392A;
}

.pd-note.good {
    background: #E3F4E6;
    color: #2F7A3D;
}

.pd-btn {
    width: 100%;
    border: 0;
    border-radius: 14px;
    padding: .95rem 1rem;
    background: linear-gradient(135deg, #3E9B55, #2F7A3D);
    color: #fff;
    font-weight: 800;
    font-size: 1rem;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: .5rem;
    box-shadow: 0 10px 22px rgba(47, 122, 61, .3);
    transition: transform .2s, box-shadow .2s;
}

.pd-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 14px 28px rgba(47, 122, 61, .38);
}

.pd-proof {
    padding: 0 1.4rem 1.4rem;
    text-align: center;
}

.pd-frame {
    background: linear-gradient(145deg, #F5EAD8, #E6D2B8);
    border-radius: 18px;
    padding: 1rem;
    display: flex;
    justify-content: center;
    cursor: zoom-in;
}

.pd-frame img {
    max-width: 100%;
    max-height: 440px;
    border-radius: 12px;
    box-shadow: 0 8px 22px rgba(74, 59, 50, .3);
    object-fit: contain;
}

.pd-zoom {
    margin-top: .7rem;
    color: #8B6F5B;
    font-weight: 700;
    font-size: .88rem;
}

.pd-none {
    height: 260px;
    margin-bottom: 0;
    background: #FBF3E8;
    border: 2px dashed #D9C3A8;
    border-radius: 18px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    color: #9A8B80;
    gap: .3rem;
}

.pd-none i {
    font-size: 2.6rem;
    color: #C9AF9A;
}

.pd-lb {
    border: 0;
    padding: 0;
    background: transparent;
    max-width: 94vw;
    max-height: 94vh;
    margin: auto;
}

.pd-lb::backdrop {
    background: rgba(30, 18, 10, .8);
}

.pd-lb img {
    max-width: 94vw;
    max-height: 92vh;
    border-radius: 14px;
    display: block;
}
</style>
@endpush

@section('content')
@php
    $order = $payment->order;
    $cancelled = $order && $order->status === 'cancelled';
    if ($cancelled) { $state = ['no', 'bi-x-circle', 'Pesanan Dibatalkan']; }
    elseif ($payment->status === 'pending') { $state = ['wait', 'bi-hourglass-split', 'Menunggu Konfirmasi']; }
    else { $state = ['ok', 'bi-check-circle', 'Lunas']; }
    $service = $order?->servicePrice?->name;
@endphp

<div class="pd-wrap">
    <a href="{{ route('payments.index') }}" class="pd-back"><i class="bi bi-arrow-left"></i>Kembali ke Pembayaran</a>

    <div class="pd-head">
        <div>
            <h3><i class="bi bi-credit-card-2-front"></i>Konfirmasi Pembayaran</h3>
            <p>Periksa bukti pembayaran, lalu konfirmasi kalau uang sudah masuk.</p>
        </div>
        <span class="pd-badge {{ $state[0] }}"><i class="bi {{ $state[1] }}"></i>{{ $state[2] }}</span>
    </div>

    <div class="row g-3">
        {{-- Kiri: detail --}}
        <div class="col-lg-6">
            <div class="pd-card">
                <div class="pd-sec">Total Pembayaran</div>
                <div class="pd-total">
                    <small>Pesanan #{{ $payment->order_id }}</small>
                    <strong>Rp{{ number_format($payment->amount, 0, ',', '.') }}</strong>
                </div>

                <div class="pd-sec" style="padding-top:.2rem;">Detail</div>
                <div class="pd-rows">
                    <div class="pd-row"><span class="pd-ic"><i class="bi bi-person"></i></span><div><small>Customer</small><b>{{ $payment->user->name }}</b></div></div>
                    @if ($service)
                        <div class="pd-row"><span class="pd-ic"><i class="bi bi-palette"></i></span><div><small>Layanan</small><b>{{ $service }}</b></div></div>
                    @endif
                    <div class="pd-row"><span class="pd-ic"><i class="bi bi-wallet2"></i></span><div><small>Metode Pembayaran</small><b>{{ $payment->methodLabel() }}</b></div></div>
                    @if ($payment->proof_uploaded_at)
                        <div class="pd-row"><span class="pd-ic"><i class="bi bi-cloud-arrow-up"></i></span><div><small>Bukti Diunggah</small><b>{{ $payment->proof_uploaded_at->timezone('Asia/Jakarta')->format('d M Y, H:i') }}</b></div></div>
                    @endif
                    @if ($payment->received_at)
                        <div class="pd-row"><span class="pd-ic"><i class="bi bi-patch-check"></i></span><div><small>Dikonfirmasi Pada</small><b>{{ $payment->received_at->timezone('Asia/Jakarta')->format('d M Y, H:i') }}</b></div></div>
                    @endif
                </div>

                <div class="pd-act">
                    @if ($cancelled)
                        <div class="pd-note bad">
                            <i class="bi bi-exclamation-octagon"></i>
                            <div>
                                <b>Pesanan ini dibatalkan customer.</b>
                                @if ($order->cancel_reason)<div class="mt-1">Alasan: {{ $order->cancel_reason }}</div>@endif
                                @if ($payment->proof_path || $payment->status !== 'pending')
                                    <div class="mt-1">Customer sudah membayar/mengunggah bukti. Proses pengembalian dana secara manual.</div>
                                @endif
                            </div>
                        </div>
                    @elseif ($payment->status === 'pending')
                        @if ($payment->isEwallet() && ! $payment->proof_path)
                            <div class="pd-note warn"><i class="bi bi-hourglass-split"></i><div>Customer belum mengunggah bukti pembayaran.</div></div>
                        @else
                            <form action="{{ route('payments.confirm', $payment) }}" method="POST"
                                  onsubmit="return confirm('Pastikan uang sudah masuk ke e-wallet kamu. Konfirmasi pembayaran?')">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="pd-btn"><i class="bi bi-check2-circle"></i>Konfirmasi Pembayaran Diterima</button>
                            </form>
                        @endif
                    @else
                        <div class="pd-note good"><i class="bi bi-check-circle"></i><div>Pembayaran sudah dikonfirmasi diterima.</div></div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Kanan: bukti --}}
        @if ($payment->isEwallet())
            <div class="col-lg-6">
                <div class="pd-card">
                    <div class="pd-sec">Bukti Pembayaran</div>
                    <div class="pd-proof">
                        @if ($payment->proof_path)
                            <div class="pd-frame" id="proofOpen"><img src="{{ Storage::url($payment->proof_path) }}" alt="Bukti pembayaran"></div>
                            <div class="pd-zoom"><i class="bi bi-zoom-in"></i> Klik gambar untuk memperbesar</div>
                        @else
                            <div class="pd-none"><i class="bi bi-image"></i>Belum ada bukti diunggah</div>
                        @endif
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

@if ($payment->proof_path)
    <dialog class="pd-lb" id="proofLb"><img src="{{ Storage::url($payment->proof_path) }}" alt="Bukti pembayaran"></dialog>
    <script>
        (function () {
            var lb = document.getElementById('proofLb');
            document.getElementById('proofOpen').addEventListener('click', function () { lb.showModal(); });
            lb.addEventListener('click', function () { lb.close(); });
        })();
    </script>
@endif
@endsection