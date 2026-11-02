@extends('layouts.app')

@section('title', 'Riwayat Transaksi')
@section('page-title', 'Riwayat Transaksi')

@push('styles')
<style>
@media(max-width:640px){
    .trx-table th,.trx-table td{padding:9px 10px;font-size:12px}
    .sum-line{flex-direction:column;gap:4px}
    .filter-form .col-md-4,.filter-form .col-md-2{width:100%}
}
.method-pill {
    display: inline-flex; align-items: center; gap: 4px;
    padding: 3px 10px; border-radius: 20px;
    font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: .3px;
}
.mp-cash     { background: #f0fdf4; color: #166534; }
.mp-transfer { background: #eff6ff; color: #1d4ed8; }
.mp-qris     { background: #faf5ff; color: #7c3aed; }
.trx-table th {
    font-size: 11px; font-weight: 700; text-transform: uppercase;
    letter-spacing: .5px; color: #9ca3af;
    padding: 10px 16px; border-top: none; background: #f9fafb;
}
.trx-table td { padding: 12px 16px; vertical-align: middle; border-color: #f3f4f6; }
.trx-table tbody tr:hover { background: #f9fafb; }
.action-btn {
    width: 30px; height: 30px; border-radius: 7px;
    display: inline-flex; align-items: center; justify-content: center;
    border: 1px solid #e5e7eb; color: #6b7280;
    text-decoration: none; font-size: 13px; transition: all .15s;
}
.action-btn:hover { background: #f3f4f6; color: #1c1c1e; border-color: #d1d5db; }
.action-btn.primary:hover { background: #f0fdf4; color: #166534; border-color: #bbf7d0; }
</style>
@endpush

@section('content')

{{-- Filter --}}
<div class="card mb-4" style="border-radius:14px;border:1px solid #e5e7eb">
    <div class="card-body py-3">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0">
                        <i class="bi bi-search text-muted" style="font-size:14px"></i>
                    </span>
                    <input type="text" class="form-control border-start-0 ps-0" name="search"
                           value="{{ request('search') }}" placeholder="Invoice / nama pelanggan...">
                </div>
            </div>
            <div class="col-md-2">
                <input type="date" class="form-control" name="date_from" value="{{ request('date_from') }}">
            </div>
            <div class="col-md-2">
                <input type="date" class="form-control" name="date_to" value="{{ request('date_to') }}">
            </div>
            <div class="col-md-2">
                <select class="form-select" name="payment_method">
                    <option value="">Semua Metode</option>
                    <option value="cash"     {{ request('payment_method') == 'cash'     ? 'selected' : '' }}>Tunai</option>
                    <option value="transfer" {{ request('payment_method') == 'transfer' ? 'selected' : '' }}>Transfer</option>
                    <option value="qris"     {{ request('payment_method') == 'qris'     ? 'selected' : '' }}>QRIS</option>
                </select>
            </div>
            <div class="col-auto d-flex gap-2">
                <button class="btn btn-primary px-4">Filter</button>
                <a href="{{ route('transactions.index') }}" class="btn btn-light px-3">Reset</a>
            </div>
        </form>
    </div>
</div>

{{-- Summary --}}
<div class="row g-3 mb-4">
    <div class="col-sm-4">
        <div class="p-3 rounded-3 d-flex align-items-center gap-3"
             style="background:#f0fdf4;border:1px solid #bbf7d0">
            <div style="width:38px;height:38px;background:#dcfce7;border-radius:10px;display:flex;align-items:center;justify-content:center;color:#166534;font-size:16px;flex-shrink:0">
                <i class="bi bi-cash-coin"></i>
            </div>
            <div>
                <div style="font-size:11px;font-weight:600;color:#4ade80;text-transform:uppercase;letter-spacing:.3px">Total Pendapatan</div>
                <div style="font-size:17px;font-weight:800;color:#166534;letter-spacing:-.3px">
                    Rp {{ number_format($totalRevenue, 0, ',', '.') }}
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="p-3 rounded-3 d-flex align-items-center gap-3"
             style="background:#eff6ff;border:1px solid #bfdbfe">
            <div style="width:38px;height:38px;background:#dbeafe;border-radius:10px;display:flex;align-items:center;justify-content:center;color:#1d4ed8;font-size:16px;flex-shrink:0">
                <i class="bi bi-receipt"></i>
            </div>
            <div>
                <div style="font-size:11px;font-weight:600;color:#60a5fa;text-transform:uppercase;letter-spacing:.3px">Jumlah Transaksi</div>
                <div style="font-size:17px;font-weight:800;color:#1d4ed8;letter-spacing:-.3px">
                    {{ $transactions->total() }} transaksi
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="p-3 rounded-3 d-flex align-items-center gap-3"
             style="background:#fafafa;border:1px solid #e5e7eb">
            <div style="width:38px;height:38px;background:#f3f4f6;border-radius:10px;display:flex;align-items:center;justify-content:center;color:#6b7280;font-size:16px;flex-shrink:0">
                <i class="bi bi-calculator"></i>
            </div>
            <div>
                <div style="font-size:11px;font-weight:600;color:#9ca3af;text-transform:uppercase;letter-spacing:.3px">Rata-rata / Transaksi</div>
                <div style="font-size:17px;font-weight:800;color:#374151;letter-spacing:-.3px">
                    @if($transactions->total() > 0)
                        Rp {{ number_format($totalRevenue / $transactions->total(), 0, ',', '.') }}
                    @else
                        Rp 0
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Table --}}
<div class="card" style="border-radius:14px;border:1px solid #e5e7eb;overflow:hidden">
    <div style="overflow-x:auto">
        <table class="table trx-table mb-0">
            <thead>
                <tr>
                    <th>Invoice</th>
                    <th class="d-none d-md-table-cell">Pelanggan</th>
                    <th class="d-none d-md-table-cell">Kasir</th>
                    <th>Total</th>
                    <th>Metode</th>
                    <th class="d-none d-md-table-cell">Tanggal</th>
                    <th>Status</th>
                    <th style="width:80px"></th>
                </tr>
            </thead>
            <tbody>
                @forelse($transactions as $trx)
                <tr>
                    <td>
                        <span style="font-family:monospace;font-weight:700;font-size:12px;color:#1c1c1e">
                            {{ $trx->invoice_number }}
                        </span>
                    </td>
                    <td class="d-none d-md-table-cell" style="color:#374151;font-size:13px">
                        {{ $trx->customer_name ?: '-' }}
                    </td>
                    <td class="d-none d-md-table-cell" style="color:#374151;font-size:13px">{{ $trx->user->name }}</td>
                    <td style="font-weight:700;color:#166534;font-size:13px">
                        Rp {{ number_format($trx->total, 0, ',', '.') }}
                    </td>
                    <td>
                        <span class="method-pill mp-{{ $trx->payment_method }}">
                            {{ $trx->payment_method }}
                        </span>
                    </td>
                    <td style="font-size:12px;color:#6b7280" class="d-none d-md-table-cell">
                        {{ $trx->created_at->format('d M Y') }}<br>
                        <span style="color:#9ca3af">{{ $trx->created_at->format('H:i') }}</span>
                    </td>
                    <td>
                        @if($trx->status === 'completed')
                            <span style="display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:20px;font-size:11px;font-weight:600;background:#f0fdf4;color:#166534">
                                <i class="bi bi-check-circle-fill" style="font-size:10px"></i> Selesai
                            </span>
                        @elseif($trx->status === 'pending')
                            <span style="display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:20px;font-size:11px;font-weight:600;background:#fffbeb;color:#92400e">
                                <i class="bi bi-clock" style="font-size:10px"></i> Pending
                            </span>
                        @else
                            <span style="display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:20px;font-size:11px;font-weight:600;background:#f9fafb;color:#6b7280">
                                <i class="bi bi-x-circle" style="font-size:10px"></i> Batal
                            </span>
                        @endif
                    </td>
                    <td>
                        <div style="display:flex;gap:5px">
                            <a href="{{ route('transactions.show', $trx) }}" class="action-btn" title="Detail">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('transactions.print', $trx) }}" target="_blank"
                               class="action-btn primary" title="Cetak Struk">
                                <i class="bi bi-printer"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="text-align:center;padding:60px;color:#9ca3af">
                        <i class="bi bi-receipt" style="font-size:36px;display:block;margin-bottom:10px;color:#d1d5db"></i>
                        <div style="font-size:14px;font-weight:500">Belum ada transaksi</div>
                        <div style="font-size:12px;margin-top:4px">Coba ubah filter pencarian</div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($transactions->hasPages())
    <div style="padding:14px 20px;border-top:1px solid #f3f4f6;display:flex;align-items:center;justify-content:space-between">
        <div style="font-size:12px;color:#9ca3af">
            Menampilkan {{ $transactions->firstItem() }}&ndash;{{ $transactions->lastItem() }}
            dari {{ $transactions->total() }} transaksi
        </div>
        {{ $transactions->links() }}
    </div>
    @endif
</div>
@endsection
