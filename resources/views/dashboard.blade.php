@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@push('styles')
<style>
/* ════════════════════════════════════════
   SKOTE DASHBOARD STYLES
════════════════════════════════════════ */

/* ── Mini stat cards (Skote style) ── */
.sk-stat-card {
    background: #fff;
    border: 1px solid var(--sk-border);
    border-radius: var(--sk-card-radius);
    padding: 20px;
    box-shadow: 0 2px 6px rgba(0,0,0,.04);
    display: flex;
    align-items: center;
    gap: 16px;
    overflow: hidden;
    position: relative;
    transition: box-shadow .2s;
}
.sk-stat-card:hover { box-shadow: 0 4px 18px rgba(0,0,0,.08); }

.sk-stat-icon {
    width: 52px; height: 52px;
    border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 22px;
    flex-shrink: 0;
}

.sk-stat-body { flex: 1; min-width: 0; }
.sk-stat-val {
    font-size: 20px;
    font-weight: 800;
    color: var(--sk-heading);
    line-height: 1;
    margin-bottom: 5px;
    letter-spacing: -.3px;
    transition: opacity .25s;
}
.sk-stat-lbl {
    font-size: 12.5px;
    color: var(--sk-muted);
    font-weight: 600;
    margin-bottom: 8px;
}
.sk-stat-badge {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    font-size: 11px;
    font-weight: 700;
    padding: 2px 8px;
    border-radius: 20px;
}
.badge-success-soft { background: #d1fae5; color: #065f46; }
.badge-primary-soft { background: #e0e7ff; color: #3730a3; }
.badge-warning-soft { background: #fef3c7; color: #92400e; }
.badge-danger-soft  { background: #fee2e2; color: #991b1b; }

/* Icon backgrounds */
.si-primary { background: rgba(85,110,230,.12); color: var(--sk-primary); }
.si-success { background: rgba(52,195,143,.12); color: var(--sk-success); }
.si-warning { background: rgba(241,180,76,.12); color: var(--sk-warning); }
.si-danger  { background: rgba(244,106,106,.12); color: var(--sk-danger); }
.si-info    { background: rgba(80,165,241,.12); color: var(--sk-info); }
.si-pink    { background: rgba(232,62,140,.12); color: var(--sk-pink); }

/* Watermark icon */
.sk-stat-card .wm-icon {
    position: absolute;
    right: -8px; bottom: -8px;
    font-size: 72px;
    opacity: .05;
    color: currentColor;
    pointer-events: none;
    line-height: 1;
}

/* ── Real-time badge ── */
.rt-badge {
    display: inline-flex; align-items: center; gap: 5px;
    font-size: 11px; font-weight: 700;
    color: var(--sk-success);
    background: rgba(52,195,143,.12);
    border-radius: 20px; padding: 3px 10px;
    white-space: nowrap;
}
.rt-dot {
    width: 7px; height: 7px;
    background: var(--sk-success); border-radius: 50%;
    animation: rtpulse 1.5s ease-in-out infinite;
}
@keyframes rtpulse {
    0%,100% { opacity:1; transform:scale(1); }
    50%      { opacity:.4; transform:scale(.7); }
}
.rt-spinner {
    display: none; width: 12px; height: 12px;
    border: 2px solid rgba(52,195,143,.25);
    border-top-color: var(--sk-success);
    border-radius: 50%;
    animation: spin .6s linear infinite;
}
@keyframes spin { to { transform: rotate(360deg); } }
.is-refreshing .rt-spinner { display: inline-block; }
.is-refreshing .rt-dot     { display: none; }

/* ── Chart tab buttons ── */
.sk-tab-btn {
    padding: 4px 14px;
    border-radius: 20px;
    font-size: 12px; font-weight: 600;
    border: 1px solid var(--sk-border);
    background: #fff; color: var(--sk-muted);
    cursor: pointer; transition: all .15s;
}
.sk-tab-btn.active {
    background: var(--sk-primary);
    border-color: var(--sk-primary);
    color: #fff;
}

/* ── Card header util ── */
.sk-card-hd {
    display: flex; align-items: center; justify-content: space-between;
    padding: 16px 20px;
    border-bottom: 1px solid var(--sk-border);
}
.sk-card-hd-title {
    display: flex; align-items: center; gap: 10px;
    font-size: 14px; font-weight: 700; color: var(--sk-heading);
}
.sk-card-hd-icon {
    width: 32px; height: 32px; border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    font-size: 14px; flex-shrink: 0;
}

/* ── Top products ── */
.tp-row {
    display: flex; align-items: center; gap: 12px;
    padding: 11px 20px;
    border-bottom: 1px solid var(--sk-border);
    transition: background .12s;
}
.tp-row:last-child { border-bottom: none; }
.tp-row:hover { background: #f8f9fc; }
.tp-rank {
    width: 26px; height: 26px; border-radius: 7px;
    display: flex; align-items: center; justify-content: center;
    font-size: 12px; font-weight: 800; flex-shrink: 0;
}
.tp-r1 { background: #fef3c7; color: #92400e; }
.tp-r2 { background: #e0e7ff; color: #3730a3; }
.tp-r3 { background: #d1fae5; color: #065f46; }
.tp-rn { background: #f3f4f6; color: #6b7280; }
.tp-prog { height: 4px; background: #f1f1f1; border-radius: 4px; overflow: hidden; margin-top: 4px; }
.tp-prog-fill { height: 100%; border-radius: 4px; background: var(--sk-primary); transition: width .5s ease; }

/* ── Method pills ── */
.mp { display: inline-flex; align-items: center; gap: 4px; padding: 2px 9px; border-radius: 20px; font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: .3px; }
.mp-cash     { background: #d1fae5; color: #065f46; }
.mp-transfer { background: #e0e7ff; color: #3730a3; }
.mp-qris     { background: #f3e8ff; color: #6b21a8; }

/* ── Skote table ── */
.sk-table th {
    font-size: 11px; font-weight: 700;
    text-transform: uppercase; letter-spacing: .5px;
    color: var(--sk-muted); padding: 10px 16px;
    border-top: none; background: #f8f9fc;
}
.sk-table td { padding: 12px 16px; vertical-align: middle; border-color: var(--sk-border); font-size: 13px; }
.sk-table tbody tr:hover { background: #f8f9fc; }

/* ── Progress bar ── */
.sk-prog { height: 4px; background: #f1f1f1; border-radius: 4px; overflow: hidden; }
.sk-prog-fill { height: 100%; border-radius: 4px; transition: width .5s ease; }

/* ── Shortcut card ── */
.sk-shortcut {
    display: flex; flex-direction: column;
    align-items: center; justify-content: center;
    gap: 8px; padding: 18px 10px;
    border-radius: 10px; text-decoration: none;
    transition: all .15s; border: 1.5px solid transparent;
    text-align: center;
}
.sk-shortcut:hover { transform: translateY(-2px); box-shadow: 0 6px 18px rgba(0,0,0,.1); }
.sk-shortcut i { font-size: 26px; }
.sk-shortcut span { font-size: 12px; font-weight: 700; }

/* ── Last updated ── */
.sk-last-upd { font-size: 11px; color: var(--sk-muted); font-weight: 500; }

/* ── Responsive ── */
@media (max-width: 768px) {
    .sk-stat-card { padding: 14px; gap: 12px; }
    .sk-stat-icon { width: 44px; height: 44px; font-size: 19px; }
    .sk-stat-val { font-size: 17px; }
    .sk-card-hd { padding: 12px 16px; }
    .tp-row { padding: 10px 14px; }
    .sk-table th, .sk-table td { padding: 9px 12px; font-size: 12px; }
}
@media (max-width: 480px) {
    .sk-stat-val { font-size: 15px; }
    .wm-icon { display: none; }
}

/* ════════════════════════════════════════
   STOCK ALERT BANNER
════════════════════════════════════════ */
.stock-alert-banner {
    display: flex;
    align-items: flex-start;
    gap: 14px;
    padding: 16px 20px;
    background: linear-gradient(135deg, #fff7ed 0%, #fef2f2 100%);
    border: 1.5px solid #fca5a5;
    border-left: 5px solid #ef4444;
    border-radius: 12px;
    box-shadow: 0 4px 16px rgba(239,68,68,.12);
    animation: bannerSlideIn .4s ease;
}
@keyframes bannerSlideIn {
    from { opacity: 0; transform: translateY(-12px); }
    to   { opacity: 1; transform: translateY(0); }
}
.sab-icon {
    width: 42px; height: 42px;
    background: #fee2e2;
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    font-size: 20px; color: #ef4444;
    flex-shrink: 0;
    animation: sabPulse 2s ease-in-out infinite;
}
@keyframes sabPulse {
    0%,100% { box-shadow: 0 0 0 0 rgba(239,68,68,.3); }
    50%      { box-shadow: 0 0 0 8px rgba(239,68,68,0); }
}
.sab-body { flex: 1; min-width: 0; }
.sab-title {
    font-size: 14px; font-weight: 800;
    color: #7f1d1d;
    margin-bottom: 8px;
    display: flex; align-items: center; gap: 8px;
}
.sab-count {
    background: #ef4444; color: #fff;
    font-size: 11px; font-weight: 700;
    padding: 2px 8px; border-radius: 20px;
}
.sab-list {
    display: flex; flex-wrap: wrap; gap: 6px;
}
.sab-pill {
    display: inline-flex; align-items: center; gap: 5px;
    font-size: 12px; font-weight: 600;
    padding: 4px 10px; border-radius: 20px;
}
.sab-pill i { font-size: 11px; }
.sab-pill-danger  { background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; }
.sab-pill-warning { background: #fef3c7; color: #92400e; border: 1px solid #fde68a; }
.sab-pill-more    { background: #f3f4f6; color: #6b7280; border: 1px solid #e5e7eb; }
.sab-actions {
    display: flex; align-items: center; gap: 8px;
    flex-shrink: 0;
}
.sab-btn-manage {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 8px 16px;
    background: #ef4444; color: #fff;
    border-radius: 8px; border: none;
    font-size: 13px; font-weight: 700;
    text-decoration: none; cursor: pointer;
    transition: all .2s;
}
.sab-btn-manage:hover { background: #dc2626; color: #fff; transform: translateY(-1px); }
.sab-btn-close {
    width: 32px; height: 32px;
    background: rgba(239,68,68,.1); border: 1px solid #fca5a5;
    border-radius: 8px; cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    font-size: 13px; color: #ef4444;
    transition: all .15s;
}
.sab-btn-close:hover { background: #fee2e2; }

/* ════════════════════════════════════════
   STOCK MODAL (kasir)
════════════════════════════════════════ */
.stk-modal-overlay {
    position: fixed; inset: 0;
    background: rgba(0,0,0,.45);
    backdrop-filter: blur(3px);
    z-index: 9999;
    display: none; /* JS akan set flex saat siap */
    align-items: center; justify-content: center;
    padding: 16px;
    animation: overlayFadeIn .3s ease;
}
@keyframes overlayFadeIn {
    from { opacity: 0; } to { opacity: 1; }
}
.stk-modal {
    background: #fff;
    border-radius: 20px;
    width: 100%; max-width: 480px;
    max-height: 80vh;
    display: flex; flex-direction: column;
    box-shadow: 0 24px 60px rgba(0,0,0,.2);
    animation: modalPopIn .35s cubic-bezier(.34,1.56,.64,1);
    overflow: hidden;
}
@keyframes modalPopIn {
    from { opacity: 0; transform: scale(.85) translateY(20px); }
    to   { opacity: 1; transform: scale(1) translateY(0); }
}
.stk-modal-hd {
    display: flex; align-items: center; gap: 14px;
    padding: 20px 24px;
    background: linear-gradient(135deg, #fef2f2, #fff7ed);
    border-bottom: 1px solid #fee2e2;
    flex-shrink: 0;
}
.stk-modal-hd-icon {
    width: 48px; height: 48px;
    background: #fee2e2; border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 22px; color: #ef4444;
    flex-shrink: 0;
    animation: sabPulse 2s ease-in-out infinite;
}
.stk-modal-hd-title { font-size: 16px; font-weight: 800; color: #7f1d1d; }
.stk-modal-hd-sub   { font-size: 12px; color: #b91c1c; margin-top: 2px; }
.stk-modal-close {
    margin-left: auto;
    width: 32px; height: 32px;
    background: rgba(239,68,68,.1); border: none;
    border-radius: 8px; cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    font-size: 13px; color: #ef4444;
    transition: background .15s; flex-shrink: 0;
}
.stk-modal-close:hover { background: #fee2e2; }
.stk-modal-body {
    overflow-y: auto; flex: 1;
    padding: 8px 0;
}
.stk-modal-row {
    display: flex; align-items: center; justify-content: space-between;
    padding: 12px 24px;
    border-bottom: 1px solid #f3f4f6;
    transition: background .12s;
}
.stk-modal-row:last-child { border-bottom: none; }
.stk-modal-row:hover { background: #fafafa; }
.stk-row-danger  { border-left: 3px solid #ef4444; }
.stk-row-warning { border-left: 3px solid #f59e0b; }
.stk-row-name { font-size: 14px; font-weight: 700; color: #111827; }
.stk-row-cat  { font-size: 12px; color: #9ca3af; margin-top: 2px; }
.stk-row-right { display: flex; align-items: center; gap: 10px; flex-shrink: 0; }
.stk-row-qty {
    font-size: 22px; font-weight: 900;
    font-family: monospace; line-height: 1;
}
.qty-zero { color: #ef4444; }
.qty-low  { color: #f59e0b; }
.stk-badge {
    font-size: 11px; font-weight: 700;
    padding: 3px 9px; border-radius: 20px;
}
.stk-badge-danger  { background: #fee2e2; color: #991b1b; }
.stk-badge-warning { background: #fef3c7; color: #92400e; }
.stk-modal-ft {
    padding: 16px 24px;
    border-top: 1px solid #f3f4f6;
    background: #fafafa;
    flex-shrink: 0;
}
.stk-modal-note {
    font-size: 12px; color: #6b7280;
    display: flex; align-items: flex-start; gap: 6px;
    margin-bottom: 12px; line-height: 1.5;
}
.stk-modal-note i { color: #3b82f6; flex-shrink: 0; margin-top: 2px; }
.stk-btn-ok {
    width: 100%; height: 44px;
    background: linear-gradient(135deg, #ef4444, #dc2626);
    color: #fff; border: none; border-radius: 10px;
    font-size: 14px; font-weight: 700; cursor: pointer;
    transition: all .2s;
}
.stk-btn-ok:hover { background: linear-gradient(135deg, #dc2626, #b91c1c); transform: translateY(-1px); }

@media (max-width: 600px) {
    .stock-alert-banner { flex-wrap: wrap; }
    .sab-actions { width: 100%; justify-content: flex-end; }
    .stk-modal { max-width: 100%; border-radius: 16px 16px 0 0; max-height: 90vh; }
    .stk-modal-overlay { align-items: flex-end; padding: 0; }
}
</style>
@endpush

@section('content')

{{-- ── PAGE HEADER ── --}}
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h4 class="mb-1" style="font-size:20px;font-weight:800;color:var(--sk-heading)">Dashboard</h4>
        <div class="sk-breadcrumb">
            <span>Donik Donuts</span>
            <span class="bc-sep"><i class="bi bi-chevron-right" style="font-size:10px"></i></span>
            <span class="bc-active">Dashboard</span>
        </div>
    </div>
    <div class="d-flex align-items-center gap-2">
        <span class="rt-badge" id="rt-badge">
            <span class="rt-dot"></span>
            <span class="rt-spinner"></span>
            Live
        </span>
        <span class="sk-last-upd d-none d-md-inline">
            Update: <span id="last-updated-time">{{ now()->format('H:i:s') }}</span>
        </span>
    </div>
</div>

{{-- ── NOTIFIKASI STOK RENDAH (semua role) ── --}}
@if($lowStock > 0)
<div id="stock-alert-banner" class="stock-alert-banner mb-4">
    <div class="sab-icon">
        <i class="bi bi-exclamation-triangle-fill"></i>
    </div>
    <div class="sab-body">
        <div class="sab-title">
            Peringatan Stok Menipis!
            <span class="sab-count">{{ $lowStock }} produk</span>
        </div>
        <div class="sab-list">
            @foreach($lowStockProducts->take(5) as $prod)
            <span class="sab-pill {{ $prod->stock == 0 ? 'sab-pill-danger' : 'sab-pill-warning' }}">
                <i class="bi bi-box-seam"></i>
                {{ $prod->name }}
                <strong>{{ $prod->stock == 0 ? 'Habis' : 'Sisa '.$prod->stock }}</strong>
            </span>
            @endforeach
            @if($lowStockProducts->count() > 5)
            <span class="sab-pill sab-pill-more">+{{ $lowStockProducts->count() - 5 }} lainnya</span>
            @endif
        </div>
    </div>
    <div class="sab-actions">
        @if(auth()->user()->isAdmin())
        <a href="{{ route('stock.index', ['status'=>'low']) }}" class="sab-btn-manage">
            <i class="bi bi-arrow-up-circle"></i> Kelola Stok
        </a>
        @endif
        <button class="sab-btn-close" onclick="dismissStockAlert()" title="Tutup">
            <i class="bi bi-x-lg"></i>
        </button>
    </div>
</div>

{{-- Modal detail stok rendah (kasir) ── --}}
@if(!auth()->user()->isAdmin())
<div id="stock-modal-overlay" class="stk-modal-overlay" onclick="closeStockModal()">
    <div class="stk-modal" onclick="event.stopPropagation()">
        <div class="stk-modal-hd">
            <div class="stk-modal-hd-icon">
                <i class="bi bi-exclamation-triangle-fill"></i>
            </div>
            <div>
                <div class="stk-modal-hd-title">Stok Produk Menipis</div>
                <div class="stk-modal-hd-sub">{{ $lowStock }} produk perlu diperhatikan</div>
            </div>
            <button class="stk-modal-close" onclick="closeStockModal()">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
        <div class="stk-modal-body">
            @foreach($lowStockProducts as $prod)
            <div class="stk-modal-row {{ $prod->stock == 0 ? 'stk-row-danger' : 'stk-row-warning' }}">
                <div class="stk-row-info">
                    <div class="stk-row-name">{{ $prod->name }}</div>
                    <div class="stk-row-cat">{{ $prod->category->name ?? '-' }}</div>
                </div>
                <div class="stk-row-right">
                    <div class="stk-row-qty {{ $prod->stock == 0 ? 'qty-zero' : 'qty-low' }}">
                        {{ $prod->stock }}
                    </div>
                    @if($prod->stock == 0)
                        <span class="stk-badge stk-badge-danger">Habis</span>
                    @else
                        <span class="stk-badge stk-badge-warning">Rendah</span>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        <div class="stk-modal-ft">
            <p class="stk-modal-note">
                <i class="bi bi-info-circle"></i>
                Segera informasikan kepada admin untuk mengisi ulang stok.
            </p>
            <button class="stk-btn-ok" onclick="closeStockModal()">Mengerti</button>
        </div>
    </div>
</div>
@endif
@endif

{{-- ── STAT CARDS ── --}}
<div class="row g-3 mb-4">

    <div class="col-sm-6 col-xl-3">
        <div class="sk-stat-card">
            <div class="sk-stat-icon si-primary">
                <i class="bi bi-currency-dollar"></i>
            </div>
            <div class="sk-stat-body">
                <div class="sk-stat-val" id="stat-today-sales">Rp {{ number_format($todaySales,0,',','.') }}</div>
                <div class="sk-stat-lbl">Penjualan Hari Ini</div>
                <span class="sk-stat-badge badge-primary-soft">
                    <i class="bi bi-receipt" style="font-size:10px"></i>
                    <span id="stat-today-trx">{{ $todayTransactions }}</span> transaksi
                </span>
            </div>
            <i class="bi bi-currency-dollar wm-icon" style="color:var(--sk-primary)"></i>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="sk-stat-card">
            <div class="sk-stat-icon si-success">
                <i class="bi bi-graph-up-arrow"></i>
            </div>
            <div class="sk-stat-body">
                <div class="sk-stat-val" id="stat-month-sales">Rp {{ number_format($monthSales,0,',','.') }}</div>
                <div class="sk-stat-lbl">Penjualan Bulan Ini</div>
                <span class="sk-stat-badge badge-success-soft">
                    <i class="bi bi-calendar3" style="font-size:10px"></i>
                    <span id="stat-month-trx">{{ $monthTransactions }}</span> transaksi
                </span>
            </div>
            <i class="bi bi-graph-up-arrow wm-icon" style="color:var(--sk-success)"></i>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="sk-stat-card">
            <div class="sk-stat-icon si-warning">
                <i class="bi bi-box-seam"></i>
            </div>
            <div class="sk-stat-body">
                <div class="sk-stat-val">{{ $totalProducts }}</div>
                <div class="sk-stat-lbl">Produk Aktif</div>
                <span class="sk-stat-badge {{ $lowStock > 0 ? 'badge-danger-soft' : 'badge-success-soft' }}" id="stat-low-stock-sub">
                    @if($lowStock > 0)
                        <i class="bi bi-exclamation-triangle-fill" style="font-size:10px"></i> {{ $lowStock }} stok rendah
                    @else
                        <i class="bi bi-check2-circle" style="font-size:10px"></i> Stok aman
                    @endif
                </span>
            </div>
            <i class="bi bi-box-seam wm-icon" style="color:var(--sk-warning)"></i>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="sk-stat-card">
            <div class="sk-stat-icon si-info">
                <i class="bi bi-people"></i>
            </div>
            <div class="sk-stat-body">
                <div class="sk-stat-val">{{ $totalUsers }}</div>
                <div class="sk-stat-lbl">Total Pengguna</div>
                <span class="sk-stat-badge badge-primary-soft">
                    <i class="bi bi-shield-check" style="font-size:10px"></i> Sistem aktif
                </span>
            </div>
            <i class="bi bi-people wm-icon" style="color:var(--sk-info)"></i>
        </div>
    </div>

</div>

{{-- ── CHART + TOP PRODUCTS ── --}}
<div class="row g-3 mb-4">

    {{-- Grafik Penjualan --}}
    <div class="col-xl-8">
        <div class="card h-100 mb-0">
            <div class="sk-card-hd">
                <div class="sk-card-hd-title">
                    <div class="sk-card-hd-icon si-primary"><i class="bi bi-bar-chart-line"></i></div>
                    Grafik Penjualan
                </div>
                <div class="d-flex align-items-center gap-2">
                    <button class="sk-tab-btn active" id="btn-7day" onclick="switchChart('7day')">7 Hari</button>
                    <button class="sk-tab-btn" id="btn-hourly" onclick="switchChart('hourly')">Per Jam</button>
                </div>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="sk-last-upd">Diperbarui: <span id="last-updated-time2">{{ now()->format('H:i:s') }}</span></span>
                    <span style="font-size:12px;color:var(--sk-muted)">
                        Total 7 hari: <strong style="color:var(--sk-heading)">Rp <span id="chart-total-7day">{{ number_format(array_sum(array_column($chartData,'total')),0,',','.') }}</span></strong>
                    </span>
                </div>
                <div style="position:relative;height:280px">
                    <canvas id="salesChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- Top Products --}}
    <div class="col-xl-4">
        <div class="card h-100 mb-0">
            <div class="sk-card-hd">
                <div class="sk-card-hd-title">
                    <div class="sk-card-hd-icon si-warning"><i class="bi bi-trophy"></i></div>
                    Produk Terlaris
                </div>
                <span style="font-size:11px;color:var(--sk-muted)">Hari ini</span>
            </div>
            <div id="top-products-list">
                @include('dashboard._top_products', ['topProducts' => $topProducts])
            </div>
        </div>
    </div>

</div>

{{-- ── PAYMENT BREAKDOWN + RECENT TRANSACTIONS ── --}}
<div class="row g-3 mb-4">

    {{-- Doughnut metode bayar --}}
    <div class="col-xl-4">
        <div class="card h-100 mb-0">
            <div class="sk-card-hd">
                <div class="sk-card-hd-title">
                    <div class="sk-card-hd-icon si-info"><i class="bi bi-pie-chart"></i></div>
                    Metode Bayar
                </div>
                <span style="font-size:11px;color:var(--sk-muted)">Bulan ini</span>
            </div>
            <div class="card-body">
                <div style="position:relative;height:200px">
                    <canvas id="methodChart"></canvas>
                </div>
                <div id="payment-breakdown-labels" class="mt-3 d-flex flex-column gap-2">
                    @foreach($paymentBreakdown as $method => $data)
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="mp mp-{{ $method }}">
                            <i class="bi bi-{{ $method==='cash'?'cash':($method==='transfer'?'bank':'qr-code-scan') }}"></i>
                            {{ ucfirst($method) }}
                        </span>
                        <div class="text-end">
                            <div class="pb-count" style="font-size:13px;font-weight:700;color:var(--sk-heading)">{{ $data['count'] }}x</div>
                            <div class="pb-total" style="font-size:11px;color:var(--sk-muted)">Rp {{ number_format($data['total'],0,',','.') }}</div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- Transaksi terbaru --}}
    <div class="col-xl-8">
        <div class="card h-100 mb-0">
            <div class="sk-card-hd">
                <div class="sk-card-hd-title">
                    <div class="sk-card-hd-icon" style="background:rgba(232,62,140,.1);color:var(--sk-pink)"><i class="bi bi-clock-history"></i></div>
                    Transaksi Terbaru
                </div>
                <a href="{{ route('transactions.index') }}" style="font-size:12px;font-weight:600;color:var(--sk-primary);text-decoration:none">
                    Lihat Semua <i class="bi bi-arrow-right"></i>
                </a>
            </div>
            <div style="overflow-x:auto">
                <table class="table sk-table mb-0">
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
                                <span style="font-family:monospace;font-weight:700;color:var(--sk-heading);font-size:12px">
                                    {{ $trx->invoice_number }}
                                </span>
                            </td>
                            <td class="d-none d-md-table-cell" style="color:var(--sk-text)">{{ $trx->user->name }}</td>
                            <td><strong style="color:var(--sk-success)">Rp {{ number_format($trx->total,0,',','.') }}</strong></td>
                            <td class="d-none d-sm-table-cell">
                                <span class="mp mp-{{ $trx->payment_method }}">{{ $trx->payment_method }}</span>
                            </td>
                            <td class="d-none d-md-table-cell" style="color:var(--sk-muted);font-size:12px">
                                {{ $trx->created_at->format('d M H:i') }}
                            </td>
                            <td>
                                <a href="{{ route('transactions.show', $trx) }}"
                                   class="btn btn-sm"
                                   style="width:28px;height:28px;padding:0;display:inline-flex;align-items:center;justify-content:center;border:1px solid var(--sk-border);color:var(--sk-muted);border-radius:6px">
                                    <i class="bi bi-eye" style="font-size:12px"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5" style="color:var(--sk-muted)">
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

{{-- ── ADMIN ONLY: Shortcuts + Low Stock ── --}}
@if(auth()->user()->isAdmin())
<div class="row g-3">

    {{-- Quick Access --}}
    <div class="col-xl-4">
        <div class="card mb-0">
            <div class="sk-card-hd">
                <div class="sk-card-hd-title">
                    <div class="sk-card-hd-icon" style="background:rgba(85,110,230,.1);color:var(--sk-primary)"><i class="bi bi-grid-3x3-gap"></i></div>
                    Akses Cepat
                </div>
            </div>
            <div class="card-body">
                <div class="row g-2">
                    <div class="col-6">
                        <a href="{{ route('reports.index') }}" class="sk-shortcut" style="background:#f0fdf4;border-color:#bbf7d0">
                            <i class="bi bi-bar-chart-line-fill" style="color:#16a34a"></i>
                            <span style="color:#16a34a">Laporan</span>
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="{{ route('stock.index') }}" class="sk-shortcut" style="background:#fffbeb;border-color:#fde68a">
                            <i class="bi bi-boxes" style="color:#d97706"></i>
                            <span style="color:#d97706">Kelola Stok</span>
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="{{ route('products.create') }}" class="sk-shortcut" style="background:#eff6ff;border-color:#bfdbfe">
                            <i class="bi bi-plus-circle-fill" style="color:#2563eb"></i>
                            <span style="color:#2563eb">Tambah Produk</span>
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="{{ route('users.index') }}" class="sk-shortcut" style="background:#faf5ff;border-color:#e9d5ff">
                            <i class="bi bi-person-gear" style="color:#7c3aed"></i>
                            <span style="color:#7c3aed">Pengguna</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Low Stock Alert --}}
    <div class="col-xl-8">
        <div class="card mb-0">
            <div class="sk-card-hd">
                <div class="sk-card-hd-title">
                    <div class="sk-card-hd-icon" style="background:#fee2e2;color:var(--sk-danger)"><i class="bi bi-exclamation-triangle-fill"></i></div>
                    Notifikasi Stok Rendah
                    @if($lowStock > 0)
                    <span class="badge" style="background:var(--sk-danger);font-size:10px">{{ $lowStock }}</span>
                    @endif
                </div>
                <a href="{{ route('stock.index', ['status'=>'low']) }}" style="font-size:12px;font-weight:600;color:var(--sk-danger);text-decoration:none">
                    Kelola <i class="bi bi-arrow-right"></i>
                </a>
            </div>

            @if($lowStockProducts->isEmpty())
            <div class="text-center py-5" style="color:var(--sk-muted)">
                <i class="bi bi-check-circle-fill" style="font-size:36px;display:block;margin-bottom:10px;color:var(--sk-success)"></i>
                <div style="font-size:13px;font-weight:600">Semua stok dalam kondisi aman</div>
            </div>
            @else
            <div style="overflow-x:auto">
                <table class="table sk-table mb-0">
                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th>Kategori</th>
                            <th>Stok</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($lowStockProducts as $prod)
                        <tr>
                            <td style="font-weight:600;color:var(--sk-heading)">{{ $prod->name }}</td>
                            <td style="color:var(--sk-muted)">{{ $prod->category->name ?? '-' }}</td>
                            <td>
                                <span style="font-size:16px;font-weight:800;font-family:monospace;color:{{ $prod->stock==0?'var(--sk-danger)':'var(--sk-warning)' }}">
                                    {{ $prod->stock }}
                                </span>
                            </td>
                            <td>
                                @if($prod->stock == 0)
                                    <span class="sk-stat-badge badge-danger-soft"><i class="bi bi-x-circle-fill" style="font-size:10px"></i> Habis</span>
                                @else
                                    <span class="sk-stat-badge badge-warning-soft"><i class="bi bi-exclamation-triangle-fill" style="font-size:10px"></i> Rendah</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('stock.index') }}" style="font-size:12px;font-weight:600;color:var(--sk-primary);text-decoration:none">
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

    var initialChartData  = @json($chartData);
    var initialHourlyData = @json($hourlyData);
    var initialBreakdown  = @json($paymentBreakdown);
    var chartDataUrl      = '{{ route("dashboard.chart-data") }}';
    var POLL_MS           = 30000;
    var chartMode         = '7day';

    /* ── Helpers ── */
    function fmtRp(n)      { return 'Rp ' + Number(n).toLocaleString('id-ID'); }
    function fmtFull(n)    { return Number(n).toLocaleString('id-ID'); }
    function fmtShort(v)   {
        if (v === 0)      return 'Rp 0';
        if (v >= 1000000) return 'Rp ' + (v/1000000).toFixed(1).replace('.0','') + 'Jt';
        if (v >= 1000)    return 'Rp ' + Math.round(v/1000) + 'K';
        return 'Rp ' + v;
    }
    function calcMax(vals) {
        var m = Math.max.apply(null, vals.concat([0]));
        if (!m) return 50000;
        var p = m * 1.25;
        var mag = Math.pow(10, Math.floor(Math.log10(p)));
        return Math.ceil(p / mag) * mag;
    }
    function escHtml(s) {
        return String(s)
            .replace(/&/g,'&amp;').replace(/</g,'&lt;')
            .replace(/>/g,'&gt;').replace(/"/g,'&quot;')
            .replace(/'/g,'&#039;');
    }

    /* ── Skote color palette ── */
    var SKOTE = {
        primary: '#556ee6',
        success: '#34c38f',
        warning: '#f1b44c',
        danger:  '#f46a6a',
        info:    '#50a5f1',
        muted:   '#74788d',
        border:  '#eff2f7',
        gridLine:'#eff2f7',
    };

    /* ── Bar chart ── */
    var salesCtx   = document.getElementById('salesChart').getContext('2d');
    var salesVals  = initialChartData.map(function(d){ return d.total; });

    function gradientFill(ctx, color) {
        var g = ctx.createLinearGradient(0, 0, 0, 280);
        g.addColorStop(0, color + 'bb');
        g.addColorStop(1, color + '11');
        return g;
    }

    var salesChart = new Chart(salesCtx, {
        type: 'bar',
        data: {
            labels:   initialChartData.map(function(d){ return d.date; }),
            datasets: [{
                label:           'Penjualan',
                data:            salesVals,
                backgroundColor: gradientFill(salesCtx, SKOTE.primary),
                borderColor:     SKOTE.primary,
                borderWidth:     2,
                borderRadius:    6,
                borderSkipped:   false,
            }]
        },
        options: buildBarOpts(salesVals)
    });

    function buildBarOpts(vals) {
        return {
            responsive: true, maintainAspectRatio: false,
            animation: { duration: 600, easing: 'easeInOutQuart' },
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: { label: function(c){ return ' ' + fmtRp(c.raw); } },
                    backgroundColor: '#343a40', titleColor: '#e9ecef',
                    bodyColor: '#adb5bd', padding: 10, cornerRadius: 8,
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    suggestedMax: calcMax(vals),
                    ticks: { callback: fmtShort, color: SKOTE.muted, font: { size: 11 }, maxTicksLimit: 6 },
                    grid: { color: SKOTE.gridLine },
                    border: { display: false }
                },
                x: {
                    ticks: { color: SKOTE.muted, font: { size: 11 } },
                    grid: { display: false },
                    border: { display: false }
                }
            }
        };
    }

    function applySuggestedMax(vals) {
        salesChart.options.scales.y.suggestedMax = calcMax(vals);
    }

    /* ── Tab switch ── */
    window.switchChart = function(mode) {
        chartMode = mode;
        document.getElementById('btn-7day').classList.toggle('active', mode === '7day');
        document.getElementById('btn-hourly').classList.toggle('active', mode === 'hourly');
        var newVals;
        if (mode === '7day') {
            salesChart.data.labels = initialChartData.map(function(d){ return d.date; });
            newVals = initialChartData.map(function(d){ return d.total; });
        } else {
            var now = new Date().getHours();
            var filt = initialHourlyData.filter(function(d,i){ return i <= now; });
            salesChart.data.labels = filt.map(function(d){ return d.hour; });
            newVals = filt.map(function(d){ return d.total; });
        }
        salesChart.data.datasets[0].data = newVals;
        applySuggestedMax(newVals);
        salesChart.update();
    };

    /* ── Doughnut chart ── */
    var mKeys   = ['cash','transfer','qris'];
    var mColors = { cash: SKOTE.success, transfer: SKOTE.primary, qris: '#7c3aed' };
    var methodChartInst = null;

    function buildMethodChart(bd) {
        var vals    = mKeys.map(function(k){ return bd[k] ? bd[k].count : 0; });
        var hasData = vals.reduce(function(a,b){ return a+b; }, 0) > 0;
        if (!hasData) return;
        var ctx = document.getElementById('methodChart').getContext('2d');
        if (methodChartInst) {
            methodChartInst.data.datasets[0].data = vals;
            methodChartInst.update('active'); return;
        }
        methodChartInst = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels:   mKeys.map(function(l){ return l.charAt(0).toUpperCase()+l.slice(1); }),
                datasets: [{ data: vals, backgroundColor: mKeys.map(function(k){ return mColors[k]; }), borderWidth: 0, hoverOffset: 5 }]
            },
            options: {
                responsive: true, maintainAspectRatio: false, cutout: '70%',
                animation: { duration: 600 },
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { font: { size: 11, weight: '600' }, color: SKOTE.muted, padding: 14, usePointStyle: true, pointStyleWidth: 8 }
                    },
                    tooltip: {
                        callbacks: { label: function(c){ return ' '+c.label+': '+c.raw+' transaksi'; } },
                        backgroundColor: '#343a40', padding: 10, cornerRadius: 8,
                    }
                }
            }
        });
    }
    buildMethodChart(initialBreakdown);

    /* ── DOM Updates ── */
    function updateStats(d) {
        document.getElementById('stat-today-sales').textContent  = 'Rp ' + fmtFull(d.todaySales);
        document.getElementById('stat-today-trx').textContent    = d.todayTransactions;
        document.getElementById('stat-month-sales').textContent  = 'Rp ' + fmtFull(d.monthSales);
        document.getElementById('stat-month-trx').textContent    = d.monthTransactions;
        var sub = document.getElementById('stat-low-stock-sub');
        if (d.lowStock > 0) {
            sub.className = 'sk-stat-badge badge-danger-soft';
            sub.innerHTML = '<i class="bi bi-exclamation-triangle-fill" style="font-size:10px"></i> ' + d.lowStock + ' stok rendah';
        } else {
            sub.className = 'sk-stat-badge badge-success-soft';
            sub.innerHTML = '<i class="bi bi-check2-circle" style="font-size:10px"></i> Stok aman';
        }
    }

    function updateSalesChart(d) {
        initialChartData  = d.chartData;
        initialHourlyData = d.hourlyData;
        var total7 = d.chartData.reduce(function(s,x){ return s+x.total; }, 0);
        document.getElementById('chart-total-7day').textContent = fmtFull(total7);
        var newVals;
        if (chartMode === '7day') {
            salesChart.data.labels = d.chartData.map(function(x){ return x.date; });
            newVals = d.chartData.map(function(x){ return x.total; });
        } else {
            var now2 = new Date().getHours();
            var f2 = d.hourlyData.filter(function(x,i){ return i<=now2; });
            salesChart.data.labels = f2.map(function(x){ return x.hour; });
            newVals = f2.map(function(x){ return x.total; });
        }
        salesChart.data.datasets[0].data = newVals;
        applySuggestedMax(newVals);
        salesChart.update('active');
    }

    function updatePayment(bd) {
        var rows = document.querySelectorAll('#payment-breakdown-labels > div');
        mKeys.forEach(function(k,i) {
            if (!rows[i]) return;
            var dd = bd[k] || { count:0, total:0 };
            rows[i].querySelector('.pb-count').textContent = dd.count+'x';
            rows[i].querySelector('.pb-total').textContent = 'Rp '+fmtFull(dd.total);
        });
        buildMethodChart(bd);
    }

    function updateTopProducts(prods) {
        var rc = ['tp-r1','tp-r2','tp-r3','tp-rn','tp-rn'];
        var mx = prods.reduce(function(m,p){ return Math.max(m, p.total_qty); }, 1);
        if (!prods.length) {
            document.getElementById('top-products-list').innerHTML =
                '<div class="text-center py-5" style="color:var(--sk-muted)">' +
                '<i class="bi bi-inbox" style="font-size:32px;display:block;margin-bottom:8px"></i>' +
                '<div style="font-size:13px">Belum ada penjualan hari ini</div></div>';
            return;
        }
        var html = prods.map(function(p,i){
            var pct = Math.round(p.total_qty/mx*100);
            return '<div class="tp-row">' +
                '<div class="tp-rank '+(rc[i]||'tp-rn')+'">'+(i+1)+'</div>' +
                '<div style="flex:1;min-width:0">' +
                  '<div style="font-size:13px;font-weight:600;color:var(--sk-heading);white-space:nowrap;overflow:hidden;text-overflow:ellipsis">'+escHtml(p.name)+'</div>' +
                  '<div class="tp-prog"><div class="tp-prog-fill" style="width:'+pct+'%"></div></div>' +
                '</div>' +
                '<div style="text-align:right;flex-shrink:0">' +
                  '<div style="font-size:12px;font-weight:700;color:var(--sk-primary)">'+p.total_qty+'x</div>' +
                  '<div style="font-size:11px;color:var(--sk-muted)">Rp '+fmtFull(p.total_revenue)+'</div>' +
                '</div>' +
              '</div>';
        }).join('');
        document.getElementById('top-products-list').innerHTML = html;
    }

    function updateRecentTrx(trxs) {
        if (!trxs.length) return;
        var html = trxs.map(function(t){
            return '<tr>' +
                '<td><span style="font-family:monospace;font-weight:700;color:var(--sk-heading);font-size:12px">'+escHtml(t.invoice_number)+'</span></td>'+
                '<td class="d-none d-md-table-cell" style="color:var(--sk-text)">'+escHtml(t.cashier)+'</td>'+
                '<td><strong style="color:var(--sk-success)">Rp '+fmtFull(t.total)+'</strong></td>'+
                '<td class="d-none d-sm-table-cell"><span class="mp mp-'+escHtml(t.payment_method)+'">'+escHtml(t.payment_method)+'</span></td>'+
                '<td class="d-none d-md-table-cell" style="color:var(--sk-muted);font-size:12px">'+escHtml(t.created_at)+'</td>'+
                '<td><a href="'+escHtml(t.show_url)+'" class="btn btn-sm" style="width:28px;height:28px;padding:0;display:inline-flex;align-items:center;justify-content:center;border:1px solid var(--sk-border);color:var(--sk-muted);border-radius:6px"><i class="bi bi-eye" style="font-size:12px"></i></a></td>'+
              '</tr>';
        }).join('');
        document.getElementById('recent-trx-tbody').innerHTML = html;
    }

    /* ── Polling ── */
    var badge = document.getElementById('rt-badge');
    function fetchAndRefresh() {
        badge.classList.add('is-refreshing');
        fetch(chartDataUrl, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
            credentials: 'same-origin',
        })
        .then(function(r){ if (!r.ok) throw new Error('HTTP '+r.status); return r.json(); })
        .then(function(d) {
            updateStats(d);
            updateSalesChart(d);
            updatePayment(d.paymentBreakdown);
            updateTopProducts(d.topProducts);
            updateRecentTrx(d.recentTransactions);
            var ts = d.timestamp;
            document.getElementById('last-updated-time').textContent  = ts;
            document.getElementById('last-updated-time2').textContent = ts;
            badge.classList.remove('is-refreshing');
        })
        .catch(function(e){ console.warn('[Dashboard] Refresh gagal:', e); badge.classList.remove('is-refreshing'); });
    }

    setInterval(fetchAndRefresh, POLL_MS);

    /* ── Stock Alert: dismiss banner ── */
    window.dismissStockAlert = function() {
        var banner = document.getElementById('stock-alert-banner');
        if (banner) {
            banner.style.transition = 'opacity .3s, transform .3s';
            banner.style.opacity = '0';
            banner.style.transform = 'translateY(-10px)';
            setTimeout(function(){ banner.style.display = 'none'; }, 300);
        }
    };

    /* ── Stock Modal: close ── */
    window.closeStockModal = function() {
        var overlay = document.getElementById('stock-modal-overlay');
        if (overlay) {
            overlay.style.transition = 'opacity .25s';
            overlay.style.opacity = '0';
            setTimeout(function(){ overlay.style.display = 'none'; }, 250);
        }
    };

    /* ── Auto-buka modal stok untuk kasir saat halaman dimuat ── */
    (function() {
        var overlay = document.getElementById('stock-modal-overlay');
        if (!overlay) return; // admin tidak ada modal ini
        // Tunda sedikit agar halaman sudah fully rendered
        setTimeout(function() {
            overlay.style.display = 'flex';
        }, 600);
        // Tutup dengan Escape
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') window.closeStockModal();
        });
    })();
})();
</script>
@endpush
