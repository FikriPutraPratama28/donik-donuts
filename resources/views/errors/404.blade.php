<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>404 — Halaman Tidak Ditemukan | Donik Donuts</title>
<link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
html,body{height:100%;font-family:'Nunito',sans-serif;-webkit-font-smoothing:antialiased}

body {
    background: #f8f8fb;
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 100vh;
    overflow: hidden;
    position: relative;
}

/* ── Animated background blobs ── */
.bg-blob {
    position: fixed;
    border-radius: 50%;
    filter: blur(80px);
    opacity: .5;
    animation: blobFloat 8s ease-in-out infinite;
    pointer-events: none;
    z-index: 0;
}
.bb1 { width:500px;height:500px; background:rgba(85,110,230,.12); top:-100px;left:-100px; animation-delay:0s; }
.bb2 { width:400px;height:400px; background:rgba(244,114,182,.10); bottom:-80px;right:-80px; animation-delay:3s; }
.bb3 { width:300px;height:300px; background:rgba(251,191,36,.08); top:40%;left:60%; animation-delay:1.5s; }
@keyframes blobFloat {
    0%,100% { transform: translate(0,0) scale(1); }
    33%      { transform: translate(20px,-20px) scale(1.05); }
    66%      { transform: translate(-15px,15px) scale(.95); }
}

/* ── Main card ── */
.error-card {
    position: relative;
    z-index: 1;
    text-align: center;
    padding: 60px 40px 50px;
    max-width: 560px;
    width: 90%;
}

/* ── 404 number with donut O ── */
.num-wrap {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    margin-bottom: 32px;
    line-height: 1;
}
.num-4 {
    font-size: 140px;
    font-weight: 900;
    color: #2c2f3b;
    letter-spacing: -6px;
    animation: numBounce 2s ease-in-out infinite;
    display: inline-block;
}
.num-4:last-child { animation-delay: .3s; }
@keyframes numBounce {
    0%,100% { transform: translateY(0); }
    50%      { transform: translateY(-12px); }
}

/* ── Donut SVG animasi ── */
.donut-wrap {
    position: relative;
    width: 130px;
    height: 130px;
    flex-shrink: 0;
    animation: donutSpin 6s linear infinite;
}
@keyframes donutSpin {
    0%   { transform: rotate(0deg) scale(1); }
    25%  { transform: rotate(90deg) scale(1.08); }
    50%  { transform: rotate(180deg) scale(1); }
    75%  { transform: rotate(270deg) scale(1.08); }
    100% { transform: rotate(360deg) scale(1); }
}

/* Sprinkles yang berputar berlawanan */
.sprinkle-layer {
    position: absolute;
    inset: 0;
    animation: donutSpin 6s linear infinite reverse;
}

/* ── Plate / shadow bawah ── */
.plate {
    width: 100px;
    height: 14px;
    background: rgba(0,0,0,.08);
    border-radius: 50%;
    margin: -8px auto 28px;
    animation: platePulse 2s ease-in-out infinite;
}
@keyframes platePulse {
    0%,100% { transform: scaleX(1); opacity:.08; }
    50%      { transform: scaleX(.7); opacity:.04; }
}

/* ── Text ── */
.err-title {
    font-size: 26px;
    font-weight: 800;
    color: #2c2f3b;
    margin-bottom: 12px;
    animation: fadeInUp .6s ease both;
    animation-delay: .2s;
}
.err-sub {
    font-size: 15px;
    color: #74788d;
    line-height: 1.6;
    margin-bottom: 36px;
    max-width: 380px;
    margin-left: auto;
    margin-right: auto;
    animation: fadeInUp .6s ease both;
    animation-delay: .35s;
}

@keyframes fadeInUp {
    from { opacity:0; transform:translateY(16px); }
    to   { opacity:1; transform:translateY(0); }
}

/* ── Buttons ── */
.btn-row {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 12px;
    flex-wrap: wrap;
    animation: fadeInUp .6s ease both;
    animation-delay: .5s;
}
.btn-home {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 12px 28px;
    background: #556ee6;
    color: #fff;
    border: none;
    border-radius: 10px;
    font-size: 14px; font-weight: 700;
    font-family: inherit;
    text-decoration: none;
    cursor: pointer;
    transition: all .2s;
    box-shadow: 0 4px 16px rgba(85,110,230,.35);
}
.btn-home:hover {
    background: #4458c9;
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(85,110,230,.45);
    color: #fff;
}
.btn-back {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 12px 24px;
    background: #fff;
    color: #495057;
    border: 1.5px solid #eff2f7;
    border-radius: 10px;
    font-size: 14px; font-weight: 700;
    font-family: inherit;
    text-decoration: none;
    cursor: pointer;
    transition: all .2s;
    box-shadow: 0 2px 8px rgba(0,0,0,.04);
}
.btn-back:hover {
    background: #f8f8fb;
    border-color: #556ee6;
    color: #556ee6;
    transform: translateY(-2px);
}

/* ── Floating mini donuts dekorasi ── */
.mini-donut {
    position: fixed;
    border-radius: 50%;
    pointer-events: none;
    z-index: 0;
    opacity: 0;
    animation: floatUp 4s ease-in infinite;
}
@keyframes floatUp {
    0%   { opacity:0; transform: translateY(0) rotate(0deg) scale(.6); }
    15%  { opacity:.7; }
    85%  { opacity:.4; }
    100% { opacity:0; transform: translateY(-100vh) rotate(720deg) scale(1); }
}

/* ── Error code tag ── */
.err-code {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: #fff;
    border: 1.5px solid #eff2f7;
    border-radius: 8px;
    padding: 6px 14px;
    font-size: 12px;
    font-weight: 700;
    color: #74788d;
    margin-bottom: 20px;
    box-shadow: 0 2px 8px rgba(0,0,0,.04);
    animation: fadeInUp .6s ease both;
}
.err-code .dot {
    width: 7px; height: 7px;
    border-radius: 50%;
    background: #f46a6a;
    animation: dotPulse 1.5s ease-in-out infinite;
}
@keyframes dotPulse {
    0%,100% { opacity:1; transform:scale(1); }
    50%      { opacity:.4; transform:scale(.6); }
}

/* ── Responsive ── */
@media(max-width:480px){
    .num-4 { font-size: 100px; }
    .donut-wrap { width: 95px; height: 95px; }
    .err-title { font-size: 20px; }
    .err-sub { font-size: 13px; }
}
</style>
</head>
<body>

<!-- Background blobs -->
<div class="bg-blob bb1"></div>
<div class="bg-blob bb2"></div>
<div class="bg-blob bb3"></div>

<!-- Floating mini donuts (generated by JS) -->
<div id="floatingDonuts"></div>

<!-- Main content -->
<div class="error-card">

    <!-- Error code tag -->
    <div class="err-code">
        <span class="dot"></span>
        Error 404 — Not Found
    </div>

    <!-- 404 + Donut -->
    <div class="num-wrap">
        <span class="num-4">4</span>

        <!-- Donut SVG berputar -->
        <div class="donut-wrap">
            <svg width="130" height="130" viewBox="0 0 130 130" fill="none" xmlns="http://www.w3.org/2000/svg">
                <!-- Donut body kuning -->
                <circle cx="65" cy="65" r="52" fill="#f5c518"/>
                <!-- Glaze pink -->
                <ellipse cx="65" cy="59" rx="48" ry="38" fill="#f472b6"/>
                <!-- Glaze highlight -->
                <ellipse cx="52" cy="52" rx="16" ry="8" fill="rgba(255,255,255,0.35)" transform="rotate(-25 52 52)"/>
                <!-- Donut hole -->
                <circle cx="65" cy="65" r="22" fill="#f8f8fb"/>
                <!-- Inner shadow hole -->
                <circle cx="65" cy="65" r="22" fill="none" stroke="rgba(0,0,0,0.08)" stroke-width="3"/>
                <!-- Dots pada glaze -->
                <circle cx="52" cy="60" r="3" fill="rgba(139,0,60,0.5)"/>
                <circle cx="65" cy="54" r="2.5" fill="rgba(139,0,60,0.4)"/>
                <circle cx="78" cy="62" r="2" fill="rgba(139,0,60,0.35)"/>
                <circle cx="72" cy="72" r="1.8" fill="rgba(139,0,60,0.3)"/>
            </svg>
            <!-- Sprinkles layer berputar berlawanan -->
            <svg class="sprinkle-layer" width="130" height="130" viewBox="0 0 130 130" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect x="34" y="28" width="14" height="5" rx="2.5" fill="#22c55e"  transform="rotate(-35 34 28)"/>
                <rect x="84" y="24" width="14" height="5" rx="2.5" fill="#3b82f6"  transform="rotate(22 84 24)"/>
                <rect x="104" y="58" width="14" height="5" rx="2.5" fill="#fbbf24" transform="rotate(-8 104 58)"/>
                <rect x="90"  y="98" width="14" height="5" rx="2.5" fill="#a855f7" transform="rotate(40 90 98)"/>
                <rect x="36"  y="100" width="14" height="5" rx="2.5" fill="#ef4444" transform="rotate(-22 36 100)"/>
                <rect x="18"  y="62" width="14" height="5" rx="2.5" fill="#ec4899" transform="rotate(12 18 62)"/>
                <rect x="55"  y="16" width="10" height="4" rx="2"   fill="#f97316" transform="rotate(18 55 16)"/>
                <rect x="96"  y="94" width="10" height="4" rx="2"   fill="#6ee7b7" transform="rotate(-28 96 94)"/>
            </svg>
        </div>

        <span class="num-4">4</span>
    </div>

    <!-- Shadow/plate -->
    <div class="plate"></div>

    <!-- Text -->
    <div class="err-title">Halaman Tidak Ditemukan!</div>
    <div class="err-sub">
        Sepertinya donut yang kamu cari sudah habis 🍩<br>
        Halaman ini tidak ada atau sudah dipindahkan.
    </div>

    <!-- Buttons -->
    <div class="btn-row">
        @auth
        <a href="{{ route('dashboard') }}" class="btn-home">
            <i class="bi bi-house-fill"></i>
            Kembali ke Dashboard
        </a>
        @else
        <a href="{{ route('login') }}" class="btn-home">
            <i class="bi bi-house-fill"></i>
            Ke Halaman Login
        </a>
        @endauth
        <a href="javascript:history.back()" class="btn-back">
            <i class="bi bi-arrow-left"></i>
            Kembali
        </a>
    </div>

</div>

<script>
// Generate floating mini donuts
(function() {
    var container = document.getElementById('floatingDonuts');
    var colors    = ['#f472b6','#f5c518','#556ee6','#34c38f','#f97316','#a855f7'];
    var sizes     = [20, 28, 22, 18, 24, 16];

    for (var i = 0; i < 12; i++) {
        var d    = document.createElement('div');
        var size = sizes[i % sizes.length];
        var col  = colors[i % colors.length];
        var left = Math.random() * 100;
        var delay = Math.random() * 6;
        var dur   = 4 + Math.random() * 4;

        d.className = 'mini-donut';
        d.style.cssText = [
            'left:' + left + 'vw',
            'bottom:-60px',
            'width:' + size + 'px',
            'height:' + size + 'px',
            'background:' + col,
            'animation-delay:' + delay + 's',
            'animation-duration:' + dur + 's',
            'box-shadow:inset 0 0 0 ' + Math.round(size*0.28) + 'px rgba(255,255,255,0.6)',
        ].join(';');
        container.appendChild(d);
    }
})();
</script>
</body>
</html>
