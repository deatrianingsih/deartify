@extends('layouts.dashboard')

@push('styles')
<style>
   .cn-wrap {
    max-width: 1180px;
    margin: 0 auto;
}

.cn-back {
    display: inline-flex;
    align-items: center;
    gap: .4rem;
    color: #85766B;
    text-decoration: none;
    font-weight: 700;
    font-size: .92rem;
    margin-bottom: .6rem;
}

.cn-back:hover {
    color: var(--c-primary, #8B6F5B);
}

.cn-title {
    font-weight: 800;
    color: var(--c-text, #4A3B32);
    margin: 0 0 .2rem;
    display: flex;
    align-items: center;
    gap: .6rem;
}

.cn-title i {
    color: #B3402F;
}

.cn-sub {
    color: #85766B;
    margin-bottom: 1.2rem;
}

.cn-card {
    background: #fff;
    border-radius: 18px;
    box-shadow: 0 2px 14px rgba(74, 59, 50, .08);
    padding: 1.5rem;
    margin-bottom: 1.1rem;
}

.cn-card h5 {
    font-weight: 800;
    font-size: 1.05rem;
    color: var(--c-text, #4A3B32);
    margin: 0 0 .25rem;
}

.cn-card .hint {
    color: #85766B;
    font-size: .88rem;
    margin-bottom: 1rem;
}

/* Alasan: baris besar yang bisa diklik */
.cn-reasons {
    display: flex;
    flex-direction: column;
    gap: .6rem;
}

.cn-reason {
    position: relative;
    display: flex;
    align-items: center;
    gap: .85rem;
    border: 1.5px solid var(--c-line, #EFE3D3);
    border-radius: 14px;
    padding: .9rem 1.1rem;
    cursor: pointer;
    background: #FDFAF6;
    transition: border-color .15s, background .15s;
}

.cn-reason:hover {
    border-color: var(--c-mid, #C9AF9A);
}

.cn-reason input {
    position: absolute;
    opacity: 0;
    pointer-events: none;
}

.cn-dot {
    width: 22px;
    height: 22px;
    border-radius: 50%;
    border: 2px solid #C9B8A8;
    flex-shrink: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #fff;
    transition: all .15s;
}

.cn-dot::after {
    content: '';
    width: 10px;
    height: 10px;
    border-radius: 50%;
    background: #fff;
    transform: scale(0);
    transition: transform .15s;
}

.cn-reason span.t {
    font-weight: 700;
    color: var(--c-text, #4A3B32);
    font-size: .95rem;
}

.cn-reason:has(input:checked) {
    border-color: var(--c-primary, #8B6F5B);
    background: var(--c-tint, #F5EAD8);
    box-shadow: 0 0 0 .15rem rgba(139, 111, 91, .15);
}

.cn-reason:has(input:checked) .cn-dot {
    border-color: var(--c-primary, #8B6F5B);
    background: var(--c-primary, #8B6F5B);
}

.cn-reason:has(input:checked) .cn-dot::after {
    transform: scale(1);
}

.cn-reason:has(input:focus-visible) {
    outline: 2px solid var(--c-primary, #8B6F5B);
    outline-offset: 2px;
}

.cn-err {
    color: #B3402F;
    font-size: .88rem;
    margin-top: .5rem;
    font-weight: 600;
}

.cn-warn {
    display: flex;
    gap: .8rem;
    background: #FFF6E6;
    border: 1px solid #F3D9A4;
    border-radius: 14px;
    padding: 1rem 1.1rem;
    color: #7A5A14;
    font-size: .9rem;
}

.cn-warn i {
    font-size: 1.3rem;
}

.cn-warn ul {
    margin: .35rem 0 0;
    padding-left: 1.1rem;
}

.cn-warn.refund {
    background: #EAF4FF;
    border-color: #BBD8F5;
    color: #2F6597;
}

/* Ringkasan kanan */
.cn-sticky {
    position: sticky;
    top: calc(var(--cx-nav-h, 72px) + 16px);
}

.cn-prod {
    display: flex;
    gap: .9rem;
    align-items: center;
}

.cn-thumb {
    width: 84px;
    height: 84px;
    border-radius: 12px;
    overflow: hidden;
    background: var(--c-soft, #EDDECA);
    flex-shrink: 0;
    border: 1px solid var(--c-line, #EFE3D3);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--c-mid, #C9AF9A);
    font-size: 1.6rem;
}

.cn-thumb img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.cn-prod h6 {
    font-weight: 800;
    margin: 0 0 .2rem;
    color: var(--c-text, #4A3B32);
}

.cn-prod small {
    color: #85766B;
}

.cn-rows {
    margin-top: 1rem;
    border-top: 1px dashed var(--c-mid, #C9AF9A);
    padding-top: .4rem;
}

.cn-row {
    display: flex;
    justify-content: space-between;
    gap: 1rem;
    padding: .55rem 0;
    font-size: .92rem;
    border-bottom: 1px solid var(--c-line, #EFE3D3);
}

.cn-row:last-child {
    border-bottom: 0;
}

.cn-row span {
    color: #85766B;
}

.cn-row\.total strong {
    font-size: 1.2rem;
    color: var(--c-dark, #6B4F3F);
}

.cn-badge {
    font-size: .74rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: .03em;
    padding: .25rem .65rem;
    border-radius: 999px;
}

.cn-badge.pending {
    background: #EDDECA;
    color: #6B4F3F;
}

.cn-badge.in_progress {
    background: #FCE9C4;
    color: #9A6A12;
}

.cn-actions {
    display: flex;
    flex-direction: column;
    gap: .6rem;
    margin-top: 1.2rem;
}

.cn-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: .5rem;
    width: 100%;
    padding: .85rem;
    border-radius: 12px;
    font-weight: 800;
    font-size: 1rem;
    text-decoration: none;
    cursor: pointer;
    border: 1.5px solid transparent;
    transition: background .2s, color .2s;
}

.cn-btn.danger {
    background: #B3402F;
    color: #fff;
}

.cn-btn.danger:hover {
    background: #8F3223;
    color: #fff;
}

.cn-btn.danger:disabled {
    background: #D9B7B0;
    cursor: not-allowed;
}

.cn-btn.ghost {
    background: #fff;
    color: var(--c-dark, #6B4F3F);
    border-color: var(--c-mid, #C9AF9A);
}

.cn-btn.ghost:hover {
    background: var(--c-tint, #F5EAD8);
    color: var(--c-dark, #6B4F3F);
}

/* Dialog konfirmasi */
dialog.cn-dialog {
    border: 0;
    border-radius: 20px;
    padding: 0;
    max-width: 440px;
    width: calc(100% - 2rem);
    box-shadow: 0 20px 60px rgba(74, 59, 50, .35);
}

dialog.cn-dialog::backdrop {
    background: rgba(74, 59, 50, .5);
}

.cn-dlg-body {
    padding: 1.8rem 1.6rem 1.2rem;
    text-align: center;
}

.cn-dlg-icon {
    width: 64px;
    height: 64px;
    border-radius: 50%;
    background: #FBEAEA;
    color: #B3402F;
    font-size: 1.9rem;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto .9rem;
}

.cn-dlg-body h5 {
    font-weight: 800;
    margin-bottom: .4rem;
}

.cn-dlg-body p {
    color: #6F6258;
    margin-bottom: .4rem;
    font-size: .93rem;
}

.cn-dlg-reason {
    background: var(--c-tint, #F5EAD8);
    border-radius: 10px;
    padding: .55rem .8rem;
    font-weight: 700;
    font-size: .88rem;
    color: var(--c-dark, #6B4F3F);
}

.cn-dlg-actions {
    display: flex;
    gap: .6rem;
    padding: 0 1.6rem 1.6rem;
}

.cn-dlg-actions .cn-btn {
    padding: .75rem;
}

@media (max-width: 991.98px) {
    .cn-sticky {
        position: static;
    }
}
</style>
@endpush

@section('content')
@php
    $service = $order->servicePrice;
    $code = '#ORD-' . $order->created_at->format('Ymd') . '-' . str_pad($order->id, 3, '0', STR_PAD_LEFT);
    $statusLabels = ['pending' => 'Menunggu', 'in_progress' => 'Diproses'];
    $paid = $payment && $payment->status !== 'pending';
    $hasProof = $payment && $payment->status === 'pending' && $payment->proof_path;
    $payLabel = $payment ? $payment->methodLabel() : 'COD';
    $oldReason = old('cancel_reason');
@endphp

<div class="cn-wrap">
    <a href="{{ route('orders.show', $order) }}" class="cn-back"><i class="bi bi-arrow-left"></i>Kembali ke detail pesanan</a>
    <h3 class="cn-title"><i class="bi bi-x-octagon"></i>Batalkan Pesanan</h3>
    <p class="cn-sub">Pilih alasan pembatalan. Pesanan yang sudah dikirim tidak bisa dibatalkan.</p>

    <form action="{{ route('orders.cancel', $order) }}" method="POST" id="cancelForm">
        @csrf
        @method('PATCH')

        <div class="row g-3">
            {{-- Kiri: alasan --}}
            <div class="col-lg-8">
                <div class="cn-card">
                    <h5>Alasan Pembatalan <span style="color:#C0392B;">*</span></h5>
                    <p class="hint">Pilih salah satu alasan di bawah ini.</p>

                    <div class="cn-reasons" id="reasonList">
                        @foreach ($reasons as $reason)
                            <label class="cn-reason">
                                <input type="radio" name="cancel_reason" value="{{ $reason }}" {{ $oldReason === $reason ? 'checked' : '' }}>
                                <span class="cn-dot"></span>
                                <span class="t">{{ $reason }}</span>
                            </label>
                        @endforeach
                    </div>
                    @error('cancel_reason') <div class="cn-err"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div> @enderror
                </div>

                <div class="cn-warn">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    <div>
                        <strong>Sebelum membatalkan, perhatikan ya:</strong>
                        <ul>
                            <li>Pembatalan tidak dapat diurungkan.</li>
                            @if ($order->status === 'in_progress')
                                <li>Pesananmu sedang <b>diproses</b>. Kalau butuh perubahan kecil, lebih baik hubungi admin dulu.</li>
                            @endif
                            <li>Kalau mau pesan lagi, kamu bisa membuat pesanan baru kapan saja.</li>
                        </ul>
                    </div>
                </div>

                @if ($paid || $hasProof)
                    <div class="cn-warn refund mt-3">
                        <i class="bi bi-wallet2"></i>
                        <div>
                            <strong>Tentang pembayaranmu</strong>
                            <div class="mt-1">
                                @if ($paid)
                                    Pembayaran sebesar <b>Rp{{ number_format($payment->amount, 0, ',', '.') }}</b> sudah kami terima. Admin akan menghubungi kamu untuk proses pengembalian dana.
                                @else
                                    Kamu sudah mengunggah bukti pembayaran. Admin akan memeriksanya dan menghubungi kamu untuk pengembalian dana.
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            {{-- Kanan: ringkasan --}}
            <div class="col-lg-4">
                <div class="cn-sticky">
                    <div class="cn-card">
                        <h5 class="mb-3">Ringkasan Pesanan</h5>
                        <div class="cn-prod">
                            <div class="cn-thumb">
                                @if ($service?->image)
                                    <img src="{{ Storage::url($service->image) }}" alt="{{ $service->name }}">
                                @else
                                    <i class="bi bi-image"></i>
                                @endif
                            </div>
                            <div>
                                <h6>{{ $service?->name ?? 'Layanan dihapus' }}</h6>
                                <small>{{ $code }}</small>
                            </div>
                        </div>

                        <div class="cn-rows">
                            <div class="cn-row"><span>Status</span><span class="cn-badge {{ $order->status }}">{{ $statusLabels[$order->status] ?? $order->status }}</span></div>
                            <div class="cn-row"><span>Pembayaran</span><strong>{{ $payLabel }}</strong></div>
                            <div class="cn-row"><span>Tanggal pesan</span><strong>{{ $order->created_at->copy()->timezone('Asia/Jakarta')->locale('id')->translatedFormat('j M Y') }}</strong></div>
                            <div class="cn-row total"><span>Total</span><strong>Rp{{ number_format($order->total_price, 0, ',', '.') }}</strong></div>
                        </div>

                        <div class="cn-actions">
                            <button type="button" class="cn-btn danger" id="openConfirm" disabled><i class="bi bi-x-circle"></i>Batalkan Pesanan</button>
                            <a href="{{ route('orders.show', $order) }}" class="cn-btn ghost">Tidak Jadi</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Konfirmasi akhir --}}
        <dialog class="cn-dialog" id="confirmDialog">
            <div class="cn-dlg-body">
                <div class="cn-dlg-icon"><i class="bi bi-exclamation-lg"></i></div>
                <h5>Yakin batalkan pesanan?</h5>
                <p>Pesanan {{ $code }} akan dibatalkan dan tidak dapat diurungkan.</p>
                <div class="cn-dlg-reason" id="dlgReason"></div>
            </div>
            <div class="cn-dlg-actions">
                <button type="button" class="cn-btn ghost" id="closeConfirm">Kembali</button>
                <button type="submit" class="cn-btn danger">Ya, Batalkan</button>
            </div>
        </dialog>
    </form>
</div>

<script>
    (function () {
        var radios = document.querySelectorAll('input[name="cancel_reason"]');
        var openBtn = document.getElementById('openConfirm');
        var dialog = document.getElementById('confirmDialog');

        function selected() {
            var c = document.querySelector('input[name="cancel_reason"]:checked');
            return c ? c.value : null;
        }
        function sync() {
            openBtn.disabled = !selected();
        }

        radios.forEach(function (r) { r.addEventListener('change', sync); });
        sync();

        openBtn.addEventListener('click', function () {
            document.getElementById('dlgReason').textContent = 'Alasan: ' + selected();
            if (dialog.showModal) { dialog.showModal(); } else { document.getElementById('cancelForm').submit(); }
        });
        document.getElementById('closeConfirm').addEventListener('click', function () { dialog.close(); });
        dialog.addEventListener('click', function (e) { if (e.target === dialog) { dialog.close(); } });
    })();
</script>
@endsection