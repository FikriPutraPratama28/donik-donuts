@extends('layouts.app')

@section('title', 'Produk')
@section('page-title', 'Manajemen Produk')

@section('topbar-actions')
<a href="{{ route('products.create') }}" class="btn btn-primary btn-sm">
    <i class="bi bi-plus-lg me-1"></i>Tambah Produk
</a>
@endsection

@push('styles')
<style>
@media(max-width:480px){
    .card .card-body{padding:10px}
    .card-title{font-size:13px}
    .card-footer{padding:8px 10px 10px}
}
</style>
@endpush

@section('content')
<!-- Filter -->
<div class="card mb-4">
    <div class="card-body py-3">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-5">
                <div class="input-group">
                    <span class="input-group-text bg-white"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" class="form-control" name="search" value="{{ request('search') }}"
                           placeholder="Cari produk...">
                </div>
            </div>
            <div class="col-md-3">
                <select class="form-select" name="category_id">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="col-auto">
                <button class="btn btn-primary">Filter</button>
                <a href="{{ route('products.index') }}" class="btn btn-light ms-1">Reset</a>
            </div>
        </form>
    </div>
</div>

<!-- Products Grid -->
@if($products->isEmpty())
<div class="card text-center py-5">
    <i class="bi bi-box-seam fs-1 text-muted d-block mb-3"></i>
    <p class="text-muted mb-3">Belum ada produk</p>
    <a href="{{ route('products.create') }}" class="btn btn-primary mx-auto" style="width:fit-content">
        Tambah Produk Pertama
    </a>
</div>
@else
<div class="row g-3 mb-4">
    @foreach($products as $product)
    <div class="col-sm-6 col-md-4 col-xl-3">
        <div class="card h-100">
            <div style="height:160px;overflow:hidden;border-radius:14px 14px 0 0;background:#f0fff4">
                @if($product->image && file_exists(public_path($product->image)))
                <img src="{{ asset($product->image) }}" alt="{{ $product->name }}"
                     style="width:100%;height:100%;object-fit:cover">
                @else
                <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center">
  <svg width="60" height="60" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg">
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
                @endif
            </div>
            <div class="card-body p-3">
                <div class="d-flex align-items-start justify-content-between mb-1">
                    <h6 class="card-title mb-0 fw-semibold" style="font-size:14px">{{ $product->name }}</h6>
                    <span class="badge {{ $product->is_available ? 'bg-success' : 'bg-secondary' }} ms-2" style="font-size:10px">
                        {{ $product->is_available ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </div>
                <div class="text-muted mb-2" style="font-size:12px">{{ $product->category->name ?? '-' }}</div>
                <div class="d-flex justify-content-between align-items-center">
                    <div class="fw-bold" style="color:#2f855a;font-size:15px">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </div>
                    <div style="font-size:12px;color:{{ $product->stock <= 5 ? '#e53e3e' : '#718096' }}">
                        <i class="bi bi-boxes me-1"></i>{{ $product->stock }}
                    </div>
                </div>
            </div>
            <div class="card-footer bg-transparent d-flex gap-2 p-3 pt-0">
                <a href="{{ route('products.edit', $product) }}" class="btn btn-outline-primary btn-sm flex-1" style="flex:1">
                    <i class="bi bi-pencil me-1"></i>Edit
                </a>
                <form action="{{ route('products.destroy', $product) }}" method="POST"
                      onsubmit="return confirm('Hapus produk {{ $product->name }}?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-outline-danger btn-sm">
                        <i class="bi bi-trash"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
    @endforeach
</div>
{{ $products->links() }}
@endif
@endsection
