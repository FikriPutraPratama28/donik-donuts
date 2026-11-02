@extends('layouts.app')

@section('title', 'Manajemen Stok')
@section('page-title', 'Manajemen Stok')

@push('styles')
<style>
.stock-summary{display:grid;grid-template-columns:repeat(3,1fr);gap:12px;margin-bottom:20px}
@media(max-width:640px){.stock-summary{grid-template-columns:1fr 1fr}}
@media(max-width:400px){.stock-summary{grid-template-columns:1fr}}
.ss-card{border-radius:12px;padding:16px 20px;border:1px solid #e5e7eb}
.ss-card .sc-v{font-size:22px;font-weight:800;letter-spacing:-.4px;margin-bottom:4px}
.ss-card .sc-l{font-size:12px;font-weight:500}
.ss-green{background:#f0fdf4;color:#166534;border-color:#bbf7d0}
.ss-amber{background:#fffbeb;color:#92400e;border-color:#fde68a}
.ss-red  {background:#fef2f2;color:#dc2626;border-color:#fecaca}
.scard{background:#fff;border-radius:14px;border:1px solid #e5e7eb;overflow:hidden;margin-bottom:20px}
.scard-head{padding:14px 20px;border-bottom:1px solid #f3f4f6;font-weight:700;font-size:14px;display:flex;align-items:center;gap:8px}
.stock-table th{font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:#9ca3af;padding:10px 14px;background:#f9fafb;border:none}
.stock-table td{padding:10px 14px;vertical-align:middle;border-color:#f3f4f6;font-size:13px}
.stock-table tbody tr:hover{background:#f9fafb}
.stock-badge{display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:20px;font-size:11px;font-weight:600}
.sb-ok   {background:#f0fdf4;color:#166534}
.sb-low  {background:#fffbeb;color:#92400e}
.sb-empty{background:#fef2f2;color:#dc2626}
.stock-ctrl{display:flex;align-items:center;gap:4px}
.stock-ctrl input[type=number]{width:70px;height:32px;border:1.5px solid #e5e7eb;border-radius:7px;padding:0 8px;font-size:13px;text-align:center}
.stock-ctrl input:focus{outline:none;border-color:#3d6b4f}
.btn-upd{padding:5px 12px;border-radius:7px;font-size:12px;font-weight:600;border:none;cursor:pointer;transition:all .15s;font-family:inherit}
.btn-add{background:#f0fdf4;color:#166534;border:1px solid #bbf7d0}
.btn-add:hover{background:#dcfce7}
.btn-set{background:#eff6ff;color:#1d4ed8;border:1px solid #bfdbfe}
.btn-set:hover{background:#dbeafe}
.bulk-bar{background:#1a3d2b;color:#fff;padding:10px 20px;border-radius:10px;margin-bottom:16px;display:none;align-items:center;justify-content:space-between;gap:12px}
.bulk-bar.show{display:flex}
@media(max-width:640px){
    .stock-ctrl{flex-wrap:wrap;gap:4px}
    .stock-ctrl input[type=number]{width:60px}
    .btn-upd{font-size:11px;padding:4px 8px}
    .stock-table th,.stock-table td{padding:8px 10px;font-size:12px}
}
</style>
@endpush

@section('content')

{{-- Summary --}}
<div class="stock-summary">
  <div class="ss-card ss-green">
    <div class="sc-v">{{ number_format($totalStock) }}</div>
    <div class="sc-l"><i class="bi bi-boxes me-1"></i>Total Stok</div>
  </div>
  <div class="ss-card ss-amber">
    <div class="sc-v">{{ $lowCount }}</div>
    <div class="sc-l"><i class="bi bi-exclamation-triangle me-1"></i>Stok Hampir Habis (&le;10)</div>
  </div>
  <div class="ss-card ss-red">
    <div class="sc-v">{{ $emptyCount }}</div>
    <div class="sc-l"><i class="bi bi-x-circle me-1"></i>Stok Habis</div>
  </div>
</div>

{{-- Filter --}}
<div class="scard">
  <div class="scard-head"><i class="bi bi-funnel text-success"></i>Filter Stok</div>
  <div style="padding:14px 20px">
    <form method="GET" class="row g-2 align-items-end">
      <div class="col-md-4">
        <div class="input-group">
          <span class="input-group-text bg-white"><i class="bi bi-search text-muted" style="font-size:13px"></i></span>
          <input type="text" class="form-control border-start-0 ps-0" name="search"
                 value="{{ request('search') }}" placeholder="Cari produk...">
        </div>
      </div>
      <div class="col-md-3">
        <select class="form-select" name="category_id">
          <option value="">Semua Kategori</option>
          @foreach($categories as $cat)
          <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-md-3">
        <select class="form-select" name="status">
          <option value="">Semua Status</option>
          <option value="low"   {{ request('status') == 'low'   ? 'selected' : '' }}>Stok Rendah (&le;10)</option>
          <option value="empty" {{ request('status') == 'empty' ? 'selected' : '' }}>Stok Habis</option>
        </select>
      </div>
      <div class="col-md-2 d-flex gap-2">
        <button class="btn btn-primary flex-1" style="flex:1">Filter</button>
        <a href="{{ route('stock.index') }}" class="btn btn-light px-3">Reset</a>
      </div>
    </form>
  </div>
</div>

{{-- Bulk action bar --}}
<div class="bulk-bar" id="bulkBar">
  <span id="selectedCount" style="font-size:13px;font-weight:600">0 produk dipilih</span>
  <div style="display:flex;align-items:center;gap:8px">
    <select id="bulkAction" class="form-select form-select-sm" style="width:130px;font-size:12px">
      <option value="add">Tambah Stok</option>
      <option value="set">Set Stok</option>
    </select>
    <input type="number" id="bulkQty" min="0" value="10" class="form-control form-control-sm"
           style="width:70px;font-size:12px;text-align:center">
    <button onclick="doBulk()" class="btn btn-sm" style="background:#4ade80;color:#111;font-weight:700;border:none">
      Terapkan
    </button>
    <button onclick="clearBulk()" class="btn btn-sm btn-light">Batal</button>
  </div>
</div>

{{-- Tabel Stok --}}
<div class="scard">
  <div class="scard-head">
    <i class="bi bi-boxes text-warning"></i>
    Daftar Stok ({{ $products->total() }} produk)
    <span style="font-size:12px;color:#9ca3af;font-weight:400;margin-left:4px">— klik nama untuk edit inline</span>
  </div>
  <div style="overflow-x:auto">
    <table class="table stock-table mb-0">
      <thead>
        <tr>
          <th style="width:36px">
            <input type="checkbox" id="checkAll" style="width:14px;height:14px;accent-color:#3d6b4f;cursor:pointer">
          </th>
          <th>Produk</th>
          <th class="d-none d-md-table-cell">Kategori</th>
          <th>Stok Saat Ini</th>
          <th>Status</th>
          <th>Update Stok</th>
        </tr>
      </thead>
      <tbody>
        @forelse($products as $product)
        <tr data-id="{{ $product->id }}">
          <td>
            <input type="checkbox" class="row-check" value="{{ $product->id }}"
                   style="width:14px;height:14px;accent-color:#3d6b4f;cursor:pointer">
          </td>
          <td style="font-weight:600;color:#1c1c1e">{{ $product->name }}</td>
          <td class="d-none d-md-table-cell" style="color:#6b7280">{{ $product->category->name ?? '-' }}</td>
          <td>
            <span class="stock-num fw-bold" style="font-size:14px;font-family:monospace;color:{{ $product->stock == 0 ? '#dc2626' : ($product->stock <= 10 ? '#92400e' : '#166534') }}">
              {{ $product->stock }}
            </span>
          </td>
          <td>
            @if($product->stock == 0)
              <span class="stock-badge sb-empty"><i class="bi bi-x-circle-fill" style="font-size:10px"></i> Habis</span>
            @elseif($product->stock <= 10)
              <span class="stock-badge sb-low"><i class="bi bi-exclamation-triangle-fill" style="font-size:10px"></i> Rendah</span>
            @else
              <span class="stock-badge sb-ok"><i class="bi bi-check-circle-fill" style="font-size:10px"></i> Aman</span>
            @endif
          </td>
          <td>
            <div class="stock-ctrl">
              <input type="number" class="qty-inp" value="10" min="0">
              <button class="btn-upd btn-add" onclick="updateStock({{ $product->id }}, 'add', this)">+ Tambah</button>
              <button class="btn-upd btn-set" onclick="updateStock({{ $product->id }}, 'set', this)">Set</button>
            </div>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="6" class="text-center py-5 text-muted">
            <i class="bi bi-inbox" style="font-size:28px;display:block;margin-bottom:8px"></i>
            Tidak ada produk
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
  @if($products->hasPages())
  <div style="padding:12px 20px;border-top:1px solid #f3f4f6">
    {{ $products->links() }}
  </div>
  @endif
</div>

@endsection

@push('scripts')
<script>
const CSRF = document.querySelector('meta[name="csrf-token"]').content;

function showToast(msg, ok) {
  var el = document.createElement('div');
  el.style.cssText = 'position:fixed;bottom:20px;left:50%;transform:translateX(-50%);background:'+(ok?'#1a3d2b':'#dc2626')+';color:#fff;padding:9px 20px;border-radius:100px;font-size:13px;font-weight:600;z-index:9999;transition:opacity .3s';
  el.textContent = msg;
  document.body.appendChild(el);
  setTimeout(function(){ el.style.opacity=0; setTimeout(function(){ el.remove(); }, 400); }, 2500);
}

async function updateStock(id, action, btn) {
  var row = btn.closest('tr');
  var qty = parseInt(row.querySelector('.qty-inp').value) || 0;
  if (qty < 0) return;

  btn.disabled = true;
  var old = btn.textContent;
  btn.textContent = '...';

  try {
    var res = await fetch('/stock/' + id, {
      method: 'PATCH',
      headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
      body: JSON.stringify({ stock: qty, action: action }),
    });
    var data = await res.json();
    if (data.success) {
      var numEl = row.querySelector('.stock-num');
      numEl.textContent = data.new_stock;
      numEl.style.color = data.new_stock == 0 ? '#dc2626' : (data.new_stock <= 10 ? '#92400e' : '#166534');
      // Update badge
      var badge = row.querySelector('.stock-badge');
      if (data.new_stock == 0) {
        badge.className = 'stock-badge sb-empty';
        badge.innerHTML = '<i class="bi bi-x-circle-fill" style="font-size:10px"></i> Habis';
      } else if (data.new_stock <= 10) {
        badge.className = 'stock-badge sb-low';
        badge.innerHTML = '<i class="bi bi-exclamation-triangle-fill" style="font-size:10px"></i> Rendah';
      } else {
        badge.className = 'stock-badge sb-ok';
        badge.innerHTML = '<i class="bi bi-check-circle-fill" style="font-size:10px"></i> Aman';
      }
      showToast('Stok diperbarui: ' + data.new_stock, true);
    } else {
      showToast('Gagal memperbarui stok', false);
    }
  } catch(e) { showToast('Terjadi kesalahan', false); }
  finally { btn.disabled = false; btn.textContent = old; }
}

/* Bulk */
var selected = new Set();

document.getElementById('checkAll').addEventListener('change', function() {
  document.querySelectorAll('.row-check').forEach(function(c) {
    c.checked = this.checked;
    if (this.checked) selected.add(parseInt(c.value));
    else selected.delete(parseInt(c.value));
  }, this);
  updateBulkBar();
});

document.querySelectorAll('.row-check').forEach(function(c) {
  c.addEventListener('change', function() {
    if (this.checked) selected.add(parseInt(this.value));
    else selected.delete(parseInt(this.value));
    updateBulkBar();
  });
});

function updateBulkBar() {
  var bar = document.getElementById('bulkBar');
  if (selected.size > 0) {
    bar.classList.add('show');
    document.getElementById('selectedCount').textContent = selected.size + ' produk dipilih';
  } else {
    bar.classList.remove('show');
  }
}

function clearBulk() {
  selected.clear();
  document.querySelectorAll('.row-check').forEach(function(c){ c.checked = false; });
  document.getElementById('checkAll').checked = false;
  updateBulkBar();
}

function doBulk() {
  var action = document.getElementById('bulkAction').value;
  var qty    = parseInt(document.getElementById('bulkQty').value) || 0;
  if (!selected.size || qty < 0) return;

  var form = document.createElement('form');
  form.method = 'POST';
  form.action = '{{ route("stock.bulk") }}';
  form.innerHTML = '<input name="_token" value="'+CSRF+'">';

  var i = 0;
  selected.forEach(function(id) {
    form.innerHTML += '<input name="items['+i+'][id]" value="'+id+'">';
    form.innerHTML += '<input name="items['+i+'][stock]" value="'+qty+'">';
    form.innerHTML += '<input name="items['+i+'][action]" value="'+action+'">';
    i++;
  });

  document.body.appendChild(form);
  form.submit();
}
</script>
@endpush
