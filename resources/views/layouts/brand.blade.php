{{-- Tema DeArtify (coklat, sama dengan admin): dipakai welcome, login/register, dan area customer. --}}
<style>
    :root {
        --c-primary: #8B6F5B;
        --c-dark: #6B4F3F;
        --c-soft: #EDDECA;
        --c-tint: #F5EAD8;
        --c-mid: #C9AF9A;
        --c-text: #4A3B32;
        --c-bg: #FCF5EC;
        --c-line: #EFE3D3;
        --c-shadow: 0 2px 14px rgba(74, 59, 50, .08);
    }
    body { background-color: var(--c-bg); color: var(--c-text); }
    .font-hand { font-family: 'Caveat', cursive; }

    .brand { display: inline-flex; align-items: center; gap: .55rem; text-decoration: none; color: var(--c-dark); }
    .brand i { font-size: 1.9rem; color: var(--c-primary); line-height: 1; }
    .brand span { font-family: 'Caveat', cursive; font-size: 2.2rem; font-weight: 700; line-height: 1; }
    .brand:hover { color: var(--c-dark); }

    .btn-brand { background: var(--c-primary); color: #fff; border: 0; border-radius: 999px; padding: .6rem 1.4rem; font-weight: 700; transition: background .2s, transform .2s; }
    .btn-brand:hover { background: var(--c-dark); color: #fff; transform: translateY(-1px); }
    .btn-soft { background: var(--c-soft); color: var(--c-dark); border: 0; border-radius: 12px; padding: .5rem 1rem; font-weight: 700; transition: background .2s; }
    .btn-soft:hover { background: var(--c-mid); color: var(--c-dark); }
</style>