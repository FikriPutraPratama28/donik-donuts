<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Laporan Penjualan - Donik Donuts</title>
<style>
*{box-sizing:border-box;margin:0;padding:0}
body{font-family:Arial,sans-serif;font-size:12px;color:#1c1c1e;background:#fff;padding:20px}
.header{text-align:center;border-bottom:2px solid #3d6b4f;padding-bottom:14px;margin-bottom:18px}
.header .logo-title{font-size:22px;font-weight:900;color:#3d6b4f;letter-spacing:1px}
.header .subtitle{font-size:12px;color:#6b7280;margin-top:4px}
.header .period{font-size:13px;font-weight:700;color:#1c1c1e;margin-top:6px}
.summary{display:flex;gap:10px;margin-bottom:18px}
.sum-box{flex:1;border:1px solid #e5e7eb;border-radius:8px;padding:10px 14px;text-align:center}
.sum-box .sv{font-size:16px;font-weight:800;color:#1c1c1e}
.sum-box .sl{font-size:10px;color:#9ca3af;margin-top:3px;text-transform:uppercase;letter-spacing:.3px}
table{width:100%;border-collapse:collapse;margin-bottom:20px}
th{background:#f9fafb;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:#9ca3af;padding:8px 10px;text-align:left;border-bottom:1px solid #e5e7eb}
td{padding:8px 10px;border-bottom:1px solid #f3f4f6;font-size:11px}
tr:nth-child(even){background:#fafafa}
.footer{text-align:center;font-size:10px;color:#9ca3af;border-top:1px solid #e5e7eb;padding-top:10px;margin-top:20px}
.btn-print{display:block;margin:0 auto 16px;padding:8px 24px;background:#3d6b4f;color:#fff;border:none;border-radius:8px;font-size:13px;font-weight:700;cursor:pointer}
@media print{.btn-print{display:none}}
</style>
</head>
<body>
<button class="btn-print" onclick="window.print()">Cetak / Save PDF</button>

<div class="header">
  <div class="logo-title">DONIK DONUTS</div>
  <div class="subtitle">Laporan Penjualan</div>
  <div class="period">
    Periode: {{ $dateFrom->format('d M Y') }} &mdash; {{ $dateTo->format('d M Y') }}
  </div>
</div>

<div class="summary">
  <div class="sum-box">
    <div class="sv">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
    <div class="sl">Total Pendapatan</div>
  </div>
  <div class="sum-box">
    <div class="sv">{{ $transactions->count() }}</div>
    <div class="sl">Jumlah Transaksi</div>
  </div>
  <div class="sum-box">
    <div class="sv">Rp {{ $transactions->count() > 0 ? number_format($totalRevenue / $transactions->count(), 0, ',', '.') : 0 }}</div>
    <div class="sl">Rata-rata / Transaksi</div>
  </div>
</div>

<table>
  <thead>
    <tr>
      <th>#</th>
      <th>Invoice</th>
      <th>Tanggal</th>
      <th>Kasir</th>
      <th>Total</th>
      <th>Metode</th>
    </tr>
  </thead>
  <tbody>
    @foreach($transactions as $i => $trx)
    <tr>
      <td>{{ $i + 1 }}</td>
      <td style="font-family:monospace;font-weight:700">{{ $trx->invoice_number }}</td>
      <td>{{ $trx->created_at->format('d/m/Y H:i') }}</td>
      <td>{{ $trx->user->name }}</td>
      <td style="font-weight:700;color:#166534">Rp {{ number_format($trx->total, 0, ',', '.') }}</td>
      <td style="text-transform:uppercase;font-weight:600">{{ $trx->payment_method }}</td>
    </tr>
    @endforeach
    <tr style="background:#f0fdf4;font-weight:800">
      <td colspan="4" style="text-align:right;padding-right:10px">TOTAL</td>
      <td style="color:#166534">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</td>
      <td></td>
    </tr>
  </tbody>
</table>

<div class="footer">
  Dicetak: {{ now()->format('d M Y H:i') }} &bull; Donik Donuts POS System
</div>

<script>window.addEventListener('load', function(){ setTimeout(function(){ window.print(); }, 400); });</script>
</body>
</html>
