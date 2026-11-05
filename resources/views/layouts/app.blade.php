<!DOCTYPE html>
<html lang="id" data-sidebar="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'POS') — Donik Donuts</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.svg') }}">

    <!-- Google Fonts: Nunito (Skote uses Nunito/Poppins) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Simplebar (scrollbar tipis sidebar) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/simplebar@6.2.7/dist/simplebar.min.css">

    <style>
    /* ════════════════════════════════════════
       SKOTE THEME — CSS VARIABLES
    ════════════════════════════════════════ */
    :root {
        --sk-sidebar-bg:        #2c2f3b;
        --sk-sidebar-w:         250px;
        --sk-sidebar-collapsed: 70px;
        --sk-topbar-h:          70px;
        --sk-topbar-bg:         #ffffff;
        --sk-body-bg:           #f8f8fb;
        --sk-card-bg:           #ffffff;
        --sk-primary:           #556ee6;
        --sk-primary-rgb:       85,110,230;
        --sk-success:           #34c38f;
        --sk-info:              #50a5f1;
        --sk-warning:           #f1b44c;
        --sk-danger:            #f46a6a;
        --sk-pink:              #e83e8c;
        --sk-text:              #495057;
        --sk-heading:           #343a40;
        --sk-muted:             #74788d;
        --sk-border:            #eff2f7;
        --sk-card-radius:       0.75rem;
        --sk-nav-item-h:        42px;
    }

    *, *::before, *::after { box-sizing: border-box; }

    body {
        font-family: 'Nunito', sans-serif;
        font-size: 14px;
        background: var(--sk-body-bg);
        color: var(--sk-text);
        margin: 0;
        min-height: 100vh;
    }

    /* ════════════════════════════════════════
       VERTICAL MENU (SIDEBAR)
    ════════════════════════════════════════ */
    #sidebar {
        position: fixed;
        top: 0; left: 0;
        width: var(--sk-sidebar-w);
        height: 100vh;
        background: var(--sk-sidebar-bg);
        display: flex;
        flex-direction: column;
        z-index: 1002;
        transition: width .2s ease, transform .2s ease;
        box-shadow: 0 0.75rem 1.5rem rgba(18,38,63,.03);
    }

    /* Brand / Logo area */
    .sidebar-brand {
        height: var(--sk-topbar-h);
        padding: 0 20px;
        display: flex;
        align-items: center;
        gap: 12px;
        border-bottom: 1px solid rgba(255,255,255,.05);
        flex-shrink: 0;
        text-decoration: none;
    }
    .sidebar-brand .sk-logo-icon {
        width: 40px; height: 40px;
        border-radius: 10px;
        background: rgba(255,255,255,.1);
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
        overflow: hidden;
    }
    .sidebar-brand .sk-logo-icon img,
    .sidebar-brand .sk-logo-icon svg {
        width: 100%; height: 100%; object-fit: cover; border-radius: 10px;
    }
    .sidebar-brand .sk-logo-text {
        font-size: 16px;
        font-weight: 800;
        color: #ffffff;
        letter-spacing: -.2px;
        white-space: nowrap;
    }
    .sidebar-brand .sk-logo-sub {
        font-size: 9.5px;
        color: rgba(255,255,255,.35);
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-top: 1px;
    }

    /* Scrollable nav area */
    .sidebar-scroll {
        flex: 1;
        overflow-y: auto;
        overflow-x: hidden;
        padding: 10px 0 20px;
        scrollbar-width: thin;
        scrollbar-color: rgba(255,255,255,.1) transparent;
    }
    .sidebar-scroll::-webkit-scrollbar { width: 4px; }
    .sidebar-scroll::-webkit-scrollbar-thumb { background: rgba(255,255,255,.1); border-radius: 4px; }

    /* Section label */
    .sk-menu-title {
        font-size: 10px;
        font-weight: 700;
        color: rgba(255,255,255,.3);
        text-transform: uppercase;
        letter-spacing: 1.2px;
        padding: 18px 22px 6px;
    }

    /* Nav item */
    .sk-nav-item { padding: 2px 12px; }
    .sk-nav-link {
        display: flex;
        align-items: center;
        gap: 11px;
        padding: 10px 14px;
        border-radius: 7px;
        color: rgba(255,255,255,.6);
        font-size: 13.5px;
        font-weight: 500;
        text-decoration: none;
        transition: all .15s;
        position: relative;
        white-space: nowrap;
    }
    .sk-nav-link i {
        font-size: 17px;
        width: 22px;
        text-align: center;
        flex-shrink: 0;
        transition: color .15s;
    }
    .sk-nav-link:hover {
        background: rgba(255,255,255,.07);
        color: #ffffff;
    }
    .sk-nav-link.active {
        background: rgba(var(--sk-primary-rgb), .2);
        color: #ffffff;
    }
    .sk-nav-link.active i { color: var(--sk-primary); }
    .sk-nav-link.active::before {
        content: '';
        position: absolute;
        left: 0; top: 50%;
        transform: translateY(-50%);
        width: 3px; height: 22px;
        background: var(--sk-primary);
        border-radius: 0 3px 3px 0;
    }

    /* Badge on nav */
    .sk-nav-badge {
        margin-left: auto;
        font-size: 10px;
        font-weight: 700;
        padding: 2px 7px;
        border-radius: 20px;
        background: var(--sk-primary);
        color: #fff;
    }

    /* User footer */
    .sidebar-footer {
        padding: 14px 20px;
        border-top: 1px solid rgba(255,255,255,.06);
        display: flex;
        align-items: center;
        gap: 10px;
        flex-shrink: 0;
    }
    .sk-user-avatar {
        width: 34px; height: 34px;
        border-radius: 50%;
        background: var(--sk-primary);
        display: flex; align-items: center; justify-content: center;
        font-size: 13px; font-weight: 700; color: #fff;
        flex-shrink: 0;
    }
    .sk-user-name {
        font-size: 13px; font-weight: 600; color: #fff;
        white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        max-width: 130px;
    }
    .sk-user-role {
        font-size: 11px; color: rgba(255,255,255,.35);
        text-transform: capitalize; margin-top: 1px;
    }
    .sk-logout-btn {
        margin-left: auto;
        background: none; border: none; cursor: pointer;
        color: rgba(255,255,255,.35); font-size: 16px; padding: 4px;
        transition: color .15s; flex-shrink: 0;
    }
    .sk-logout-btn:hover { color: var(--sk-danger); }

    /* ════════════════════════════════════════
       TOPBAR
    ════════════════════════════════════════ */
    #topbar {
        position: fixed;
        top: 0;
        left: var(--sk-sidebar-w);
        right: 0;
        height: var(--sk-topbar-h);
        background: var(--sk-topbar-bg);
        border-bottom: 1px solid var(--sk-border);
        display: flex;
        align-items: center;
        padding: 0 24px;
        z-index: 1001;
        gap: 12px;
        transition: left .2s ease;
        box-shadow: 0 2px 4px rgba(0,0,0,.03);
    }

    /* Hamburger */
    #topbar .sk-hamburger {
        display: none;
        background: none; border: none; cursor: pointer;
        color: var(--sk-muted); font-size: 20px; padding: 4px 6px;
        border-radius: 6px; transition: all .15s;
    }
    #topbar .sk-hamburger:hover { background: var(--sk-border); color: var(--sk-primary); }

    /* Page title */
    .sk-page-title {
        font-size: 15px;
        font-weight: 700;
        color: var(--sk-heading);
        flex: 1;
    }

    /* Breadcrumb */
    .sk-breadcrumb {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 12px;
        color: var(--sk-muted);
        margin-top: 2px;
    }
    .sk-breadcrumb .bc-sep { color: #ced4da; }
    .sk-breadcrumb .bc-active { color: var(--sk-text); font-weight: 600; }

    /* Topbar right icons */
    .sk-topbar-right {
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .sk-topbar-btn {
        width: 38px; height: 38px;
        border-radius: 50%;
        background: none; border: none;
        display: flex; align-items: center; justify-content: center;
        font-size: 18px; color: var(--sk-muted); cursor: pointer;
        transition: all .15s; text-decoration: none;
        position: relative;
    }
    .sk-topbar-btn:hover { background: var(--sk-border); color: var(--sk-primary); }
    .sk-topbar-btn .notif-dot {
        position: absolute;
        top: 7px; right: 8px;
        width: 7px; height: 7px;
        background: var(--sk-danger);
        border-radius: 50%;
        border: 1.5px solid #fff;
    }

    /* User dropdown in topbar */
    .sk-topbar-user {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 4px 10px;
        border-radius: 8px;
        cursor: pointer;
        text-decoration: none;
        transition: background .15s;
    }
    .sk-topbar-user:hover { background: var(--sk-border); }
    .sk-topbar-user-av {
        width: 34px; height: 34px;
        border-radius: 50%;
        background: var(--sk-primary);
        display: flex; align-items: center; justify-content: center;
        font-size: 13px; font-weight: 700; color: #fff; flex-shrink: 0;
    }
    .sk-topbar-user-name {
        font-size: 13px; font-weight: 600; color: var(--sk-heading);
        white-space: nowrap;
    }
    .sk-topbar-user-role {
        font-size: 11px; color: var(--sk-muted); text-transform: capitalize;
    }

    /* ════════════════════════════════════════
       MAIN CONTENT
    ════════════════════════════════════════ */
    #main-content {
        margin-left: var(--sk-sidebar-w);
        padding-top: var(--sk-topbar-h);
        min-height: 100vh;
        transition: margin-left .2s ease;
    }

    .page-body {
        padding: 24px;
    }

    /* Page header */
    .sk-page-header {
        margin-bottom: 24px;
    }
    .sk-page-header h4 {
        font-size: 18px;
        font-weight: 700;
        color: var(--sk-heading);
        margin: 0 0 4px;
    }

    /* ════════════════════════════════════════
       CARDS (Skote style)
    ════════════════════════════════════════ */
    .card {
        background: var(--sk-card-bg);
        border: 1px solid var(--sk-border);
        border-radius: var(--sk-card-radius);
        box-shadow: 0 2px 6px rgba(0,0,0,.04);
        margin-bottom: 24px;
    }
    .card-body { padding: 20px; }
    .card-header {
        background: transparent;
        border-bottom: 1px solid var(--sk-border);
        padding: 16px 20px;
        font-weight: 700;
        font-size: 14px;
        color: var(--sk-heading);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .card-title {
        font-size: 15px;
        font-weight: 700;
        color: var(--sk-heading);
        margin-bottom: 0;
    }

    /* ════════════════════════════════════════
       ALERTS
    ════════════════════════════════════════ */
    .alert { border-radius: 8px; border: none; font-size: 13.5px; }

    /* ════════════════════════════════════════
       BUTTONS
    ════════════════════════════════════════ */
    .btn { font-weight: 500; border-radius: 6px; font-size: 13.5px; }
    .btn-primary { background: var(--sk-primary); border-color: var(--sk-primary); }
    .btn-primary:hover { background: #4458c9; border-color: #4458c9; }
    .btn-success { background: var(--sk-success); border-color: var(--sk-success); }
    .btn-warning { background: var(--sk-warning); border-color: var(--sk-warning); }
    .btn-danger  { background: var(--sk-danger);  border-color: var(--sk-danger); }

    /* ════════════════════════════════════════
       TABLES
    ════════════════════════════════════════ */
    .table th {
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .5px;
        color: var(--sk-muted);
        border-top: none;
        background: #f8f9fa;
    }
    .table td, .table th { padding: 12px 16px; vertical-align: middle; }
    .table-hover tbody tr:hover { background: #f8f9fc; }

    /* ════════════════════════════════════════
       BADGES
    ════════════════════════════════════════ */
    .badge { border-radius: 4px; font-weight: 600; font-size: 11px; }

    /* ════════════════════════════════════════
       FORM CONTROLS
    ════════════════════════════════════════ */
    .form-control, .form-select {
        border-color: var(--sk-border);
        border-radius: 6px; font-size: 13.5px;
        color: var(--sk-text);
    }
    .form-control:focus, .form-select:focus {
        border-color: var(--sk-primary);
        box-shadow: 0 0 0 3px rgba(var(--sk-primary-rgb),.15);
    }
    .form-label { font-weight: 600; font-size: 13px; color: var(--sk-heading); }

    /* ════════════════════════════════════════
       SIDEBAR OVERLAY (mobile)
    ════════════════════════════════════════ */
    .sidebar-overlay {
        display: none;
        position: fixed; inset: 0;
        background: rgba(0,0,0,.45);
        z-index: 1001;
    }
    .sidebar-overlay.show { display: block; }

    /* ════════════════════════════════════════
       RESPONSIVE
    ════════════════════════════════════════ */
    @media (max-width: 991.98px) {
        #sidebar { transform: translateX(-100%); }
        #sidebar.show { transform: translateX(0); }
        #topbar { left: 0 !important; }
        #topbar .sk-hamburger { display: flex; }
        #main-content { margin-left: 0 !important; }
        .page-body { padding: 16px; }
    }
    @media (max-width: 575.98px) {
        .page-body { padding: 12px; }
        .sk-topbar-user-name, .sk-topbar-user-role { display: none; }
    }
    </style>

    @stack('styles')
</head>
<body>

<!-- Overlay -->
<div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>

<!-- ════════ SIDEBAR ════════ -->
<aside id="sidebar">
    <!-- Brand -->
    <a class="sidebar-brand" href="{{ route('dashboard') }}">
        <div class="sk-logo-icon">
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
        <div>
            <div class="sk-logo-text">Donik Donuts</div>
            <div class="sk-logo-sub">Point of Sale</div>
        </div>
    </a>

    <!-- Navigation -->
    <div class="sidebar-scroll">
        <div class="sk-menu-title">Menu</div>

        <div class="sk-nav-item">
            <a href="{{ route('dashboard') }}"
               class="sk-nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i>
                <span>Dashboard</span>
            </a>
        </div>

        @if(auth()->user()->isKasir())
        <div class="sk-nav-item">
            <a href="{{ route('pos.index') }}"
               class="sk-nav-link {{ request()->routeIs('pos.*') ? 'active' : '' }}">
                <i class="bi bi-cart3"></i>
                <span>Kasir / POS</span>
            </a>
        </div>
        @endif

        <div class="sk-nav-item">
            <a href="{{ route('transactions.index') }}"
               class="sk-nav-link {{ request()->routeIs('transactions.*') ? 'active' : '' }}">
                <i class="bi bi-receipt"></i>
                <span>Transaksi</span>
            </a>
        </div>

        @if(auth()->user()->isAdmin())
        <div class="sk-menu-title">Manajemen</div>

        <div class="sk-nav-item">
            <a href="{{ route('products.index') }}"
               class="sk-nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}">
                <i class="bi bi-box-seam"></i>
                <span>Produk</span>
            </a>
        </div>

        <div class="sk-nav-item">
            <a href="{{ route('categories.index') }}"
               class="sk-nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}">
                <i class="bi bi-tags"></i>
                <span>Kategori</span>
            </a>
        </div>

        <div class="sk-nav-item">
            <a href="{{ route('stock.index') }}"
               class="sk-nav-link {{ request()->routeIs('stock.*') ? 'active' : '' }}">
                <i class="bi bi-boxes"></i>
                <span>Manajemen Stok</span>
            </a>
        </div>

        <div class="sk-nav-item">
            <a href="{{ route('reports.index') }}"
               class="sk-nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}">
                <i class="bi bi-bar-chart-line"></i>
                <span>Laporan</span>
            </a>
        </div>

        <div class="sk-nav-item">
            <a href="{{ route('users.index') }}"
               class="sk-nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                <i class="bi bi-people"></i>
                <span>Karyawan</span>
            </a>
        </div>

        <div class="sk-menu-title">Pengaturan</div>

        <div class="sk-nav-item">
            <a href="{{ route('settings.index') }}"
               class="sk-nav-link {{ request()->routeIs('settings.*') ? 'active' : '' }}">
                <i class="bi bi-gear"></i>
                <span>Pengaturan</span>
            </a>
        </div>
        @endif
    </div>

    <!-- User Footer -->
    <div class="sidebar-footer">
        <div class="sk-user-avatar">
            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
        </div>
        <div style="flex:1;min-width:0">
            <div class="sk-user-name">{{ auth()->user()->name }}</div>
            <div class="sk-user-role">{{ auth()->user()->role }}</div>
        </div>
        <form method="POST" action="{{ route('logout') }}" class="m-0">
            @csrf
            <button type="submit" class="sk-logout-btn" title="Keluar">
                <i class="bi bi-box-arrow-right"></i>
            </button>
        </form>
    </div>
</aside>

<!-- ════════ TOPBAR ════════ -->
<header id="topbar">
    <!-- Hamburger (mobile) -->
    <button class="sk-hamburger" onclick="toggleSidebar()">
        <i class="bi bi-list"></i>
    </button>

    <!-- Page title area -->
    <div style="flex:1">
        <div class="sk-page-title">@yield('page-title', 'Dashboard')</div>
    </div>

    @yield('topbar-actions')

    <!-- Right icons -->
    <div class="sk-topbar-right">
        <!-- Clock -->
        <div style="font-size:12px;color:var(--sk-muted);font-weight:600;padding:0 8px;display:none" class="d-lg-block">
            {{ now()->format('d M Y') }}
        </div>

        <!-- Notifications -->
        @if(auth()->user()->isAdmin() && isset($lowStock) && $lowStock > 0)
        <a href="{{ route('stock.index') }}" class="sk-topbar-btn" title="{{ $lowStock }} stok rendah">
            <i class="bi bi-bell"></i>
            <span class="notif-dot"></span>
        </a>
        @else
        <span class="sk-topbar-btn">
            <i class="bi bi-bell"></i>
        </span>
        @endif

        <!-- User dropdown -->
        <div class="dropdown">
            <div class="sk-topbar-user" data-bs-toggle="dropdown">
                <div class="sk-topbar-user-av">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div class="d-none d-sm-block">
                    <div class="sk-topbar-user-name">{{ auth()->user()->name }}</div>
                    <div class="sk-topbar-user-role">{{ auth()->user()->role }}</div>
                </div>
                <i class="bi bi-chevron-down" style="font-size:11px;color:var(--sk-muted);margin-left:4px"></i>
            </div>
            <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-1" style="min-width:180px;border-radius:10px;font-size:13px">
                <li>
                    <div style="padding:12px 16px 8px">
                        <div style="font-weight:700;color:var(--sk-heading)">{{ auth()->user()->name }}</div>
                        <div style="font-size:12px;color:var(--sk-muted)">{{ auth()->user()->email }}</div>
                    </div>
                </li>
                <li><hr class="dropdown-divider my-1"></li>
                @if(auth()->user()->isAdmin())
                <li><a class="dropdown-item" href="{{ route('settings.index') }}"><i class="bi bi-gear me-2"></i>Pengaturan</a></li>
                @endif
                <li>
                    <form method="POST" action="{{ route('logout') }}" class="m-0">
                        @csrf
                        <button type="submit" class="dropdown-item text-danger">
                            <i class="bi bi-box-arrow-right me-2"></i>Keluar
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</header>

<!-- ════════ MAIN CONTENT ════════ -->
<div id="main-content">
    <main class="page-body">

        <!-- Flash messages -->
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-3 d-flex align-items-center gap-2" role="alert" style="background:#d1fae5;color:#065f46;border-left:4px solid #34c38f">
            <i class="bi bi-check-circle-fill"></i>
            <span>{{ session('success') }}</span>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-3 d-flex align-items-center gap-2" role="alert" style="background:#fee2e2;color:#991b1b;border-left:4px solid #f46a6a">
            <i class="bi bi-exclamation-circle-fill"></i>
            <span>{{ session('error') }}</span>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @yield('content')

    </main>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
function toggleSidebar() {
    document.getElementById('sidebar').classList.toggle('show');
    document.getElementById('sidebarOverlay').classList.toggle('show');
}
function closeSidebar() {
    document.getElementById('sidebar').classList.remove('show');
    document.getElementById('sidebarOverlay').classList.remove('show');
}
</script>

@stack('scripts')
</body>
</html>
