<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>500 — Server Error | Donik Donuts</title>
<link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
html,body{height:100%;font-family:'Nunito',sans-serif;-webkit-font-smoothing:antialiased}
body{background:#f8f8fb;display:flex;align-items:center;justify-content:center;min-height:100vh;overflow:hidden;position:relative}
.bg-blob{position:fixed;border-radius:50%;filter:blur(80px);opacity:.5;animation:blobFloat 8s ease-in-out infinite;pointer-events:none;z-index:0}
.bb1{width:500px;height:500px;background:rgba(244,106,106,.1);top:-100px;left:-100px;animation-delay:0s}
.bb2{width:400px;height:400px;background:rgba(241,180,76,.1);bottom:-80px;right:-80px;animation-delay:3s}
@keyframes blobFloat{0%,100%{transform:translate(0,0) scale(1)}33%{transform:translate(20px,-20px) scale(1.05)}66%{transform:translate(-15px,15px) scale(.95)}}
.error-card{position:relative;z-index:1;text-align:center;padding:60px 40px 50px;max-width:520px;width:90%}
.err-icon{font-size:80px;animation:shake 1.2s ease-in-out infinite;display:inline-block;margin-bottom:8px}
@keyframes shake{0%,100%{transform:rotate(0deg)}10%{transform:rotate(-8deg)}20%{transform:rotate(8deg)}30%{transform:rotate(-6deg)}40%{transform:rotate(6deg)}50%{transform:rotate(0deg)}}.plate{width:80px;height:10px;background:rgba(0,0,0,.07);border-radius:50%;margin:0 auto 28px;animation:platePulse 1.2s ease-in-out infinite}
@keyframes platePulse{0%,100%{transform:scaleX(1);opacity:.07}50%{transform:scaleX(.6);opacity:.03}}
.err-code{display:inline-flex;align-items:center;gap:6px;background:#fff;border:1.5px solid #eff2f7;border-radius:8px;padding:6px 14px;font-size:12px;font-weight:700;color:#74788d;margin-bottom:20px;box-shadow:0 2px 8px rgba(0,0,0,.04);animation:fadeInUp .6s ease both}
.err-code .dot{width:7px;height:7px;border-radius:50%;background:#f46a6a;animation:dotPulse 1.5s ease-in-out infinite}
@keyframes dotPulse{0%,100%{opacity:1;transform:scale(1)}50%{opacity:.4;transform:scale(.6)}}
.num-500{font-size:120px;font-weight:900;color:#2c2f3b;letter-spacing:-4px;line-height:1;margin-bottom:0;animation:fadeInUp .6s ease both}
.err-title{font-size:24px;font-weight:800;color:#2c2f3b;margin-bottom:12px;animation:fadeInUp .6s ease both;animation-delay:.2s}
.err-sub{font-size:15px;color:#74788d;line-height:1.6;margin-bottom:36px;max-width:380px;margin-left:auto;margin-right:auto;animation:fadeInUp .6s ease both;animation-delay:.35s}
@keyframes fadeInUp{from{opacity:0;transform:translateY(16px)}to{opacity:1;transform:translateY(0)}}
.btn-row{display:flex;align-items:center;justify-content:center;gap:12px;flex-wrap:wrap;animation:fadeInUp .6s ease both;animation-delay:.5s}
.btn-home{display:inline-flex;align-items:center;gap:8px;padding:12px 28px;background:#556ee6;color:#fff;border:none;border-radius:10px;font-size:14px;font-weight:700;font-family:inherit;text-decoration:none;cursor:pointer;transition:all .2s;box-shadow:0 4px 16px rgba(85,110,230,.35)}
.btn-home:hover{background:#4458c9;transform:translateY(-2px);box-shadow:0 8px 24px rgba(85,110,230,.45);color:#fff}
.btn-back{display:inline-flex;align-items:center;gap:8px;padding:12px 24px;background:#fff;color:#495057;border:1.5px solid #eff2f7;border-radius:10px;font-size:14px;font-weight:700;font-family:inherit;text-decoration:none;cursor:pointer;transition:all .2s;box-shadow:0 2px 8px rgba(0,0,0,.04)}
.btn-back:hover{background:#f8f8fb;border-color:#556ee6;color:#556ee6;transform:translateY(-2px)}
@media(max-width:480px){.num-500{font-size:80px}.err-title{font-size:18px}.err-sub{font-size:13px}}
</style>
</head>
<body>
<div class="bg-blob bb1"></div>
<div class="bg-blob bb2"></div>
<div class="error-card">
    <div class="err-code"><span class="dot"></span> Error 500 — Server Error</div>
    <div class="err-icon">⚙️</div>
    <div class="plate"></div>
    <div class="num-500">500</div>
    <div class="err-title">Terjadi Kesalahan Server</div>
    <div class="err-sub">Maaf, server sedang mengalami gangguan. Tim kami sudah diberitahu. Coba lagi beberapa saat.</div>
    <div class="btn-row">
        @auth
        <a href="{{ route('dashboard') }}" class="btn-home"><i class="bi bi-house-fill"></i> Kembali ke Dashboard</a>
        @else
        <a href="{{ route('login') }}" class="btn-home"><i class="bi bi-house-fill"></i> Ke Halaman Login</a>
        @endauth
        <a href="javascript:location.reload()" class="btn-back"><i class="bi bi-arrow-clockwise"></i> Coba Lagi</a>
    </div>
</div>
</body>
</html>
