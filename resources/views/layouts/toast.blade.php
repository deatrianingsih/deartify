{{-- Notifikasi pop-up di pojok kanan atas (hilang otomatis). Dipakai lewat @include('layouts.toast') --}}
<style>
    .tt-stack { position: fixed; top: 88px; right: 20px; z-index: 2000; display: flex; flex-direction: column; gap: .7rem; width: min(380px, calc(100vw - 32px)); pointer-events: none; }
    .tt { pointer-events: auto; position: relative; overflow: hidden; display: flex; align-items: flex-start; gap: .8rem; background: #fff; border-radius: 14px; padding: .95rem 1rem .95rem .95rem; box-shadow: 0 12px 32px rgba(74, 59, 50, .22); border-left: 5px solid #2E7D4F; transform: translateX(120%); opacity: 0; transition: transform .35s cubic-bezier(.2, .9, .3, 1.1), opacity .3s; }
    .tt.show { transform: translateX(0); opacity: 1; }
    .tt.hide { transform: translateX(120%); opacity: 0; }
    .tt-ic { width: 34px; height: 34px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; flex-shrink: 0; background: #E3F2E8; color: #2E7D4F; }
    .tt-body { flex: 1; min-width: 0; }
    .tt-title { font-weight: 800; font-size: .93rem; color: #4A3B32; margin: 0 0 .1rem; }
    .tt-msg { font-size: .88rem; color: #6F6258; margin: 0; word-wrap: break-word; }
    .tt-x { border: 0; background: transparent; color: #A89B90; font-size: 1.1rem; line-height: 1; padding: .1rem; cursor: pointer; }
    .tt-x:hover { color: #4A3B32; }
    .tt-bar { position: absolute; left: 0; bottom: 0; height: 3px; width: 100%; background: #2E7D4F; transform-origin: left; animation: tt-shrink linear forwards; }
    .tt:hover .tt-bar { animation-play-state: paused; }
    @keyframes tt-shrink { from { transform: scaleX(1); } to { transform: scaleX(0); } }

    .tt.error { border-left-color: #B3402F; }
    .tt.error .tt-ic { background: #FBEAEA; color: #B3402F; }
    .tt.error .tt-bar { background: #B3402F; }
    .tt.info { border-left-color: #2F6597; }
    .tt.info .tt-ic { background: #DCEBFA; color: #2F6597; }
    .tt.info .tt-bar { background: #2F6597; }

    @media (max-width: 575.98px) { .tt-stack { top: 76px; right: 16px; } }
</style>

<div class="tt-stack" id="ttStack" aria-live="polite"></div>

<script>
    (function () {
        var stack = document.getElementById('ttStack');
        var icons = { success: 'bi-check-lg', error: 'bi-exclamation-lg', info: 'bi-info-lg' };
        var titles = { success: 'Berhasil', error: 'Gagal', info: 'Info' };

        window.toast = function (message, type, duration) {
            type = type || 'success';
            duration = duration || 4500;

            var el = document.createElement('div');
            el.className = 'tt ' + type;
            el.setAttribute('role', type === 'error' ? 'alert' : 'status');
            el.innerHTML =
                '<div class="tt-ic"><i class="bi ' + (icons[type] || icons.info) + '"></i></div>' +
                '<div class="tt-body"><p class="tt-title"></p><p class="tt-msg"></p></div>' +
                '<button type="button" class="tt-x" aria-label="Tutup">&times;</button>' +
                '<div class="tt-bar" style="animation-duration:' + duration + 'ms"></div>';
            el.querySelector('.tt-title').textContent = titles[type] || titles.info;
            el.querySelector('.tt-msg').textContent = message;
            stack.appendChild(el);

            requestAnimationFrame(function () { requestAnimationFrame(function () { el.classList.add('show'); }); });

            var timer;
            function close() {
                clearTimeout(timer);
                el.classList.remove('show');
                el.classList.add('hide');
                setTimeout(function () { el.remove(); }, 350);
            }
            function start(ms) { timer = setTimeout(close, ms); }

            el.querySelector('.tt-x').addEventListener('click', close);
            el.querySelector('.tt-bar').addEventListener('animationend', close);
        };

        @if (session('success'))
            window.toast(@json(session('success')), 'success');
        @endif
        @if (session('error'))
            window.toast(@json(session('error')), 'error', 6000);
        @endif
        @if (session('status'))
            window.toast(@json(session('status')), 'info');
        @endif
    })();
</script>