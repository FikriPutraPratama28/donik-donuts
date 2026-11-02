<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login — Donik Donuts</title>
<link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
<link rel="shortcut icon" href="{{ asset('favicon.svg') }}">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
html,body{height:100%;font-family:'DM Sans',sans-serif;-webkit-font-smoothing:antialiased}

.wrap{
    display:flex;
    height:100vh;
    overflow:hidden;
}

/* ── Kiri: panel hijau ── */
.panel-left{
    width:45%;
    background: linear-gradient(145deg, #1a3d2b 0%, #2d6a45 50%, #1e4d32 100%);
    display:flex;
    flex-direction:column;
    align-items:center;
    justify-content:center;
    padding:48px;
    position:relative;
    overflow:hidden;
}

/* dekorasi bulat blur */
.panel-left::before{
    content:'';
    position:absolute;
    width:400px; height:400px;
    background:rgba(58,175,58,.18);
    border-radius:50%;
    top:-80px; left:-100px;
    filter:blur(60px);
}
.panel-left::after{
    content:'';
    position:absolute;
    width:300px; height:300px;
    background:rgba(100,220,100,.12);
    border-radius:50%;
    bottom:-60px; right:-60px;
    filter:blur(50px);
}

.panel-left .logo-wrap{
    position:relative;
    z-index:1;
    text-align:center;
    margin-bottom:36px;
}

.panel-left .tagline{
    position:relative;
    z-index:1;
    text-align:center;
}

.panel-left .tagline h1{
    font-family:'Instrument Sans',sans-serif;
    font-size:34px;
    font-weight:800;
    color:#fff;
    letter-spacing:-.5px;
    line-height:1.15;
    margin-bottom:10px;
}

.panel-left .tagline p{
    font-size:14px;
    color:rgba(255,255,255,.55);
    line-height:1.6;
    max-width:280px;
    margin:0 auto;
}

.panel-left .features{
    position:relative;
    z-index:1;
    margin-top:40px;
    display:flex;
    flex-direction:column;
    gap:14px;
    width:100%;
    max-width:300px;
}

.feat-item{
    display:flex;
    align-items:center;
    gap:12px;
    background:rgba(255,255,255,.08);
    border:1px solid rgba(255,255,255,.1);
    border-radius:12px;
    padding:12px 16px;
}

.feat-item .feat-ico{
    width:36px; height:36px;
    background:rgba(58,175,58,.3);
    border-radius:9px;
    display:flex; align-items:center; justify-content:center;
    font-size:17px;
    color:#6ee7b7;
    flex-shrink:0;
}

.feat-item .feat-txt{
    font-size:13px;
    font-weight:600;
    color:rgba(255,255,255,.85);
}

.feat-item .feat-sub{
    font-size:11px;
    color:rgba(255,255,255,.4);
    margin-top:1px;
}

/* ── Kanan: form ── */
.panel-right{
    flex:1;
    background:#f8faf9;
    display:flex;
    align-items:center;
    justify-content:center;
    padding:48px 40px;
}

.form-box{
    width:100%;
    max-width:400px;
}

.form-box .welcome{
    margin-bottom:32px;
}

.form-box .welcome h2{
    font-family:'Instrument Sans',sans-serif;
    font-size:26px;
    font-weight:800;
    color:#111827;
    letter-spacing:-.4px;
    margin-bottom:6px;
}

.form-box .welcome p{
    font-size:14px;
    color:#6b7280;
}

.field{
    margin-bottom:18px;
}

.field label{
    display:block;
    font-size:13px;
    font-weight:600;
    color:#374151;
    margin-bottom:7px;
}

.inp-wrap{
    position:relative;
    display:flex;
    align-items:center;
}

.inp-wrap .ico{
    position:absolute;
    left:14px;
    color:#9ca3af;
    font-size:15px;
    pointer-events:none;
}

.inp-wrap input{
    width:100%;
    height:46px;
    padding:0 14px 0 42px;
    border:1.5px solid #e5e7eb;
    border-radius:10px;
    font-size:14px;
    font-family:inherit;
    color:#111827;
    background:#fff;
    transition:border-color .15s, box-shadow .15s;
    outline:none;
}

.inp-wrap input:focus{
    border-color:#3aaf3a;
    box-shadow:0 0 0 3px rgba(58,175,58,.12);
}

.inp-wrap .eye-btn{
    position:absolute;
    right:12px;
    background:none;
    border:none;
    cursor:pointer;
    color:#9ca3af;
    font-size:15px;
    padding:4px;
    line-height:1;
    transition:color .15s;
}

.inp-wrap .eye-btn:hover{ color:#374151; }

.remember-row{
    display:flex;
    align-items:center;
    gap:8px;
    margin-bottom:24px;
}

.remember-row input[type="checkbox"]{
    width:16px; height:16px;
    accent-color:#3aaf3a;
    cursor:pointer;
}

.remember-row label{
    font-size:13px;
    color:#6b7280;
    cursor:pointer;
}

.btn-login{
    width:100%;
    height:48px;
    background:#1a3d2b;
    color:#fff;
    border:none;
    border-radius:11px;
    font-size:15px;
    font-weight:700;
    font-family:'Instrument Sans',sans-serif;
    cursor:pointer;
    transition:background .15s, transform .1s;
    display:flex;
    align-items:center;
    justify-content:center;
    gap:8px;
    letter-spacing:.1px;
}

.btn-login:hover{ background:#276749; }
.btn-login:active{ transform:scale(.98); }

.err-box{
    background:#fef2f2;
    border:1px solid #fecaca;
    border-radius:10px;
    padding:10px 14px;
    font-size:13px;
    color:#dc2626;
    margin-bottom:20px;
    display:flex;
    align-items:center;
    gap:8px;
}

.footer-note{
    margin-top:28px;
    text-align:center;
    font-size:12px;
    color:#9ca3af;
}

/* responsive */
@media(max-width:768px){
    .wrap{flex-direction:column}
    .panel-left{display:none}
    .panel-right{padding:32px 24px}
    .form-box{max-width:100%}
}
@media(max-width:400px){
    .panel-right{padding:24px 16px}
    .btn-login{font-size:14px;height:44px}
}
</style>
</head>
<body>
<div class="wrap">

    {{-- ── Panel Kiri ── --}}
    <div class="panel-left">
        <div class="logo-wrap">
            <svg width="90" height="90" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="22" cy="22" r="22" fill="#d4522a"/>
                <circle cx="22" cy="22" r="18" fill="#ffffff"/>
                <circle cx="22" cy="22" r="11" fill="#f97316" stroke="#d4522a" stroke-width="1.5"/>
                <circle cx="22" cy="22" r="5" fill="#ffffff"/>
                <rect x="16" y="12" width="3" height="1.5" rx="0.75" fill="#ec4899" transform="rotate(-30 16 12)"/>
                <rect x="26" y="13" width="3" height="1.5" rx="0.75" fill="#3b82f6" transform="rotate(20 26 13)"/>
                <rect x="29" y="21" width="3" height="1.5" rx="0.75" fill="#22c55e" transform="rotate(-10 29 21)"/>
                <rect x="26" y="29" width="3" height="1.5" rx="0.75" fill="#f59e0b" transform="rotate(40 26 29)"/>
                <rect x="16" y="30" width="3" height="1.5" rx="0.75" fill="#ec4899" transform="rotate(-20 16 30)"/>
                <rect x="12" y="22" width="3" height="1.5" rx="0.75" fill="#a855f7" transform="rotate(10 12 22)"/>
                <text x="22" y="24.5" text-anchor="middle" font-family="Arial Black,sans-serif" font-weight="900" font-size="5.5" fill="#7c2d12">DONIK</text>
                <text x="22" y="30.5" text-anchor="middle" font-family="Arial Black,sans-serif" font-weight="900" font-size="4" fill="#7c2d12">DONUTS</text>
            </svg>
        </div>

        <div class="tagline">
            <h1>Donik Donuts</h1>
            <p>Sistem kasir modern untuk bisnis donut Anda yang berkembang.</p>
        </div>

        <div class="features">
            <div class="feat-item">
                <div class="feat-ico"><i class="bi bi-lightning-charge-fill"></i></div>
                <div>
                    <div class="feat-txt">Kasir Cepat</div>
                    <div class="feat-sub">Proses transaksi dalam hitungan detik</div>
                </div>
            </div>
            <div class="feat-item">
                <div class="feat-ico"><i class="bi bi-bar-chart-fill"></i></div>
                <div>
                    <div class="feat-txt">Laporan Real-time</div>
                    <div class="feat-sub">Pantau penjualan kapan saja</div>
                </div>
            </div>
            <div class="feat-item">
                <div class="feat-ico"><i class="bi bi-qr-code-scan"></i></div>
                <div>
                    <div class="feat-txt">QRIS Terintegrasi</div>
                    <div class="feat-sub">Terima pembayaran digital mudah</div>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Panel Kanan ── --}}
    <div class="panel-right">
        <div class="form-box">
            <div class="welcome">
                <h2>Selamat datang</h2>
                <p>Masuk ke akun Anda untuk melanjutkan</p>
            </div>

            @if($errors->any())
            <div class="err-box">
                <i class="bi bi-exclamation-circle-fill"></i>
                {{ $errors->first() }}
            </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="field">
                    <label for="email">Email</label>
                    <div class="inp-wrap">
                        <i class="bi bi-envelope ico"></i>
                        <input type="email" id="email" name="email"
                               value="{{ old('email') }}"
                               placeholder="nama@tehkota.com"
                               required autofocus>
                    </div>
                </div>

                <div class="field">
                    <label for="password">Password</label>
                    <div class="inp-wrap">
                        <i class="bi bi-lock ico"></i>
                        <input type="password" id="password" name="password"
                               placeholder="Masukkan password"
                               required>
                        <button type="button" class="eye-btn" onclick="togglePwd()">
                            <i class="bi bi-eye" id="eyeIco"></i>
                        </button>
                    </div>
                </div>

                <div class="remember-row">
                    <input type="checkbox" id="remember" name="remember">
                    <label for="remember">Ingat saya di perangkat ini</label>
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
    if (inp.type === 'password') {
        inp.type = 'text';
        ico.className = 'bi bi-eye-slash';
    } else {
        inp.type = 'password';
        ico.className = 'bi bi-eye';
    }
}
</script>
</body>
</html>
