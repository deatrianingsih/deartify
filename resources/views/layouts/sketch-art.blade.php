{{-- Ilustrasi buku sketsa + kuas. Dipakai di welcome dan dashboard customer. --}}
<svg class="{{ $class ?? '' }}" viewBox="0 0 380 300" style="overflow: visible;" aria-hidden="true">
    <circle cx="110" cy="245" r="70" fill="#EDDECA" opacity=".7"/>
    <circle cx="330" cy="50" r="48" fill="#E8D6BE" opacity=".8"/>

    <g transform="rotate(-8 190 150)">
        <rect x="105" y="42" width="170" height="215" rx="12" fill="#F5EAD8" stroke="#6B4F3F" stroke-width="3"/>
        <rect x="115" y="34" width="170" height="215" rx="12" fill="#fff" stroke="#6B4F3F" stroke-width="3"/>
        @for ($i = 0; $i < 8; $i++)
            <rect x="104" y="{{ 52 + $i * 24 }}" width="24" height="8" rx="4" fill="#fff" stroke="#6B4F3F" stroke-width="2.5"/>
        @endfor
        <ellipse cx="205" cy="125" rx="36" ry="42" fill="#FBF5EC" stroke="#6B4F3F" stroke-width="2.5"/>
        <path d="M168 122 C164 78 246 74 242 122 C228 100 184 100 168 122 Z" fill="#D9C2A8" stroke="#6B4F3F" stroke-width="2.5" stroke-linejoin="round"/>
        <ellipse cx="192" cy="130" rx="4" ry="5.5" fill="#6B4F3F"/>
        <ellipse cx="218" cy="130" rx="4" ry="5.5" fill="#6B4F3F"/>
        <circle cx="184" cy="144" r="6" fill="#E8B4A0" opacity=".6"/>
        <circle cx="226" cy="144" r="6" fill="#E8B4A0" opacity=".6"/>
        <path d="M198 150 Q205 156 212 150" fill="none" stroke="#6B4F3F" stroke-width="2.5" stroke-linecap="round"/>
        <path d="M205 232 C190 220 186 208 196 203 C201 201 205 204 205 208 C205 204 209 201 214 203 C224 208 220 220 205 232 Z" fill="#fff" stroke="#6B4F3F" stroke-width="2.5" stroke-linejoin="round"/>
    </g>

    @foreach ([[292, 14, '#8B6F5B'], [310, 18, '#A98B73'], [328, 22, '#6B4F3F']] as [$bx, $deg, $color])
        <g transform="rotate({{ $deg }} {{ $bx }} 150)">
            <rect x="{{ $bx - 4.5 }}" y="40" width="9" height="140" rx="4.5" fill="{{ $color }}" stroke="#6B4F3F" stroke-width="2.5"/>
            <rect x="{{ $bx - 5.5 }}" y="180" width="11" height="20" rx="2" fill="#D9C2A8" stroke="#6B4F3F" stroke-width="2.5"/>
            <path d="M{{ $bx - 5 }} 200 Q{{ $bx }} 238 {{ $bx + 5 }} 200 Z" fill="#6B4F3F"/>
        </g>
    @endforeach

    @foreach ([[62, 120, 1], [38, 165, .6], [88, 228, .7], [352, 128, .7], [360, 208, .85], [205, 18, .7]] as [$x, $y, $scale])
        <path d="M0 -11 Q0 0 11 0 Q0 0 0 11 Q0 0 -11 0 Q0 0 0 -11 Z" transform="translate({{ $x }} {{ $y }}) scale({{ $scale }})" fill="#fff" stroke="#8B6F5B" stroke-width="2" stroke-linejoin="round"/>
    @endforeach
    <path d="M0 14 C-14 3 -17 -8 -8 -11 C-3 -13 0 -9 0 -6 C0 -9 3 -13 8 -11 C17 -8 14 3 0 14 Z" transform="translate(150 22) scale(.9)" fill="none" stroke="#8B6F5B" stroke-width="2.2" stroke-linejoin="round"/>
    <path d="M0 14 C-14 3 -17 -8 -8 -11 C-3 -13 0 -9 0 -6 C0 -9 3 -13 8 -11 C17 -8 14 3 0 14 Z" transform="translate(272 236) scale(.8)" fill="none" stroke="#8B6F5B" stroke-width="2.2" stroke-linejoin="round"/>
</svg>