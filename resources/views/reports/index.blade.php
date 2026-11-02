@extends('layouts.app')

@section('title', 'Laporan Penjualan')
@section('page-title', 'Laporan Penjualan')

@push('styles')
<style>
.rcard{background:#fff;border-radius:14px;border:1px solid #e5e7eb;overflow:hidden;margin-bottom:20px}
.rcard-head{padding:14px 20px;border-bottom:1px solid #f3f4f6;font-weight:700;font-size:14px;display:flex;align-items:center;justify-content:space-between;gap:8px}
.rcard-body{padding:20px}
.sum-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:12px;margin-bottom:20px}
@media(max-width:900px){.sum-grid{grid-template-columns:repeat(2,1fr)}}
@media(max-width:480px){.sum-grid{grid-template-columns:1fr 1fr;gap:8px}}
.export-btns{display:flex;gap:8px;flex-wrap:wrap}
@media(max-width:640px){
    .rcard-head{flex-direction:column;align-items:flex-start;gap:8px}
    .export-btns{width:100%}
    .btn-exp{flex:1;justify-content:center}
    .sum-item .si-val{font-size:16px}
    .cat-bar .cb-name{width:100px;font-size:12px}
    .report-table th,.report-table td{padding:8px 10px;font-size:12px}
}
.sum-item{background:#f9fafb;border-radius:12px;padding:16px;border:1px solid #f0f0f0}
.sum-item .si-val{font-size:20px;font-weight:800;color:#1c1c1e;letter-spacing:-.4px;margin-bottom:4px}
.sum-item .si-lbl{font-size:12px;color:#6b7280;font-weight:500}
.sum-item.green .si-val{color:#166534}
.sum-item.blue  .si-val{color:#1d4ed8}
.sum-item.amber .si-val{color:#92400e}
.btn-exp{padding:7px 16px;border-radius:8px;font-size:13px;font-weight:600;text-decoration:none;display:inline-flex;align-items:center;gap:6px;transition:all .15s;border:none;cursor:pointer;font-family:inherit}
.btn-csv{background:#f0fdf4;color:#166534;border:1px solid #bbf7d0}
.btn-csv:hover{background:#dcfce7;color:#166534}
.btn-pdf{background:#fef2f2;color:#dc2626;border:1px solid #fecaca}
.btn-pdf:hover{background:#fee2e2;color:#dc2626}
.cat-bar{display:flex;align-items:center;gap:10px;padding:8px 0;border-bottom:1px solid #f9fafb}
.cat-bar:last-child{border-bottom:none}
.cat-bar .cb-name{width:140px;font-size:13px;font-weight:600;color:#374151;flex-shrink:0}
.cat-bar .cb-track{flex:1;height:8px;background:#f3f4f6;border-radius:10px;overflow:hidden}
.cat-bar .cb-fill{height:100%;background:#3d6b4f;border-radius:10px}
.cat-bar .cb-val{width:90px;text-align:right;font-size:12px;font-weight:700;color:#3d6b4f;flex-shrink:0}
.cb-qty{font-size:11px;color:#9ca3af;width:50px;flex-shrink:0}
.method-pill{display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:20px;font-size:11px;font-weight:600;text-transform:uppercase}
.mp-cash{background:#f0fdf4;color:#166534}
.mp-transfer{background:#eff6ff;color:#1d4ed8}
.mp-qris{background:#faf5ff;color:#7c3aed}
.report-table th{font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:#9ca3af;padding:10px 14px;background:#f9fafb;border:none}
.report-table td{padding:11px 14px;vertical-align:middle;border-color:#f3f4f6;font-size:13px}
.report-table tbody tr:hover{background:#f9fafb}
</style>
@endpush

@section('content')

{{-- Filter --}}
<div class="rcard">
  <div class="rcard-head">
    <span><i class="bi bi-funnel me-2 text-success"></i>Filter Laporan</span>
    <div class="export-btns">
      <a href="{{ route('reports.csv', request()->query()) }}" class="btn-exp btn-csv">
        <i class="bi bi-file-earmark-spreadsheet"></i> Export CSV
      </a>
      <a href="{{ route('reports.pdf', request()->query()) }}" target="_blank" class="btn-exp btn-pdf">
        <i class="bi bi-file-earmark-pdf"></i> Cetak PDF
      </a>
    </div>
  </div>
  <div class="rcard-body">
    <form method="GET" class="row g-2 align-items-end">
      <div class="col-md-3">
        <label class="form-label fw-semibold" style="font-size:12px">Dari Tanggal</label>
        <input type="date" class="form-control" name="date_from" value="{{ request('date_from', $dateFrom->format('Y-m-d')) }}">
      </div>
      <div class="col-md-3">
        <label class="form-label fw-semibold" style="font-size:12px">Sampai Tanggal</label>
        <input type="date" class="form-control" name="date_to" value="{{ request('date_to', $dateTo->format('Y-m-d')) }}">
      </div>
      <div class="col-md-3">
        <label class="form-label fw-semibold" style="font-size:12px">Metode Bayar</label>
        <select class="form-select" name="payment_method">
          <option value="">Semua Metode</option>
          <option value="cash"     {{ request('payment_method') == 'cash'     ? 'selected' : '' }}>Tunai</option>
          <option value="qris"     {{ request('payment_method') == 'qris'     ? 'selected' : '' }}>QRIS</option>
          <option value="transfer" {{ request('payment_method') == 'transfer' ? 'selected' : '' }}>Transfer</option>
        </select>
      </div>
      <div class="col-md-3 d-flex gap-2">
        <button class="btn btn-primary flex-1" style="flex:1">Terapkan</button>
        <a href="{{ route('reports.index') }}" class="btn btn-light px-3">Reset</a>
      </div>
    </form>
  </div>
</div>

{{-- Summary --}}
<div class="sum-grid">
  <div class="sum-item green">
    <div class="si-val">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
    <div class="si-lbl"><i class="bi bi-cash-coin me-1"></i>Total Pendapatan</div>
  </div>
  <div class="sum-item blue">
    <div class="si-val">{{ number_format($totalTransactions) }}</div>
    <div class="si-lbl"><i class="bi bi-receipt me-1"></i>Total Transaksi</div>
  </div>
  <div class="sum-item amber">
    <div class="si-val">Rp {{ number_format($avgTransaction, 0, ',', '.') }}</div>
    <div class="si-lbl"><i class="bi bi-calculator me-1"></i>Rata-rata / Transaksi</div>
  </div>
  <div class="sum-item">
    <div class="si-val">Rp {{ number_format($totalDiscount, 0, ',', '.') }}</div>
    <div class="si-lbl"><i class="bi bi-tag me-1"></i>Total Diskon</div>
  </div>
</div>

<div class="row g-3 mb-3">
  {{-- Penjualan Harian --}}
  <div class="col-lg-8">
    <div class="rcard mb-0 h-100">
      <div class="rcard-head">
        <span><i class="bi bi-bar-chart-line me-2 text-success"></i>Penjualan Harian</span>
      </div>
      <div class="rcard-body" style="position:relative;height:240px">
        <canvas id="dailyChart"></canvas>
      </div>
    </div>
  </div>

  {{-- Metode Bayar --}}
  <div class="col-lg-4">
    <div class="rcard mb-0 h-100">
      <div class="rcard-head"><i class="bi bi-pie-chart me-2 text-primary"></i>Metode Pembayaran</div>
      <div class="rcard-body">
        <div style="position:relative;height:150px;margin-bottom:16px">
          <canvas id="methodChart"></canvas>
        </div>
        @foreach($paymentData as $p)
        <div style="display:flex;justify-content:space-between;align-items:center;padding:6px 0;border-bottom:1px solid #f9fafb">
          <span class="method-pill mp-{{ $p->payment_method }}">{{ $p->payment_method }}</span>
          <div style="text-align:right">
            <div style="font-size:13px;font-weight:700">{{ $p->count }}x</div>
            <div style="font-size:11px;color:#9ca3af">Rp {{ number_format($p->revenue, 0, ',', '.') }}</div>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </div>
</div>

<div class="row g-3 mb-3">
  {{-- Per Kategori --}}
  <div class="col-lg-6">
    <div class="rcard mb-0 h-100">
      <div class="rcard-head"><i class="bi bi-tags me-2 text-warning"></i>Penjualan per Kategori</div>
      <div class="rcard-body">
        @php $maxCat = $categoryData->max('total_revenue') ?: 1; @endphp
        @forelse($categoryData as $cat)
        <div class="cat-bar">
          <div class="cb-name">{{ $cat->category }}</div>
          <div class="cb-track">
            <div class="cb-fill" style="width:{{ round($cat->total_revenue / $maxCat * 100) }}%"></div>
          </div>
          <div class="cb-qty">{{ $cat->total_qty }}x</div>
          <div class="cb-val">Rp {{ number_format($cat->total_revenue/1000, 0, ',', '.') }}K</div>
        </div>
        @empty
        <div class="text-center py-4 text-muted" style="font-size:13px">Tidak ada data</div>
        @endforelse
      </div>
    </div>
  </div>

  {{-- Top Produk --}}
  <div class="col-lg-6">
    <div class="rcard mb-0 h-100">
      <div class="rcard-head"><i class="bi bi-trophy me-2 text-warning"></i>10 Produk Terlaris</div>
      <div class="rcard-body p-0">
        @php $maxProd = $topProducts->max('total_qty') ?: 1; @endphp
        @forelse($topProducts as $i => $p)
        <div style="display:flex;align-items:center;gap:10px;padding:9px 20px;border-bottom:1px solid #f9fafb">
          <div style="width:22px;height:22px;border-radius:6px;background:{{ ['#fef3c7','#e0f2fe','#f0fdf4'][$i] ?? '#f3f4f6' }};display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:800;color:{{ ['#92400e','#0369a1','#166534'][$i] ?? '#6b7280' }};flex-shrink:0">{{ $i+1 }}</div>
          <div style="flex:1;font-size:13px;font-weight:600;color:#374151;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">{{ $p->product_name }}</div>
          <div style="font-size:12px;font-weight:700;color:#3d6b4f;flex-shrink:0">{{ $p->total_qty }}x</div>
          <div style="font-size:11px;color:#9ca3af;flex-shrink:0;min-width:80px;text-align:right">Rp {{ number_format($p->total_revenue, 0, ',', '.') }}</div>
        </div>
        @empty
        <div class="text-center py-4 text-muted" style="font-size:13px">Tidak ada data</div>
        @endforelse
      </div>
    </div>
  </div>
</div>

{{-- Tabel Transaksi --}}
<div class="rcard">
  <div class="rcard-head">
    <span><i class="bi bi-list-ul me-2 text-secondary"></i>Detail Transaksi ({{ $transactions->total() }})</span>
  </div>
  <div style="overflow-x:auto">
    <table class="table report-table mb-0">
      <thead>
        <tr>
          <th>Invoice</th><th>Tanggal</th><th class="d-none d-md-table-cell">Kasir</th>
          <th>Total</th><th>Diskon</th><th>Metode</th><th></th>
        </tr>
      </thead>
      <tbody>
        @forelse($transactions as $trx)
        <tr>
          <td><span style="font-family:monospace;font-weight:700;font-size:12px">{{ $trx->invoice_number }}</span></td>
          <td style="color:#6b7280">{{ $trx->created_at->format('d M Y H:i') }}</td>
          <td class="d-none d-md-table-cell">{{ $trx->user->name }}</td>
          <td style="font-weight:700;color:#166534">Rp {{ number_format($trx->total, 0, ',', '.') }}</td>
          <td style="color:#9ca3af">{{ $trx->discount > 0 ? 'Rp '.number_format($trx->discount,0,',','.') : '-' }}</td>
          <td><span class="method-pill mp-{{ $trx->payment_method }}">{{ $trx->payment_method }}</span></td>
          <td>
            <a href="{{ route('transactions.show', $trx) }}" style="color:#6b7280;font-size:13px">
              <i class="bi bi-eye"></i>
            </a>
          </td>
        </tr>
        @empty
        <tr><td colspan="7" class="text-center py-4 text-muted">Tidak ada transaksi</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  @if($transactions->hasPages())
  <div style="padding:12px 20px;border-top:1px solid #f3f4f6">
    {{ $transactions->links() }}
  </div>
  @endif
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>
<script>
(function(){
  var daily  = @json($dailyData);
  var labels = daily.map(function(d){ return d.date; });
  var values = daily.map(function(d){ return parseFloat(d.revenue); });

  new Chart(document.getElementById('dailyChart'), {
    type: 'bar',
    data: {
      labels: labels,
      datasets: [{ label: 'Penjualan', data: values,
        backgroundColor: 'rgba(61,107,79,.5)', borderColor: '#3d6b4f',
        borderWidth: 2, borderRadius: 6, borderSkipped: false }]
    },
    options: {
      responsive: true, maintainAspectRatio: false,
      plugins: { legend: { display: false },
        tooltip: { callbacks: { label: function(c){ return ' Rp '+Number(c.raw).toLocaleString('id-ID'); } } }
      },
      scales: {
        y: { beginAtZero: true, grid: { color: '#f3f4f6' }, border: { display: false },
          ticks: { color: '#9ca3af', font: { size: 11 },
            callback: function(v){ return v>=1000000?'Rp '+(v/1000000).toFixed(1)+'Jt':v>=1000?'Rp '+(v/1000).toFixed(0)+'K':'Rp '+v; }
          }
        },
        x: { grid: { display: false }, border: { display: false }, ticks: { color: '#9ca3af', font: { size: 11 } } }
      }
    }
  });

  var pay    = @json($paymentData);
  var mLbls  = pay.map(function(p){ return p.payment_method.charAt(0).toUpperCase()+p.payment_method.slice(1); });
  var mVals  = pay.map(function(p){ return p.count; });
  var mClrs  = pay.map(function(p){ return p.payment_method==='cash'?'#3d6b4f':p.payment_method==='qris'?'#7c3aed':'#2563eb'; });

  if (mVals.length) {
    new Chart(document.getElementById('methodChart'), {
      type: 'doughnut',
      data: { labels: mLbls, datasets: [{ data: mVals, backgroundColor: mClrs, borderWidth: 0, hoverOffset: 4 }] },
      options: {
        responsive: true, maintainAspectRatio: false, cutout: '65%',
        plugins: { legend: { position: 'bottom', labels: { font: { size: 11 }, color: '#6b7280', padding: 12, usePointStyle: true } } }
      }
    });
  }
})();
</script>
@endpush
