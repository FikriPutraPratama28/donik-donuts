<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login — Donik Donuts</title>
<link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
<link rel="shortcut icon" href="{{ asset('favicon.svg') }}">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,400&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<style>
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
html, body { height: 100%; font-family: 'Plus Jakarta Sans', sans-serif; -webkit-font-smoothing: antialiased; }

/* ══════════════════════════════════
   WRAPPER FULL SCREEN
══════════════════════════════════ */
.wrap {
    display: flex;
    height: 100vh;
    overflow: hidden;
    position: relative;
    background: #fdf0e8;
}

/* ══════════════════════════════════
   PANEL KIRI — video background
══════════════════════════════════ */
.panel-left {
    flex: 1;
    position: relative;
    overflow: hidden;
    background: linear-gradient(135deg, #3d1a0e 0%, #6b2d0f 50%, #3d1a0e 100%);
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    padding: 44px 52px 40px;
}

/* Video background */
.panel-left .bg-video {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    z-index: 0;
    opacity: .55;
    pointer-events: none;
}

/* Overlay gelap di atas video agar teks tetap terbaca */
.panel-left .video-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(
        135deg,
        rgba(61,26,14,.75) 0%,
        rgba(80,35,10,.55) 40%,
        rgba(30,10,4,.80) 100%
    );
    z-index: 1;
    pointer-events: none;
}

/* Blob dekorasi latar */
.blob { position: absolute; border-radius: 50%; filter: blur(55px); pointer-events: none; z-index: 2; }
.blob-a { width: 500px; height: 500px; background: rgba(244,114,182,.18); top: -120px; left: -80px; }
.blob-b { width: 380px; height: 380px; background: rgba(251,191,36,.14); bottom: -60px; right: 60px; }
.blob-c { width: 250px; height: 250px; background: rgba(239,68,68,.08); top: 30%; right: -40px; }

/* ── Gelombang pink pojok kiri bawah & kanan bawah ── */
.wave-bl {
    position: absolute;
    bottom: -10px; left: -10px;
    width: 240px; height: 180px;
    background: #f9a8d4;
    border-radius: 0 60% 0 0;
    opacity: .35;
    z-index: 2;
}
.wave-tr {
    position: absolute;
    top: -10px; right: -10px;
    width: 160px; height: 140px;
    background: #f9a8d4;
    border-radius: 0 0 60% 0;
    opacity: .3;
    z-index: 2;
}

/* ── Ilustrasi donut melayang (SVG) ── */
.donut-float {
    position: absolute;
    pointer-events: none;
    z-index: 3;
}
.df-main  { width: 390px; height: 390px; bottom: -30px; left: 50%; transform: translateX(-60%); filter: drop-shadow(0 24px 48px rgba(0,0,0,.18)); }
.df-top   { width: 120px; height: 120px; top: 10px;   right: 40px; transform: rotate(18deg);  filter: drop-shadow(0 8px 18px rgba(0,0,0,.15)); }
.df-left  { width: 90px;  height: 90px;  top: 38%;  left: 12px;  transform: rotate(-12deg); filter: drop-shadow(0 6px 14px rgba(0,0,0,.14)); }

/* ── ANIMASI FLOATING DONUT (gambar ke-2) ── */
/* Donut utama naik-turun smooth */
.df-main {
    animation: donutFloat 3.5s ease-in-out infinite;
    transform-origin: center bottom;
}
/* Shadow di bawah donut mengecil saat naik */
.df-main-shadow {
    position: absolute;
    bottom: 28px;
    left: 50%;
    transform: translateX(-60%);
    width: 200px;
    height: 24px;
    background: radial-gradient(ellipse, rgba(0,0,0,.18) 0%, transparent 70%);
    border-radius: 50%;
    z-index: 0;
    pointer-events: none;
    animation: shadowFloat 3.5s ease-in-out infinite;
}
@keyframes donutFloat {
    0%,100% { transform: translateX(-60%) translateY(0px);   filter: drop-shadow(0 28px 50px rgba(0,0,0,.20)); }
    50%      { transform: translateX(-60%) translateY(-28px); filter: drop-shadow(0 48px 60px rgba(0,0,0,.10)); }
}
@keyframes shadowFloat {
    0%,100% { transform: translateX(-50%) scaleX(1);    opacity: .18; }
    50%      { transform: translateX(-50%) scaleX(.55); opacity: .07; }
}
/* Donut kecil kanan atas: rotasi pelan + float */
.df-top {
    animation: donutTopFloat 4.2s ease-in-out infinite, donutTopSpin 8s linear infinite;
}
@keyframes donutTopFloat {
    0%,100% { top: 10px; }
    50%      { top: 28px; }
}
@keyframes donutTopSpin {
    from { transform: rotate(18deg); }
    to   { transform: rotate(378deg); }
}
/* Donut kecil kiri: oscillate */
.df-left {
    animation: donutLeftFloat 5s ease-in-out infinite;
}
@keyframes donutLeftFloat {
    0%,100% { top: 38%; transform: rotate(-12deg); }
    50%      { top: 42%; transform: rotate(8deg); }
}

/* ── Confetti / percikan ── */
.confetti { position: absolute; pointer-events: none; z-index: 4; }
.c1 { top: 18%; left: 28%; }
.c2 { top: 8%;  right: 22%; }
.c3 { bottom: 30%; left: 5%; }

/* Brand pojok kiri atas */
.brand-row {
    position: relative;
    z-index: 5;
    display: flex;
    align-items: center;
    gap: 14px;
}
.brand-logo-wrap {
    width: 60px; height: 60px;
    border-radius: 50%;
    overflow: hidden;
    border: 3px solid rgba(255,255,255,.6);
    box-shadow: 0 4px 16px rgba(0,0,0,.14);
    flex-shrink: 0;
    background: #fff;
    display: flex; align-items: center; justify-content: center;
}
.brand-logo-wrap img,
.brand-logo-wrap svg { width: 100%; height: 100%; object-fit: cover; border-radius: 50%; }
.brand-txt { line-height: 1.15; }
.brand-name { font-size: 22px; font-weight: 900; color: #4a1c0a; letter-spacing: -.4px; }
.brand-tagline { font-size: 10px; font-weight: 600; color: #92400e; letter-spacing: 1.2px; text-transform: uppercase; opacity: .75; }

/* ══════════════════════════════════
   LOGO TEKS — DONIK / DO•NUTS
   Gambar ke-1: background pink, teks bold oranye/pink
   Gambar ke-2: animasi glitch layer geser
══════════════════════════════════ */
.brand-logo-text {
    line-height: 1;
    position: relative;
    display: inline-block;
}

/* ── Teks utama ── */
.brand-logo-text .txt-donik {
    display: block;
    font-size: 28px;
    font-weight: 900;
    letter-spacing: 3px;
    color: #f97316;               /* oranye */
    line-height: 1.15;
    position: relative;
    text-transform: uppercase;
    overflow: visible;
}
.brand-logo-text .txt-donuts {
    display: block;
    font-size: 28px;
    font-weight: 900;
    letter-spacing: 3px;
    color: #db2777;               /* pink magenta */
    line-height: 1.15;
    position: relative;
    text-transform: uppercase;
    overflow: visible;
}

/* ── Pseudo-elements untuk efek glitch geser ── */
.brand-logo-text .txt-donik::before,
.brand-logo-text .txt-donik::after,
.brand-logo-text .txt-donuts::before,
.brand-logo-text .txt-donuts::after {
    content: attr(data-text);
    position: absolute;
    top: 0; left: 0;
    width: 100%; height: 100%;
    font-size: inherit;
    font-weight: inherit;
    letter-spacing: inherit;
    text-transform: inherit;
    pointer-events: none;
}

/* DONIK — cyan layer atas */
.brand-logo-text .txt-donik::before {
    color: #fb923c;
    clip-path: polygon(0 0, 100% 0, 100% 45%, 0 45%);
    animation: glitch-top 2.5s infinite steps(1);
}
/* DONIK — merah layer bawah */
.brand-logo-text .txt-donik::after {
    color: #f43f5e;
    clip-path: polygon(0 55%, 100% 55%, 100% 100%, 0 100%);
    animation: glitch-bot 2.5s infinite steps(1);
}

/* DONUTS — pink layer atas */
.brand-logo-text .txt-donuts::before {
    color: #f472b6;
    clip-path: polygon(0 0, 100% 0, 100% 45%, 0 45%);
    animation: glitch-top 2.5s .18s infinite steps(1);
}
/* DONUTS — oranye layer bawah */
.brand-logo-text .txt-donuts::after {
    color: #fb923c;
    clip-path: polygon(0 55%, 100% 55%, 100% 100%, 0 100%);
    animation: glitch-bot 2.5s .18s infinite steps(1);
}

/* ── Keyframes glitch ── */
/* Layer atas bergeser ke kiri-kanan secara tiba-tiba */
@keyframes glitch-top {
    0%,78%,100% { transform: translate(0,0);      opacity: 0; }
    80%          { transform: translate(-5px,-2px); opacity: 1; }
    82%          { transform: translate(5px, 2px);  opacity: 1; }
    84%          { transform: translate(-3px, 0);   opacity: 1; }
    86%          { transform: translate(0,0);        opacity: 0; }
    90%          { transform: translate(-6px,-1px); opacity: 1; }
    92%          { transform: translate(4px, 1px);  opacity: 1; }
    94%          { transform: translate(0,0);        opacity: 0; }
}
/* Layer bawah bergeser berlawanan */
@keyframes glitch-bot {
    0%,78%,100% { transform: translate(0,0);      opacity: 0; }
    80%          { transform: translate(5px, 2px);  opacity: 1; }
    82%          { transform: translate(-5px,-2px); opacity: 1; }
    84%          { transform: translate(3px, 0);    opacity: 1; }
    86%          { transform: translate(0,0);        opacity: 0; }
    90%          { transform: translate(6px, 1px);  opacity: 1; }
    92%          { transform: translate(-4px,-1px); opacity: 1; }
    94%          { transform: translate(0,0);        opacity: 0; }
}

/* Konten tengah-bawah kiri */
.left-content {
    position: relative;
    z-index: 5;
}
.left-heading {
    font-size: 44px;
    font-weight: 900;
    color: #3d1505;
    line-height: 1.12;
    letter-spacing: -.8px;
    margin-bottom: 14px;
}
.left-heading span { color: #ec4899; }
.left-sub {
    font-size: 15px;
    color: #7c3614;
    opacity: .75;
    line-height: 1.6;
    max-width: 340px;
    margin-bottom: 36px;
}

/* Feature pills bawah */
.feat-row {
    display: flex;
    gap: 0;
    border-top: 1px solid rgba(255,255,255,.45);
    padding-top: 20px;
}
.feat-item {
    display: flex;
    align-items: center;
    gap: 10px;
    padding-right: 28px;
    margin-right: 28px;
    border-right: 1px solid rgba(255,255,255,.4);
}
.feat-item:last-child { border-right: none; padding-right: 0; margin-right: 0; }
.feat-ico {
    width: 36px; height: 36px;
    background: rgba(255,255,255,.45);
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    font-size: 17px;
    color: #92400e;
    flex-shrink: 0;
}
.feat-txt { font-size: 12px; font-weight: 700; color: #4a1c0a; line-height: 1.3; }
.feat-sub { font-size: 10px; color: #92400e; opacity: .8; margin-top: 1px; }

/* ══════════════════════════════════
   PANEL KANAN — card form
══════════════════════════════════ */
.panel-right {
    width: 420px;
    flex-shrink: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 32px 24px;
    position: relative;
    background: transparent;
    z-index: 10;
}

/* Donut dekorasi pojok kanan */
.deco-rt {
    position: absolute;
    top: -20px; right: -20px;
    width: 130px; height: 130px;
    pointer-events: none;
    z-index: 0;
    transform: rotate(15deg);
    filter: drop-shadow(0 6px 16px rgba(0,0,0,.14));
}
.deco-rb {
    position: absolute;
    bottom: 40px; right: -10px;
    width: 70px; height: 70px;
    pointer-events: none;
    z-index: 0;
    transform: rotate(-10deg);
    filter: drop-shadow(0 4px 10px rgba(0,0,0,.12));
}

/* Card putih */
.form-card {
    width: 100%;
    max-width: 360px;
    background: #fff;
    border-radius: 28px;
    padding: 40px 36px 36px;
    box-shadow: 0 24px 70px rgba(61,21,5,.16), 0 6px 20px rgba(0,0,0,.07);
    position: relative;
    z-index: 1;
}

/* Logo dalam card */
.card-logo {
    display: flex;
    flex-direction: column;
    align-items: center;
    margin-bottom: 24px;
    gap: 0;
}
.card-logo-wrap {
    width: 72px; height: 72px;
    border-radius: 50%;
    overflow: hidden;
    border: 3px solid #fce7f3;
    box-shadow: 0 4px 20px rgba(244,114,182,.28);
    background: #fff;
    display: flex; align-items: center; justify-content: center;
    margin-bottom: 12px;
}
.card-logo-wrap img,
.card-logo-wrap svg { width: 100%; height: 100%; object-fit: cover; border-radius: 50%; }
.card-brand { font-size: 22px; font-weight: 900; color: #3d1505; letter-spacing: -.4px; line-height: 1; }
.card-heading { font-size: 18px; font-weight: 800; color: #1c1c1e; margin-top: 16px; margin-bottom: 4px; letter-spacing: -.2px; }
.card-sub { font-size: 13px; color: #9ca3af; text-align: center; }

/* Divider */
.card-divider { height: 1px; background: #f3f4f6; margin: 20px 0; }

/* Fields */
.field { margin-bottom: 14px; }
.inp-wrap { position: relative; display: flex; align-items: center; }
.inp-wrap .ico {
    position: absolute; left: 14px;
    color: #d1d5db; font-size: 15px; pointer-events: none; z-index: 1;
}
.inp-wrap input {
    width: 100%; height: 50px;
    padding: 0 14px 0 42px;
    border: 1.5px solid #f3f4f6;
    border-radius: 12px;
    font-size: 14px; font-family: inherit;
    color: #111827; background: #fafafa;
    outline: none; transition: all .2s;
}
.inp-wrap input::placeholder { color: #c4c4c4; }
.inp-wrap input:focus {
    border-color: #ec4899;
    background: #fff;
    box-shadow: 0 0 0 4px rgba(236,72,153,.1);
}
.eye-btn {
    position: absolute; right: 12px;
    background: none; border: none; cursor: pointer;
    color: #d1d5db; font-size: 15px; padding: 4px; line-height: 1;
    transition: color .15s;
}
.eye-btn:hover { color: #ec4899; }

/* Remember + lupa */
.remember-row {
    display: flex; align-items: center; justify-content: space-between;
    margin-bottom: 20px; margin-top: 6px;
}
.remember-left { display: flex; align-items: center; gap: 7px; }
.remember-left input[type="checkbox"] { width: 15px; height: 15px; accent-color: #ec4899; cursor: pointer; }
.remember-left label { font-size: 13px; color: #6b7280; cursor: pointer; }
.forgot-link { font-size: 13px; font-weight: 600; color: #ec4899; text-decoration: none; }
.forgot-link:hover { text-decoration: underline; }

/* Tombol masuk */
.btn-login {
    width: 100%; height: 52px;
    background: linear-gradient(135deg, #f472b6 0%, #ec4899 50%, #db2777 100%);
    color: #fff; border: none; border-radius: 14px;
    font-size: 16px; font-weight: 700; font-family: inherit;
    cursor: pointer; transition: all .2s;
    display: flex; align-items: center; justify-content: center; gap: 9px;
    letter-spacing: .2px;
    box-shadow: 0 6px 24px rgba(236,72,153,.38);
}
.btn-login:hover {
    background: linear-gradient(135deg, #ec4899 0%, #db2777 50%, #be185d 100%);
    box-shadow: 0 10px 32px rgba(236,72,153,.5);
    transform: translateY(-1px);
}
.btn-login:active { transform: translateY(0) scale(.98); }

/* Error */
.err-box {
    background: #fef2f2; border: 1px solid #fecaca;
    border-radius: 10px; padding: 10px 14px;
    font-size: 13px; color: #dc2626;
    margin-bottom: 16px;
    display: flex; align-items: center; gap: 8px;
}

/* Footer */
.footer-note { margin-top: 20px; text-align: center; font-size: 11px; color: #d1d5db; }

/* ══════════════════════════════════
   RESPONSIVE
══════════════════════════════════ */
@media (max-width: 960px) {
    .panel-left { padding: 36px; }
    .left-heading { font-size: 36px; }
    .panel-right { width: 380px; }
}
@media (max-width: 768px) {
    .wrap { flex-direction: column; overflow-y: auto; height: auto; min-height: 100vh; }
    .panel-left { min-height: 300px; padding: 32px 28px 200px; }
    .left-heading { font-size: 30px; }
    .left-sub { font-size: 13px; }
    .feat-row { flex-wrap: wrap; gap: 12px; }
    .feat-item { border-right: none; padding-right: 0; margin-right: 0; }
    .panel-right { width: 100%; padding: 0 16px 40px; margin-top: -80px; }
    .form-card { max-width: 100%; }
    .deco-rt, .deco-rb { display: none; }
}
@media (max-width: 400px) {
    .form-card { padding: 30px 20px; border-radius: 20px; }
    .btn-login { height: 48px; font-size: 15px; }
}
</style>
</head>
<body>
<div class="wrap">

    {{-- ══════════ PANEL KIRI ══════════ --}}
    <div class="panel-left">

        {{-- ▶ VIDEO BACKGROUND — taruh file video di public/videos/bg.mp4 --}}
        @if(file_exists(public_path('videos/bg.mp4')))
        <video class="bg-video" autoplay muted loop playsinline>
            <source src="{{ asset('videos/bg.mp4') }}" type="video/mp4">
        </video>
        @endif
        {{-- Overlay gelap di atas video --}}
        <div class="video-overlay"></div>

        {{-- Background blobs --}}
        <div class="blob blob-a"></div>
        <div class="blob blob-b"></div>
        <div class="blob blob-c"></div>

        {{-- Gelombang dekorasi --}}
        <div class="wave-bl"></div>
        <div class="wave-tr"></div>

        {{-- Confetti SVG --}}
        <svg class="confetti c1" width="32" height="32" viewBox="0 0 32 32">
            <rect x="4"  y="14" width="10" height="4" rx="2" fill="#f472b6" transform="rotate(-30 4 14)"/>
            <rect x="18" y="6"  width="10" height="4" rx="2" fill="#fbbf24" transform="rotate(20 18 6)"/>
            <circle cx="26" cy="24" r="3" fill="#6ee7b7"/>
        </svg>
        <svg class="confetti c2" width="28" height="28" viewBox="0 0 28 28">
            <rect x="2"  y="12" width="9" height="3" rx="1.5" fill="#fbbf24" transform="rotate(25 2 12)"/>
            <rect x="15" y="4"  width="9" height="3" rx="1.5" fill="#f472b6" transform="rotate(-15 15 4)"/>
            <circle cx="24" cy="22" r="2.5" fill="#a78bfa"/>
        </svg>
        <svg class="confetti c3" width="24" height="24" viewBox="0 0 24 24">
            <rect x="2" y="10" width="8" height="3" rx="1.5" fill="#34d399" transform="rotate(-20 2 10)"/>
            <circle cx="18" cy="6" r="2" fill="#f97316"/>
        </svg>

        {{-- Shadow donut utama (mengecil saat donut naik) --}}
        <div class="df-main-shadow"></div>

        {{-- Donut ilustrasi utama (besar, di bawah tengah) --}}
        <svg class="donut-float df-main" viewBox="0 0 400 400" fill="none" xmlns="http://www.w3.org/2000/svg">
            <!-- Donut 1 — pink (tengah depan) -->
            <ellipse cx="200" cy="230" rx="130" ry="110" fill="#f5c518"/>
            <ellipse cx="200" cy="215" rx="125" ry="95"  fill="#f472b6"/>
            <ellipse cx="200" cy="208" rx="105" ry="78"  fill="#fb7185"/>
            <circle  cx="200" cy="225" r="50"             fill="#3d1a0e"/>
            <circle  cx="200" cy="225" r="44"             fill="#2d0e06"/>
            <!-- Glaze highlight -->
            <ellipse cx="175" cy="195" rx="18" ry="10" fill="rgba(255,255,255,.3)" transform="rotate(-20 175 195)"/>
            <!-- Sprinkles pink -->
            <rect x="145" y="175" width="18" height="6" rx="3" fill="#22c55e"  transform="rotate(-35 145 175)"/>
            <rect x="230" y="168" width="18" height="6" rx="3" fill="#3b82f6"  transform="rotate(22 230 168)"/>
            <rect x="268" y="202" width="18" height="6" rx="3" fill="#fbbf24"  transform="rotate(-8 268 202)"/>
            <rect x="245" y="255" width="18" height="6" rx="3" fill="#a855f7"  transform="rotate(38 245 255)"/>
            <rect x="150" y="262" width="18" height="6" rx="3" fill="#ef4444"  transform="rotate(-22 150 262)"/>
            <rect x="122" y="218" width="18" height="6" rx="3" fill="#ec4899"  transform="rotate(12 122 218)"/>
            <rect x="180" y="160" width="14" height="5" rx="2.5" fill="#fbbf24" transform="rotate(15 180 160)"/>
            <rect x="218" y="270" width="14" height="5" rx="2.5" fill="#6ee7b7" transform="rotate(-28 218 270)"/>
            <!-- Donut 2 — coklat (kiri belakang) -->
            <ellipse cx="100" cy="300" rx="95"  ry="80"  fill="#92400e"/>
            <ellipse cx="100" cy="288" rx="90"  ry="70"  fill="#b45309"/>
            <ellipse cx="100" cy="282" rx="75"  ry="57"  fill="#d97706"/>
            <circle  cx="100" cy="296" r="36"             fill="#1a0a00"/>
            <ellipse cx="84"  cy="272" rx="13"  ry="7"   fill="rgba(255,255,255,.2)" transform="rotate(-18 84 272)"/>
            <rect x="60"  y="262" width="14" height="5" rx="2.5" fill="#f472b6" transform="rotate(-28 60 262)"/>
            <rect x="128" y="256" width="14" height="5" rx="2.5" fill="#22c55e" transform="rotate(18 128 256)"/>
            <!-- Gelas kopi kanan -->
            <rect x="290" y="200" width="60" height="90" rx="8" fill="#e8d5c0"/>
            <rect x="288" y="195" width="64" height="16" rx="6" fill="#6b3a2a"/>
            <rect x="294" y="211" width="52" height="79" rx="6" fill="#f0e0cc"/>
            <ellipse cx="320" cy="290" rx="30" ry="8" fill="#d4b896"/>
            <text x="302" y="252" font-family="Arial Black,sans-serif" font-weight="900" font-size="9" fill="#6b3a2a" text-anchor="middle">Donik</text>
            <text x="302" y="263" font-family="Arial Black,sans-serif" font-weight="900" font-size="8" fill="#6b3a2a" text-anchor="middle">Donuts</text>
        </svg>

        {{-- Donut kecil pojok kanan atas --}}
        <svg class="donut-float df-top" viewBox="0 0 120 120" fill="none" xmlns="http://www.w3.org/2000/svg">
            <ellipse cx="60" cy="64" rx="50" ry="43" fill="#fbbf24"/>
            <ellipse cx="60" cy="58" rx="46" ry="36" fill="#f472b6"/>
            <circle  cx="60" cy="64" r="19" fill="#3d1a0e"/>
            <rect x="32" y="40" width="12" height="4" rx="2" fill="#22c55e" transform="rotate(-28 32 40)"/>
            <rect x="74" y="36" width="12" height="4" rx="2" fill="#3b82f6" transform="rotate(20 74 36)"/>
            <rect x="86" y="60" width="12" height="4" rx="2" fill="#fbbf24" transform="rotate(-10 86 60)"/>
        </svg>

        {{-- Donut kecil pojok kiri tengah --}}
        <svg class="donut-float df-left" viewBox="0 0 90 90" fill="none" xmlns="http://www.w3.org/2000/svg">
            <ellipse cx="45" cy="48" rx="38" ry="32" fill="#1a1a1a"/>
            <ellipse cx="45" cy="44" rx="34" ry="26" fill="#f472b6"/>
            <ellipse cx="45" cy="42" rx="27" ry="20" fill="#fb7185"/>
            <circle  cx="45" cy="48" r="14" fill="#111"/>
            <rect x="24" y="30" width="9" height="3" rx="1.5" fill="#fbbf24" transform="rotate(-22 24 30)"/>
            <rect x="56" y="28" width="9" height="3" rx="1.5" fill="#6ee7b7" transform="rotate(18 56 28)"/>
        </svg>

        {{-- Brand row kiri atas — logo teks DONIK/DONUTS gaya gambar ke-1 --}}
        <div class="brand-row">
            {{-- Logo bulat --}}
            <div class="brand-logo-wrap">
                @if(file_exists(public_path('images/logo.png')))
                    <img src="{{ asset('images/logo.png') }}" alt="Donik Donuts">
                @else
                    <svg viewBox="0 0 110 110" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="55" cy="55" r="55" fill="#1a1a1a"/>
                        <circle cx="55" cy="55" r="49" fill="none" stroke="#fff" stroke-width="2"/>
                        <circle cx="55" cy="42" r="20" fill="#f5c518"/>
                        <ellipse cx="55" cy="39" rx="16" ry="12" fill="#f472b6"/>
                        <circle cx="55" cy="42" r="7" fill="#1a1a1a"/>
                        <rect x="42" y="30" width="5" height="2" rx="1" fill="#22c55e" transform="rotate(-30 42 30)"/>
                        <rect x="63" y="28" width="5" height="2" rx="1" fill="#3b82f6" transform="rotate(20 63 28)"/>
                        <rect x="68" y="40" width="5" height="2" rx="1" fill="#f59e0b" transform="rotate(-10 68 40)"/>
                        <rect x="60" y="52" width="5" height="2" rx="1" fill="#a855f7" transform="rotate(40 60 52)"/>
                        <rect x="42" y="53" width="5" height="2" rx="1" fill="#ef4444" transform="rotate(-20 42 53)"/>
                        <rect x="36" y="40" width="5" height="2" rx="1" fill="#ec4899" transform="rotate(10 36 40)"/>
                        <text x="55" y="76" text-anchor="middle" font-family="Arial Black,sans-serif" font-weight="900" font-size="7" fill="#f472b6">DONIK</text>
                    </svg>
                @endif
            </div>
            {{-- Teks dua baris oranye/pink dengan animasi glitch --}}
            <div class="brand-logo-text">
                <span class="txt-donik"  data-text="DONIK">DONIK</span>
                <span class="txt-donuts" data-text="DO&#9679;NUTS">DO<span style="font-style:italic">&#9679;</span>NUTS</span>
            </div>
        </div>

        {{-- Konten teks --}}
        <div class="left-content">
            <div class="left-heading">
                Selamat Datang<br>di <span>POS Donik Donuts</span>
            </div>
            <div class="left-sub">
                Masuk untuk melanjutkan<br>ke sistem Point of Sale kami
            </div>

            {{-- Feature bar bawah --}}
            <div class="feat-row">
                <div class="feat-item">
                    <div class="feat-ico"><i class="bi bi-shop"></i></div>
                    <div>
                        <div class="feat-txt">Transaksi<br>Lebih Cepat</div>
                    </div>
                </div>
                <div class="feat-item">
                    <div class="feat-ico"><i class="bi bi-bar-chart-fill"></i></div>
                    <div>
                        <div class="feat-txt">Laporan<br>Real-Time</div>
                    </div>
                </div>
                <div class="feat-item">
                    <div class="feat-ico"><i class="bi bi-shield-check"></i></div>
                    <div>
                        <div class="feat-txt">Kelola<br>Stok Mudah</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ══════════ PANEL KANAN — Card Form ══════════ --}}
    <div class="panel-right">

        {{-- Donut dekorasi pojok kanan atas --}}
        <svg class="deco-rt" viewBox="0 0 130 130" fill="none" xmlns="http://www.w3.org/2000/svg">
            <ellipse cx="65" cy="70" rx="55" ry="48" fill="#fbbf24"/>
            <ellipse cx="65" cy="63" rx="51" ry="40" fill="#f472b6"/>
            <circle  cx="65" cy="70" r="21" fill="#3d1a0e"/>
            <rect x="36" y="45" width="14" height="5" rx="2.5" fill="#22c55e" transform="rotate(-28 36 45)"/>
            <rect x="82" y="40" width="14" height="5" rx="2.5" fill="#3b82f6" transform="rotate(22 82 40)"/>
            <rect x="96" y="68" width="14" height="5" rx="2.5" fill="#fbbf24" transform="rotate(-10 96 68)"/>
        </svg>

        {{-- Donut kecil pojok kanan bawah --}}
        <svg class="deco-rb" viewBox="0 0 70 70" fill="none" xmlns="http://www.w3.org/2000/svg">
            <ellipse cx="35" cy="38" rx="30" ry="26" fill="#92400e"/>
            <ellipse cx="35" cy="34" rx="26" ry="20" fill="#d97706"/>
            <circle  cx="35" cy="38" r="11" fill="#1a0a00"/>
        </svg>

        <div class="form-card">

            {{-- Logo card --}}
            <div class="card-logo">
                <div class="card-logo-wrap">
                    @if(file_exists(public_path('images/logo.png')))
                        <img src="{{ asset('images/logo.png') }}" alt="Donik Donuts">
                    @else
                        <svg viewBox="0 0 110 110" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="55" cy="55" r="55" fill="#1a1a1a"/>
                            <circle cx="55" cy="55" r="49" fill="none" stroke="#fff" stroke-width="2"/>
                            <circle cx="55" cy="42" r="20" fill="#f5c518"/>
                            <ellipse cx="55" cy="39" rx="16" ry="12" fill="#f472b6"/>
                            <circle cx="55" cy="42" r="7" fill="#1a1a1a"/>
                            <rect x="42" y="30" width="5" height="2" rx="1" fill="#22c55e" transform="rotate(-30 42 30)"/>
                            <rect x="63" y="28" width="5" height="2" rx="1" fill="#3b82f6" transform="rotate(20 63 28)"/>
                            <rect x="68" y="40" width="5" height="2" rx="1" fill="#f59e0b" transform="rotate(-10 68 40)"/>
                            <rect x="60" y="52" width="5" height="2" rx="1" fill="#a855f7" transform="rotate(40 60 52)"/>
                            <rect x="42" y="53" width="5" height="2" rx="1" fill="#ef4444" transform="rotate(-20 42 53)"/>
                            <rect x="36" y="40" width="5" height="2" rx="1" fill="#ec4899" transform="rotate(10 36 40)"/>
                            <text x="55" y="76" text-anchor="middle" font-family="Arial Black,sans-serif" font-weight="900" font-size="7" fill="#f472b6">DONIK</text>
                        </svg>
                    @endif
                </div>
                <div class="card-brand">Donik Donuts</div>
                <div class="card-heading">Masuk ke Akun Anda</div>
                <div class="card-sub">Untuk mengakses sistem POS Donik Donuts</div>
            </div>

            <div class="card-divider"></div>

            {{-- Error --}}
            @if($errors->any())
            <div class="err-box">
                <i class="bi bi-exclamation-circle-fill"></i>
                {{ $errors->first() }}
            </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="field">
                    <div class="inp-wrap">
                        <i class="bi bi-person ico"></i>
                        <input type="email" id="email" name="email"
                               value="{{ old('email') }}"
                               placeholder="Email / Username"
                               required autofocus>
                    </div>
                </div>

                <div class="field">
                    <div class="inp-wrap">
                        <i class="bi bi-lock ico"></i>
                        <input type="password" id="password" name="password"
                               placeholder="Password"
                               required>
                        <button type="button" class="eye-btn" onclick="togglePwd()">
                            <i class="bi bi-eye" id="eyeIco"></i>
                        </button>
                    </div>
                </div>

                <div class="remember-row">
                    <div class="remember-left">
                        <input type="checkbox" id="remember" name="remember">
                        <label for="remember">Ingat saya</label>
                    </div>
                    <a href="#" class="forgot-link">Lupa password?</a>
                </div>

                <button type="submit" class="btn-login">
                    <i class="bi bi-box-arrow-in-right"></i>
                    Masuk
                </button>
            </form>

            <div class="footer-note">
                &copy; {{ date('Y') }} Donik Donuts. All rights reserved.
            </div>
        </div>
    </div>

</div>

<script>
function togglePwd() {
    var inp = document.getElementById('password');
    var ico = document.getElementById('eyeIco');
    inp.type = inp.type === 'password' ? 'text' : 'password';
    ico.className = inp.type === 'text' ? 'bi bi-eye-slash' : 'bi bi-eye';
}
</script>
</body>
</html>
