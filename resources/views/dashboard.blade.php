@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@push('styles')
<style>
/* ── Stat cards ── */
.stat-card {
    border-radius: 14px;
    padding: 20px 22px;
    border: none;
    position: relative;
    overflow: hidden;
}
.stat-card .sc-icon {
    width: 42px; height: 42px;
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    font-size: 19px;
    margin-bottom: 14px;
    flex-shrink: 0;
}
.stat-card .sc-val {
    font-size: 21px;
    font-weight: 800;
    line-height: 1;
    margin-bottom: 5px;
    letter-spacing: -.4px;
    transition: opacity .3s;
}
.stat-card .sc-lbl {
    font-size: 12px;
    font-weight: 500;
    opacity: .7;
}
.stat-card .sc-sub {
    font-size: 11px;
    margin-top: 10px;
    opacity: .6;
    display: flex;
    align-items: center;
    gap: 4px;
}

.sc-green  { background: #1a3d2b; color: #fff; }
.sc-green .sc-icon  { background: rgba(255,255,255,.12); color: #6ee7b7; }
.sc-green .sc-sub   { color: #6ee7b7; opacity:1; }

.sc-blue   { background: #1e3a5f; color: #fff; }
.sc-blue .sc-icon   { background: rgba(255,255,255,.12); color: #93c5fd; }
.sc-blue .sc-sub    { color: #93c5fd; opacity:1; }

.sc-amber  { background: #7c3f00; color: #fff; }
.sc-amber .sc-icon  { background: rgba(255,255,255,.12); color: #fcd34d; }
.sc-amber .sc-sub   { color: #fcd34d; opacity:1; }

.sc-red    { background: #1f1f2e; color: #fff; }
.sc-red .sc-icon    { background: rgba(255,255,255,.12); color: #c4b5fd; }
.sc-red .sc-sub     { color: #c4b5fd; opacity:1; }

/* ── Cards ── */
.dash-card {
    background: #fff;
    border-radius: 16px;
    border: 1px solid #e5e7eb;
    overflow: hidden;
}
.dash-card-head {
    padding: 16px 20px;
    border-bottom: 1px solid #f3f4f6;
    font-weight: 700;
    font-size: 14px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    color: #1c1c1e;
}
.dash-card-head .head-icon {
    width: 30px; height: 30px;
    border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    font-size: 14px;
}

/* ── Real-time badge ── */
.rt-badge {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-size: 11px;
    font-weight: 600;
    color: #16a34a;
    background: #f0fdf4;
    border: 1px solid #bbf7d0;
    border-radius: 20px;
    padding: 3px 10px;
    white-space: nowrap;
}
.rt-dot {
    width: 7px; height: 7px;
    background: #16a34a;
    border-radius: 50%;
    animation: rtpulse 1.5s ease-in-out infinite;
}
@keyframes rtpulse {
    0%, 100% { opacity: 1; transform: scale(1); }
    50%       { opacity: .45; transform: scale(.75); }
}

/* Spinner saat loading */
.rt-spinner {
    display: none;
    width: 14px; height: 14px;
    border: 2px solid #d1fae5;
    border-top-color: #16a34a;
    border-radius: 50%;
    animation: spin .6s linear infinite;
}
@keyframes spin { to { transform: rotate(360deg); } }
.is-refreshing .rt-spinner  { display: inline-block; }
.is-refreshing .rt-dot      { display: none; }

/* ── Top products ── */
.top-prod-row {
    display: flex;
    align-items: center;
    padding: 12px 20px;
    gap: 12px;
    border-bottom: 1px solid #f9fafb;
    transition: background .12s;
}
.top-prod-row:last-child { border-bottom: none; }
.top-prod-row:hover { background: #f9fafb; }
.rank-badge {
    width: 26px; height: 26px;
    border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    font-size: 12px;
    font-weight: 800;
    flex-shrink: 0;
}
.rank-1 { background: #fef3c7; color: #92400e; }
.rank-2 { background: #e0f2fe; color: #0369a1; }
.rank-3 { background: #f0fdf4; color: #166534; }
.rank-n { background: #f3f4f6; color: #6b7280; }

/* ── Method pills ── */
.method-pill {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 3px 10px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: .3px;
}
.mp-cash     { background: #f0fdf4; color: #166534; }
.mp-transfer { background: #eff6ff; color: #1d4ed8; }
.mp-qris     { background: #faf5ff; color: #7c3aed; }

/* ── Table ── */
.dash-table th {
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .5px;
    color: #9ca3af;
    padding: 10px 16px;
    border-top: none;
    background: #f9fafb;
}
.dash-table td {
    padding: 12px 16px;
    vertical-align: middle;
    border-color: #f3f4f6;
    font-size: 13px;
}
.dash-table tbody tr:hover { background: #f9fafb; }

/* ── Progress bar ── */
.prog-bar {
    height: 5px;
    background: #f3f4f6;
    border-radius: 10px;
    overflow: hidden;
    margin-top: 5px;
}
.prog-fill {
    height: 100%;
    border-radius: 10px;
    background: #3d6b4f;
    transition: width .5s ease;
}

/* ── Chart tab switch ── */
.chart-tab-btn {
    padding: 5px 14px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    border: 1px solid #e5e7eb;
    background: #fff;
    color: #6b7280;
    cursor: pointer;
    transition: all .15s;
}
.chart-tab-btn.active {
    background: #3d6b4f;
    border-color: #3d6b4f;
    color: #fff;
}

/* ── Last-updated text ── */
.last-updated {
    font-size: 11px;
    color: #9ca3af;
    font-weight: 500;
}

/* ── Responsive Dashboard ── */
@media (max-width: 768px) {
    .stat-card { padding: 14px 16px; }
    .stat-card .sc-val { font-size: 17px; }
    .stat-card .sc-icon { width: 36px; height: 36px; font-size: 16px; margin-bottom: 10px; }
    .stat-card .sc-sub { font-size: 10px; }
    .dash-card-head { padding: 12px 16px; font-size: 13px; }
    .top-prod-row { padding: 10px 14px; gap: 8px; }
    .dash-table th, .dash-table td { padding: 9px 12px; font-size: 12px; }
    .chart-tab-btn { padding: 4px 10px; font-size: 11px; }
}
@media (max-width: 480px) {
    .stat-card .sc-val { font-size: 15px; }
    .stat-card .sc-lbl { font-size: 11px; }
    .dash-card-head { font-size: 12px; }
    .col-hide-xs { display: none !important; }
}
</style>
@endpush

@section('content')

{{-- ── STAT CARDS ── --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-xl-3">
        <div class="stat-card sc-green">
            <div class="sc-icon"><i class="bi bi-cup-hot-fill"></i></div>
            <div class="sc-val" id="stat-today-sales">Rp {{ number_format($todaySales, 0, ',', '.') }}</div>
            <div class="sc-lbl">Penjualan Hari Ini</div>
            <div class="sc-sub">
                <i class="bi bi-receipt"></i>
                <span id="stat-today-trx">{{ $todayTransactions }}</span> transaksi hari ini
            </div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="stat-card sc-blue">
            <div class="sc-icon"><i class="bi bi-bar-chart-fill"></i></div>
            <div class="sc-val" id="stat-month-sales">Rp {{ number_format($monthSales, 0, ',', '.') }}</div>
            <div class="sc-lbl">Penjualan Bulan Ini</div>
            <div class="sc-sub">
                <i class="bi bi-calendar3"></i>
                <span id="stat-month-trx">{{ $monthTransactions }}</span> transaksi bulan ini
            </div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="stat-card sc-amber">
            <div class="sc-icon"><i class="bi bi-tags-fill"></i></div>
            <div class="sc-val">{{ $totalProducts }}</div>
            <div class="sc-lbl">Total Produk Aktif</div>
            <div class="sc-sub" id="stat-low-stock-sub">
                @if($lowStock > 0)
                    <i class="bi bi-exclamation-triangle-fill"></i>{{ $lowStock }} stok hampir habis
                @else
                    <i class="bi bi-check2-circle"></i>Semua stok aman
                @endif
            </div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="stat-card sc-red">
            <div class="sc-icon"><i class="bi bi-person-badge-fill"></i></div>
            <div class="sc-val">{{ $totalUsers }}</div>
            <div class="sc-lbl">Total Pengguna</div>
            <div class="sc-sub">
                <i class="bi bi-shield-fill-check"></i>Sistem aktif
            </div>
        </div>
    </div>
</div>

{{-- ── GRAFIK UTAMA + TOP PRODUCTS ── --}}
<div class="row g-3 mb-4">

    {{-- Grafik real-time --}}
    <div class="col-lg-8">
        <div class="dash-card h-100">
            <div class="dash-card-head">
                <div class="d-flex align-items-center gap-2 flex-wrap">
                    <div class="head-icon" style="background:#f0fdf4;color:#3d6b4f">
                        <i class="bi bi-bar-chart-line"></i>
                    </div>
                    <span>Grafik Penjualan</span>
                    {{-- Real-time badge --}}
                    <span class="rt-badge" id="rt-badge">
                        <span class="rt-dot"></span>
                        <span class="rt-spinner"></span>
                        Live
                    </span>
                </div>
                {{-- Tab switch: 7 hari / per jam --}}
                <div class="d-flex align-items-center gap-2 flex-wrap">
                    <button class="chart-tab-btn active" id="btn-7day" onclick="switchChart('7day')">7 Hari</button>
                    <button class="chart-tab-btn" id="btn-hourly" onclick="switchChart('hourly')">Per Jam</button>
                </div>
            </div>
            {{-- Subtitle total --}}
            <div style="padding:10px 20px 0;display:flex;justify-content:space-between;align-items:center">
                <div class="last-updated">
                    Diperbarui: <span id="last-updated-time">{{ now()->format('H:i:s') }}</span>
                </div>
                <div style="font-size:12px;color:#9ca3af;font-weight:500">
                    Total 7 hari: Rp <span id="chart-total-7day">{{ number_format(array_sum(array_column($chartData,'total')), 0, ',', '.') }}</span>
                </div>
            </div>
            <div style="padding:12px 20px 16px;position:relative;height:270px">
                <canvas id="salesChart"></canvas>
            </div>
        </div>
    </div>

    {{-- Top Products (auto-refresh) --}}
    <div class="col-lg-4">
        <div class="dash-card h-100">
            <div class="dash-card-head">
                <div class="d-flex align-items-center gap-2">
                    <div class="head-icon" style="background:#fef9c3;color:#854d0e">
                        <i class="bi bi-trophy"></i>
                    </div>
                    Produk Terlaris Hari Ini
                </div>
            </div>
            <div id="top-products-list">
                @include('dashboard._top_products', ['topProducts' => $topProducts])
            </div>
        </div>
    </div>
</div>

{{-- ── PAYMENT DOUGHNUT + RECENT TRANSACTIONS ── --}}
<div class="row g-3 mb-4">

    {{-- Payment Method Doughnut --}}
    <div class="col-lg-4">
        <div class="dash-card h-100">
            <div class="dash-card-head">
                <div class="d-flex align-items-center gap-2">
                    <div class="head-icon" style="background:#eff6ff;color:#1d4ed8">
                        <i class="bi bi-pie-chart"></i>
                    </div>
                    Metode Bayar (Bulan Ini)
                </div>
            </div>
            <div style="padding:16px 20px;position:relative;height:200px">
                <canvas id="methodChart"></canvas>
            </div>
            <div id="payment-breakdown-labels" style="padding:0 20px 20px;display:flex;flex-direction:column;gap:8px">
                @foreach($paymentBreakdown as $method => $data)
                <div style="display:flex;justify-content:space-between;align-items:center">
                    <span class="method-pill mp-{{ $method }}">
                        <i class="bi bi-{{ $method === 'cash' ? 'cash' : ($method === 'transfer' ? 'bank' : 'qr-code-scan') }}"></i>
                        {{ $method }}
                    </span>
                    <div style="text-align:right">
                        <div class="pb-count" style="font-size:13px;font-weight:700;color:#1c1c1e">{{ $data['count'] }}x</div>
                        <div class="pb-total" style="font-size:11px;color:#9ca3af">Rp {{ number_format($data['total'], 0, ',', '.') }}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Recent Transactions (auto-refresh) --}}
    <div class="col-lg-8">
        <div class="dash-card h-100">
            <div class="dash-card-head">
                <div class="d-flex align-items-center gap-2">
                    <div class="head-icon" style="background:#f5f3ff;color:#7c3aed">
                        <i class="bi bi-clock-history"></i>
                    </div>
                    Transaksi Terbaru
                </div>
                <a href="{{ route('transactions.index') }}"
                   style="font-size:12px;font-weight:600;color:#3d6b4f;text-decoration:none">
                    Lihat Semua <i class="bi bi-arrow-right"></i>
                </a>
            </div>
            <div style="overflow-x:auto">
                <table class="table dash-table mb-0">
                    <thead>
                        <tr>
                            <th>Invoice</th>
                            <th class="d-none d-md-table-cell">Kasir</th>
                            <th>Total</th>
                            <th class="d-none d-sm-table-cell">Metode</th>
                            <th class="d-none d-md-table-cell">Waktu</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="recent-trx-tbody">
                        @forelse($recentTransactions as $trx)
                        <tr>
                            <td>
                                <span style="font-family:monospace;font-weight:600;color:#1c1c1e;font-size:12px">
                                    {{ $trx->invoice_number }}
                                </span>
                            </td>
                            <td class="d-none d-md-table-cell" style="color:#374151">{{ $trx->user->name }}</td>
                            <td style="font-weight:700;color:#3d6b4f">
                                Rp {{ number_format($trx->total, 0, ',', '.') }}
                            </td>
                            <td class="d-none d-sm-table-cell">
                                <span class="method-pill mp-{{ $trx->payment_method }}">
                                    {{ $trx->payment_method }}
                                </span>
                            </td>
                            <td class="d-none d-md-table-cell" style="color:#9ca3af;font-size:12px">
                                {{ $trx->created_at->format('d M H:i') }}
                            </td>
                            <td>
                                <a href="{{ route('transactions.show', $trx) }}"
                                   style="width:28px;height:28px;border-radius:7px;border:1px solid #e5e7eb;display:inline-flex;align-items:center;justify-content:center;color:#6b7280;text-decoration:none;font-size:13px">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" style="text-align:center;padding:40px;color:#9ca3af">
                                <i class="bi bi-receipt" style="font-size:28px;display:block;margin-bottom:8px"></i>
                                Belum ada transaksi
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- ── ADMIN ONLY: Stok Rendah + Shortcut ── --}}
@if(auth()->user()->isAdmin())
<div class="row g-3 mt-1">

    {{-- Shortcut Admin --}}
    <div class="col-lg-4">
        <div class="dash-card h-100">
            <div class="dash-card-head">
                <div class="d-flex align-items-center gap-2">
                    <div class="head-icon" style="background:#f5f3ff;color:#7c3aed">
                        <i class="bi bi-grid-3x3-gap"></i>
                    </div>
                    Akses Cepat Admin
                </div>
            </div>
            <div style="padding:16px;display:grid;grid-template-columns:1fr 1fr;gap:10px">
                <a href="{{ route('reports.index') }}"
                   style="display:flex;flex-direction:column;align-items:center;justify-content:center;gap:8px;background:#f0fdf4;border:1px solid #bbf7d0;border-radius:12px;padding:16px;text-decoration:none;transition:all .15s"
                   onmouseover="this.style.background='#dcfce7'" onmouseout="this.style.background='#f0fdf4'">
                    <i class="bi bi-bar-chart-line-fill" style="font-size:24px;color:#166534"></i>
                    <span style="font-size:12px;font-weight:700;color:#166534">Laporan</span>
                </a>
                <a href="{{ route('stock.index') }}"
                   style="display:flex;flex-direction:column;align-items:center;justify-content:center;gap:8px;background:#fffbeb;border:1px solid #fde68a;border-radius:12px;padding:16px;text-decoration:none;transition:all .15s"
                   onmouseover="this.style.background='#fef3c7'" onmouseout="this.style.background='#fffbeb'">
                    <i class="bi bi-boxes" style="font-size:24px;color:#92400e"></i>
                    <span style="font-size:12px;font-weight:700;color:#92400e">Kelola Stok</span>
                </a>
                <a href="{{ route('products.create') }}"
                   style="display:flex;flex-direction:column;align-items:center;justify-content:center;gap:8px;background:#eff6ff;border:1px solid #bfdbfe;border-radius:12px;padding:16px;text-decoration:none;transition:all .15s"
                   onmouseover="this.style.background='#dbeafe'" onmouseout="this.style.background='#eff6ff'">
                    <i class="bi bi-plus-circle-fill" style="font-size:24px;color:#1d4ed8"></i>
                    <span style="font-size:12px;font-weight:700;color:#1d4ed8">Tambah Produk</span>
                </a>
                <a href="{{ route('users.index') }}"
                   style="display:flex;flex-direction:column;align-items:center;justify-content:center;gap:8px;background:#faf5ff;border:1px solid #e9d5ff;border-radius:12px;padding:16px;text-decoration:none;transition:all .15s"
                   onmouseover="this.style.background='#f3e8ff'" onmouseout="this.style.background='#faf5ff'">
                    <i class="bi bi-person-gear" style="font-size:24px;color:#7c3aed"></i>
                    <span style="font-size:12px;font-weight:700;color:#7c3aed">Pengguna</span>
                </a>
            </div>
        </div>
    </div>

    {{-- Notifikasi Stok Rendah --}}
    <div class="col-lg-8">
        <div class="dash-card h-100">
            <div class="dash-card-head">
                <div class="d-flex align-items-center gap-2">
                    <div class="head-icon" style="background:#fef2f2;color:#dc2626">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                    </div>
                    <span>Notifikasi Stok Rendah</span>
                    @if($lowStock > 0)
                    <span style="background:#dc2626;color:#fff;font-size:11px;font-weight:700;padding:2px 8px;border-radius:20px">
                        {{ $lowStock }} produk
                    </span>
                    @endif
                </div>
                <a href="{{ route('stock.index', ['status' => 'low']) }}"
                   style="font-size:12px;font-weight:600;color:#dc2626;text-decoration:none">
                    Kelola Semua <i class="bi bi-arrow-right"></i>
                </a>
            </div>

            @if($lowStockProducts->isEmpty())
            <div style="padding:40px;text-align:center;color:#9ca3af">
                <i class="bi bi-check-circle-fill" style="font-size:32px;display:block;margin-bottom:10px;color:#22c55e"></i>
                <div style="font-size:13px;font-weight:600">Semua stok aman</div>
            </div>
            @else
            <div style="overflow-x:auto">
                <table class="table mb-0" style="font-size:13px">
                    <thead style="background:#fef2f2">
                        <tr>
                            <th style="padding:10px 16px;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.4px;color:#9ca3af;border:none">Produk</th>
                            <th style="padding:10px 16px;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.4px;color:#9ca3af;border:none">Kategori</th>
                            <th style="padding:10px 16px;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.4px;color:#9ca3af;border:none">Stok</th>
                            <th style="padding:10px 16px;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.4px;color:#9ca3af;border:none">Status</th>
                            <th style="padding:10px 16px;border:none"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($lowStockProducts as $prod)
                        <tr style="border-color:#fef2f2">
                            <td style="padding:10px 16px;font-weight:600;color:#1c1c1e;border-color:#fef2f2">{{ $prod->name }}</td>
                            <td style="padding:10px 16px;color:#6b7280;border-color:#fef2f2">{{ $prod->category->name ?? '-' }}</td>
                            <td style="padding:10px 16px;border-color:#fef2f2">
                                <span style="font-size:16px;font-weight:800;color:{{ $prod->stock == 0 ? '#dc2626' : '#92400e' }};font-family:monospace">
                                    {{ $prod->stock }}
                                </span>
                            </td>
                            <td style="padding:10px 16px;border-color:#fef2f2">
                                @if($prod->stock == 0)
                                    <span style="background:#fef2f2;color:#dc2626;padding:3px 10px;border-radius:20px;font-size:11px;font-weight:600">
                                        <i class="bi bi-x-circle-fill" style="font-size:9px"></i> Habis
                                    </span>
                                @else
                                    <span style="background:#fffbeb;color:#92400e;padding:3px 10px;border-radius:20px;font-size:11px;font-weight:600">
                                        <i class="bi bi-exclamation-triangle-fill" style="font-size:9px"></i> Rendah
                                    </span>
                                @endif
                            </td>
                            <td style="padding:10px 16px;border-color:#fef2f2">
                                <a href="{{ route('stock.index') }}"
                                   style="font-size:12px;font-weight:600;color:#3d6b4f;text-decoration:none">
                                    Update <i class="bi bi-arrow-right"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>
    </div>

</div>
@endif

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>
<script>
(function () {
    'use strict';

    /* ════════════════════════════════════════════
       1.  INITIAL DATA (from server)
    ════════════════════════════════════════════ */
    var initialChartData  = @json($chartData);
    var initialHourlyData = @json($hourlyData);
    var initialBreakdown  = @json($paymentBreakdown);

    var chartDataUrl = '{{ route("dashboard.chart-data") }}';
    var POLL_MS      = 30000; // 30 detik

    /* ════════════════════════════════════════════
       2.  HELPERS
    ════════════════════════════════════════════ */
    function fmtRp(n) {
        return 'Rp ' + Number(n).toLocaleString('id-ID');
    }
    function fmtRpShort(v) {
        if (v === 0)       return 'Rp 0';
        if (v >= 1000000)  return 'Rp ' + (v / 1000000).toFixed(1).replace('.0', '') + 'Jt';
        if (v >= 1000)     return 'Rp ' + Math.round(v / 1000) + 'K';
        return 'Rp ' + v;
    }
    function fmtRpFull(n) {
        return Number(n).toLocaleString('id-ID');
    }
    function methodIcon(m) {
        return m === 'cash' ? 'cash' : (m === 'transfer' ? 'bank' : 'qr-code-scan');
    }

    /* ════════════════════════════════════════════
       3.  BAR CHART — 7 HARI
    ════════════════════════════════════════════ */
    var salesCtx  = document.getElementById('salesChart').getContext('2d');
    var chartMode = '7day'; // '7day' | 'hourly'

    var salesChart = new Chart(salesCtx, {
        type: 'bar',
        data: {
            labels:   initialChartData.map(function(d){ return d.date; }),
            datasets: [{
                label:           'Penjualan',
                data:            initialChartData.map(function(d){ return d.total; }),
                backgroundColor: 'rgba(61,107,79,.55)',
                borderColor:     '#3d6b4f',
                borderWidth:     2,
                borderRadius:    8,
                borderSkipped:   false,
            }]
        },
        options: buildBarOptions(initialChartData.map(function(d){ return d.total; }))
    });

    /**
     * Hitung suggestedMax dari array nilai:
     * ambil nilai tertinggi lalu tambah ~20% padding ke atas
     * agar bar tidak mentok di tepi grafik.
     * Kalau semua 0, kembalikan nilai default kecil supaya grafik tetap tampil.
     */
    function calcSuggestedMax(values) {
        var max = Math.max.apply(null, values.concat([0]));
        if (max === 0) return 50000; // default ketika belum ada transaksi
        // Bulatkan ke atas ke satuan "cantik" (10K, 100K, 1Jt, dst)
        var padded = max * 1.25;
        var magnitude = Math.pow(10, Math.floor(Math.log10(padded)));
        return Math.ceil(padded / magnitude) * magnitude;
    }

    function buildBarOptions(values) {
        return {
            responsive: true,
            maintainAspectRatio: false,
            animation: { duration: 600, easing: 'easeInOutQuart' },
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: function(ctx) { return ' ' + fmtRp(ctx.raw); }
                    },
                    backgroundColor: '#1c1c1e',
                    titleColor:      '#e5e5ea',
                    bodyColor:       '#a1a1aa',
                    padding:         10,
                    cornerRadius:    8,
                }
            },
            scales: {
                y: {
                    beginAtZero:  true,
                    suggestedMax: calcSuggestedMax(values || []),
                    ticks: {
                        callback: fmtRpShort,
                        color:    '#9ca3af',
                        font:     { size: 11 },
                        maxTicksLimit: 6,
                    },
                    grid:   { color: '#f3f4f6' },
                    border: { display: false }
                },
                x: {
                    ticks: { color: '#9ca3af', font: { size: 11 } },
                    grid:  { display: false },
                    border:{ display: false }
                }
            }
        };
    }

    /** Update suggestedMax saat data berubah (tab switch / polling) */
    function applySuggestedMax(values) {
        salesChart.options.scales.y.suggestedMax = calcSuggestedMax(values);
    }

    /* ════════════════════════════════════════════
       4.  TAB SWITCH: 7 hari ↔ per jam
    ════════════════════════════════════════════ */
    window.switchChart = function(mode) {
        chartMode = mode;
        document.getElementById('btn-7day').classList.toggle('active', mode === '7day');
        document.getElementById('btn-hourly').classList.toggle('active', mode === 'hourly');

        var newValues;
        if (mode === '7day') {
            salesChart.data.labels   = initialChartData.map(function(d){ return d.date; });
            newValues = initialChartData.map(function(d){ return d.total; });
        } else {
            var now = new Date().getHours();
            var filtered = initialHourlyData.filter(function(d, i){ return i <= now; });
            salesChart.data.labels = filtered.map(function(d){ return d.hour; });
            newValues = filtered.map(function(d){ return d.total; });
        }
        salesChart.data.datasets[0].data = newValues;
        applySuggestedMax(newValues);
        salesChart.update();
    };

    /* ════════════════════════════════════════════
       5.  DOUGHNUT CHART — metode bayar
    ════════════════════════════════════════════ */
    var mKeys   = ['cash', 'transfer', 'qris'];
    var mColors = { cash: '#3d6b4f', transfer: '#2563eb', qris: '#7c3aed' };

    var methodChartInstance = null;

    function buildMethodChart(breakdown) {
        var vals = mKeys.map(function(k){ return breakdown[k] ? breakdown[k].count : 0; });
        var hasData = vals.reduce(function(a, b){ return a + b; }, 0) > 0;
        if (!hasData) return;

        var ctx = document.getElementById('methodChart').getContext('2d');

        if (methodChartInstance) {
            methodChartInstance.data.datasets[0].data = vals;
            methodChartInstance.update('active');
            return;
        }

        methodChartInstance = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels:   mKeys.map(function(l){ return l.charAt(0).toUpperCase() + l.slice(1); }),
                datasets: [{
                    data:            vals,
                    backgroundColor: mKeys.map(function(k){ return mColors[k]; }),
                    borderWidth:     0,
                    hoverOffset:     6,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout:    '68%',
                animation: { duration: 600 },
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            font:            { size: 11, weight: '600' },
                            color:           '#6b7280',
                            padding:         14,
                            usePointStyle:   true,
                            pointStyleWidth: 8,
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(ctx) {
                                return ' ' + ctx.label + ': ' + ctx.raw + ' transaksi';
                            }
                        },
                        backgroundColor: '#1c1c1e',
                        padding:         10,
                        cornerRadius:    8,
                    }
                }
            }
        });
    }

    buildMethodChart(initialBreakdown);

    /* ════════════════════════════════════════════
       6.  UPDATE DOM — stat cards
    ════════════════════════════════════════════ */
    function updateStatCards(data) {
        document.getElementById('stat-today-sales').textContent =
            'Rp ' + fmtRpFull(data.todaySales);
        document.getElementById('stat-today-trx').textContent =
            data.todayTransactions;
        document.getElementById('stat-month-sales').textContent =
            'Rp ' + fmtRpFull(data.monthSales);
        document.getElementById('stat-month-trx').textContent =
            data.monthTransactions;

        var lowSub = document.getElementById('stat-low-stock-sub');
        if (data.lowStock > 0) {
            lowSub.innerHTML = '<i class="bi bi-exclamation-triangle-fill"></i>' +
                data.lowStock + ' stok hampir habis';
        } else {
            lowSub.innerHTML = '<i class="bi bi-check2-circle"></i>Semua stok aman';
        }
    }

    /* ════════════════════════════════════════════
       7.  UPDATE DOM — sales chart data
    ════════════════════════════════════════════ */
    function updateSalesChart(data) {
        initialChartData  = data.chartData;
        initialHourlyData = data.hourlyData;

        var total7 = data.chartData.reduce(function(s, d){ return s + d.total; }, 0);
        document.getElementById('chart-total-7day').textContent = fmtRpFull(total7);

        var newValues;
        if (chartMode === '7day') {
            salesChart.data.labels = data.chartData.map(function(d){ return d.date; });
            newValues = data.chartData.map(function(d){ return d.total; });
        } else {
            var now2 = new Date().getHours();
            var filtered2 = data.hourlyData.filter(function(d, i){ return i <= now2; });
            salesChart.data.labels = filtered2.map(function(d){ return d.hour; });
            newValues = filtered2.map(function(d){ return d.total; });
        }
        salesChart.data.datasets[0].data = newValues;
        applySuggestedMax(newValues);
        salesChart.update('active');
    }

    /* ════════════════════════════════════════════
       8.  UPDATE DOM — payment breakdown labels
    ════════════════════════════════════════════ */
    function updatePaymentLabels(breakdown) {
        var rows = document.querySelectorAll('#payment-breakdown-labels > div');
        mKeys.forEach(function(k, i) {
            if (!rows[i]) return;
            var d = breakdown[k] || { count: 0, total: 0 };
            rows[i].querySelector('.pb-count').textContent = d.count + 'x';
            rows[i].querySelector('.pb-total').textContent = 'Rp ' + fmtRpFull(d.total);
        });
        buildMethodChart(breakdown);
    }

    /* ════════════════════════════════════════════
       9.  UPDATE DOM — top products
    ════════════════════════════════════════════ */
    function updateTopProducts(products) {
        var rankClasses = ['rank-1','rank-2','rank-3','rank-n','rank-n'];
        var maxQty = products.reduce(function(m, p){ return Math.max(m, p.total_qty); }, 1);

        if (!products.length) {
            document.getElementById('top-products-list').innerHTML =
                '<div style="padding:40px 20px;text-align:center;color:#9ca3af">' +
                '<i class="bi bi-inbox" style="font-size:32px;display:block;margin-bottom:8px"></i>' +
                '<div style="font-size:13px">Belum ada penjualan hari ini</div></div>';
            return;
        }

        var html = products.map(function(p, i) {
            var pct = Math.round(p.total_qty / maxQty * 100);
            return '<div class="top-prod-row">' +
                '<div class="rank-badge ' + (rankClasses[i] || 'rank-n') + '">' + (i+1) + '</div>' +
                '<div style="flex:1;min-width:0">' +
                  '<div style="font-size:13px;font-weight:600;color:#1c1c1e;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">' + escHtml(p.name) + '</div>' +
                  '<div class="prog-bar"><div class="prog-fill" style="width:' + pct + '%"></div></div>' +
                '</div>' +
                '<div style="text-align:right;flex-shrink:0">' +
                  '<div style="font-size:12px;font-weight:700;color:#3d6b4f">' + p.total_qty + 'x</div>' +
                  '<div style="font-size:11px;color:#9ca3af">Rp ' + fmtRpFull(p.total_revenue) + '</div>' +
                '</div>' +
              '</div>';
        }).join('');
        document.getElementById('top-products-list').innerHTML = html;
    }

    /* ════════════════════════════════════════════
       10. UPDATE DOM — recent transactions
    ════════════════════════════════════════════ */
    function updateRecentTrx(transactions) {
        if (!transactions.length) return;

        var html = transactions.map(function(t) {
            var mpClass = 'mp-' + t.payment_method;
            return '<tr>' +
                '<td><span style="font-family:monospace;font-weight:600;color:#1c1c1e;font-size:12px">' +
                    escHtml(t.invoice_number) + '</span></td>' +
                '<td class="d-none d-md-table-cell" style="color:#374151">' + escHtml(t.cashier) + '</td>' +
                '<td style="font-weight:700;color:#3d6b4f">Rp ' + fmtRpFull(t.total) + '</td>' +
                '<td class="d-none d-sm-table-cell">' +
                    '<span class="method-pill ' + mpClass + '">' + escHtml(t.payment_method) + '</span>' +
                '</td>' +
                '<td class="d-none d-md-table-cell" style="color:#9ca3af;font-size:12px">' + escHtml(t.created_at) + '</td>' +
                '<td><a href="' + escHtml(t.show_url) + '" ' +
                    'style="width:28px;height:28px;border-radius:7px;border:1px solid #e5e7eb;display:inline-flex;align-items:center;justify-content:center;color:#6b7280;text-decoration:none;font-size:13px">' +
                    '<i class="bi bi-eye"></i></a></td>' +
              '</tr>';
        }).join('');
        document.getElementById('recent-trx-tbody').innerHTML = html;
    }

    /* ════════════════════════════════════════════
       11. XSS guard helper
    ════════════════════════════════════════════ */
    function escHtml(str) {
        return String(str)
            .replace(/&/g,'&amp;')
            .replace(/</g,'&lt;')
            .replace(/>/g,'&gt;')
            .replace(/"/g,'&quot;')
            .replace(/'/g,'&#039;');
    }

    /* ════════════════════════════════════════════
       12. POLLING — fetch + update setiap 30 detik
    ════════════════════════════════════════════ */
    var badge = document.getElementById('rt-badge');

    function fetchAndRefresh() {
        badge.classList.add('is-refreshing');

        fetch(chartDataUrl, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept':           'application/json',
                'X-CSRF-TOKEN':     document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
            credentials: 'same-origin',
        })
        .then(function(res) {
            if (!res.ok) throw new Error('HTTP ' + res.status);
            return res.json();
        })
        .then(function(data) {
            updateStatCards(data);
            updateSalesChart(data);
            updatePaymentLabels(data.paymentBreakdown);
            updateTopProducts(data.topProducts);
            updateRecentTrx(data.recentTransactions);

            document.getElementById('last-updated-time').textContent = data.timestamp;
            badge.classList.remove('is-refreshing');
        })
        .catch(function(err) {
            console.warn('[Dashboard] Refresh gagal:', err);
            badge.classList.remove('is-refreshing');
        });
    }

    // Mulai polling
    setInterval(fetchAndRefresh, POLL_MS);

})();
</script>
@endpush
