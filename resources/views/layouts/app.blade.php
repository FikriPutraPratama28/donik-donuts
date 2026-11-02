<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'POS') — Donik Donuts</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.svg') }}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            --primary:     #2f855a;
            --primary-dark:#276749;
            --primary-light:#c6f6d5;
            --sidebar-w:   260px;
            --header-h:    64px;
            --bg:          #f7faf8;
            --card-bg:     #ffffff;
            --text:        #1a202c;
            --muted:       #718096;
            --border:      #e2e8f0;
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--bg);
            color: var(--text);
            margin: 0;
        }

        /* ── Sidebar ── */
        #sidebar {
            position: fixed;
            top: 0; left: 0;
            width: var(--sidebar-w);
            height: 100vh;
            background: #1a202c;
            display: flex;
            flex-direction: column;
            z-index: 1000;
            transition: transform .3s ease;
        }

        .sidebar-brand {
            padding: 16px 20px;
            border-bottom: 1px solid rgba(255,255,255,.08);
        }

        .sidebar-brand .logo-wrap {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .sidebar-brand .logo-circle {
            width: 44px; height: 44px;
            flex-shrink: 0;
        }

        .sidebar-brand .logo-text {
            font-size: 17px;
            font-weight: 700;
            color: #fff;
            line-height: 1.1;
        }

        .sidebar-brand .logo-sub {
            font-size: 10px;
            color: rgba(255,255,255,.4);
            text-transform: uppercase;
            letter-spacing: .8px;
        }

        .sidebar-nav {
            flex: 1;
            overflow-y: auto;
            padding: 16px 12px;
        }

        .nav-section-label {
            font-size: 10px;
            font-weight: 600;
            color: rgba(255,255,255,.3);
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 12px 12px 6px;
        }

        .sidebar-nav .nav-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 14px;
            border-radius: 8px;
            color: rgba(255,255,255,.65);
            font-size: 14px;
            font-weight: 500;
            transition: all .15s;
            text-decoration: none;
            margin-bottom: 2px;
        }

        .sidebar-nav .nav-link i {
            font-size: 16px;
            width: 20px;
            text-align: center;
            flex-shrink: 0;
        }

        .sidebar-nav .nav-link:hover {
            background: rgba(255,255,255,.07);
            color: #fff;
        }

        .sidebar-nav .nav-link.active {
            background: var(--primary);
            color: #fff;
        }

        .sidebar-user {
            padding: 16px 20px;
            border-top: 1px solid rgba(255,255,255,.08);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .user-avatar {
            width: 36px; height: 36px;
            background: var(--primary);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 14px;
            font-weight: 700;
            color: #fff;
            flex-shrink: 0;
        }

        .user-info .user-name {
            font-size: 13px;
            font-weight: 600;
            color: #fff;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 140px;
        }

        .user-info .user-role {
            font-size: 11px;
            color: rgba(255,255,255,.4);
            text-transform: capitalize;
        }

        /* ── Main ── */
        #main-content {
            margin-left: var(--sidebar-w);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ── Topbar ── */
        .topbar {
            height: var(--header-h);
            background: var(--card-bg);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            padding: 0 28px;
            position: sticky;
            top: 0;
            z-index: 900;
            gap: 12px;
        }

        .topbar .page-title {
            font-size: 18px;
            font-weight: 700;
            color: var(--text);
            flex: 1;
        }

        .page-body {
            padding: 28px;
            flex: 1;
        }

        /* ── Cards ── */
        .card {
            border: 1px solid var(--border);
            border-radius: 14px;
            box-shadow: 0 1px 4px rgba(0,0,0,.04);
        }

        .card-header {
            background: transparent;
            border-bottom: 1px solid var(--border);
            padding: 18px 20px;
            font-weight: 600;
            font-size: 15px;
        }

        .stat-card {
            border-radius: 14px;
            padding: 22px;
            position: relative;
            overflow: hidden;
        }

        .stat-card .stat-icon {
            width: 48px; height: 48px;
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 22px;
            margin-bottom: 16px;
        }

        .stat-card .stat-value {
            font-size: 24px;
            font-weight: 700;
            line-height: 1;
            margin-bottom: 6px;
        }

        .stat-card .stat-label {
            font-size: 13px;
            opacity: .65;
        }

        /* ── Alerts ── */
        .alert { border-radius: 10px; border: none; }

        /* ── Buttons ── */
        .btn {
            font-weight: 500;
            border-radius: 8px;
            font-size: 14px;
        }

        .btn-primary {
            background: var(--primary);
            border-color: var(--primary);
        }

        .btn-primary:hover, .btn-primary:focus {
            background: var(--primary-dark);
            border-color: var(--primary-dark);
        }

        /* ── Tables ── */
        .table th {
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .5px;
            color: var(--muted);
            border-top: none;
        }

        .table td, .table th {
            padding: 12px 16px;
            vertical-align: middle;
        }

        /* ── Badges ── */
        .badge { border-radius: 6px; font-weight: 500; }

        /* ── Form controls ── */
        .form-control, .form-select {
            border-color: var(--border);
            border-radius: 8px;
            font-size: 14px;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(47,133,90,.15);
        }

        /* ── Responsive ── */
        @media (max-width: 991px) {
            #sidebar {
                transform: translateX(-100%);
                z-index: 1000;
                transition: transform .3s ease;
            }
            #sidebar.show { transform: translateX(0); }
            #main-content { margin-left: 0 !important; }

            .topbar { padding: 0 16px; }
            .page-body { padding: 16px; }

            /* Table responsive */
            .table-responsive { overflow-x: auto; -webkit-overflow-scrolling: touch; }
            .table td, .table th { padding: 10px 12px; font-size: 13px; }

            /* Cards */
            .row.g-4 { --bs-gutter-x: 12px; --bs-gutter-y: 12px; }
            .stat-card { padding: 16px 18px; }
            .stat-card .stat-value { font-size: 18px; }

            /* Form */
            .col-md-8, .col-md-6, .col-md-4, .col-md-3, .col-md-2 {
                width: 100%;
            }
        }

        @media (max-width: 575px) {
            .page-body { padding: 12px; }
            .topbar .page-title { font-size: 15px; }
            .card { border-radius: 10px; }
            .btn { font-size: 13px; }

            /* Hide some cols on very small screens */
            .d-none-xs { display: none !important; }
        }

        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,.4);
            z-index: 999;
        }

        .sidebar-overlay.show { display: block; }
    </style>

    @stack('styles')
</head>
<body>

    <!-- Sidebar Overlay (mobile) -->
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>

    <!-- Sidebar -->
    <aside id="sidebar">
        <div class="sidebar-brand">
            <div class="logo-wrap">
                {{-- Logo SVG Donik Donuts --}}
                <svg class="logo-circle" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="22" cy="22" r="22" fill="#d4522a"/>
                    <circle cx="22" cy="22" r="18" fill="#ffffff"/>
                    <!-- Donut shape -->
                    <circle cx="22" cy="22" r="11" fill="#f97316" stroke="#d4522a" stroke-width="1.5"/>
                    <circle cx="22" cy="22" r="5" fill="#ffffff"/>
                    <!-- Sprinkles -->
                    <rect x="16" y="12" width="3" height="1.5" rx="0.75" fill="#ec4899" transform="rotate(-30 16 12)"/>
                    <rect x="26" y="13" width="3" height="1.5" rx="0.75" fill="#3b82f6" transform="rotate(20 26 13)"/>
                    <rect x="29" y="21" width="3" height="1.5" rx="0.75" fill="#22c55e" transform="rotate(-10 29 21)"/>
                    <rect x="26" y="29" width="3" height="1.5" rx="0.75" fill="#f59e0b" transform="rotate(40 26 29)"/>
                    <rect x="16" y="30" width="3" height="1.5" rx="0.75" fill="#ec4899" transform="rotate(-20 16 30)"/>
                    <rect x="12" y="22" width="3" height="1.5" rx="0.75" fill="#a855f7" transform="rotate(10 12 22)"/>
                    <!-- Text DONIK -->
                    <text x="22" y="24.5" text-anchor="middle" font-family="Arial Black, sans-serif" font-weight="900" font-size="5.5" fill="#7c2d12">DONIK</text>
                    <!-- Text DONUTS -->
                    <text x="22" y="30.5" text-anchor="middle" font-family="Arial Black, sans-serif" font-weight="900" font-size="4" fill="#7c2d12">DONUTS</text>
                </svg>
                <div>
                    <div class="logo-text">Donik Donuts</div>
                    <div class="logo-sub">Point of Sale</div>
                </div>
            </div>
        </div>

        <nav class="sidebar-nav">
            <div class="nav-section-label">Menu</div>

            <a href="{{ route('dashboard') }}"
               class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid-1x2-fill"></i> Dashboard
            </a>

            @if(auth()->user()->isKasir())
            <a href="{{ route('pos.index') }}"
               class="nav-link {{ request()->routeIs('pos.*') ? 'active' : '' }}">
                <i class="bi bi-cart3"></i> Kasir / POS
            </a>
            @endif

            <a href="{{ route('transactions.index') }}"
               class="nav-link {{ request()->routeIs('transactions.*') ? 'active' : '' }}">
                <i class="bi bi-receipt"></i> Transaksi
            </a>

            @if(auth()->user()->isAdmin())
            <div class="nav-section-label mt-2">Manajemen</div>

            <a href="{{ route('products.index') }}"
               class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}">
                <i class="bi bi-box-seam"></i> Produk
            </a>

            <a href="{{ route('categories.index') }}"
               class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}">
                <i class="bi bi-tags"></i> Kategori
            </a>

            <a href="{{ route('stock.index') }}"
               class="nav-link {{ request()->routeIs('stock.*') ? 'active' : '' }}">
                <i class="bi bi-boxes"></i> Manajemen Stok
            </a>

            <a href="{{ route('reports.index') }}"
               class="nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}">
                <i class="bi bi-bar-chart-line"></i> Laporan
            </a>

            <a href="{{ route('users.index') }}"
               class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                <i class="bi bi-people"></i> Karyawan
            </a>

            <a href="{{ route('settings.index') }}"
               class="nav-link {{ request()->routeIs('settings.*') ? 'active' : '' }}">
                <i class="bi bi-gear"></i> Pengaturan
            </a>
            @endif
        </nav>

        <div class="sidebar-user">
            <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
            <div class="user-info" style="flex:1; min-width:0;">
                <div class="user-name">{{ auth()->user()->name }}</div>
                <div class="user-role">{{ auth()->user()->role }}</div>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-link p-0 text-secondary" title="Logout">
                    <i class="bi bi-box-arrow-right" style="font-size:18px;color:rgba(255,255,255,.4)"></i>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <div id="main-content">
        <!-- Topbar -->
        <header class="topbar">
            <button class="btn btn-link p-0 d-lg-none me-2" onclick="toggleSidebar()">
                <i class="bi bi-list" style="font-size:22px;color:var(--text)"></i>
            </button>
            <span class="page-title">@yield('page-title', 'Dashboard')</span>
            <div class="ms-auto d-flex align-items-center gap-2">
                @yield('topbar-actions')
            </div>
        </header>

        <!-- Page body -->
        <main class="page-body">
            @if(session('success'))
                <div class="alert alert-success d-flex align-items-center gap-2 mb-4">
                    <i class="bi bi-check-circle-fill"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger d-flex align-items-center gap-2 mb-4">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    {{ session('error') }}
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
