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
    @if(file_exists(public_path('images/logo.png')))
        <img src="{{ asset('images/logo.png') }}" alt="Donik Donuts" width="80" height="80" style="border-radius:50%;object-fit:cover">
    @else
        <svg width="80" height="80" viewBox="0 0 110 110" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="55" cy="55" r="55" fill="#1a1a1a"/>
            <circle cx="55" cy="55" r="49" fill="none" stroke="#fff" stroke-width="2"/>
            <circle cx="55" cy="42" r="20" fill="#f5c518"/>
            <ellipse cx="55" cy="39" rx="16" ry="12" fill="#f472b6"/>
            <circle cx="55" cy="42" r="7" fill="#1a1a1a"/>
            <rect x="42" y="30" width="5" height="2" rx="1" fill="#22c55e" transform="rotate(-30 42 30)"/>
            <rect x="63" y="28" width="5" height="2" rx="1" fill="#3b82f6" transform="rotate(20 63 28)"/>
            <rect x="68" y="40" width="5" height="2" rx="1" fill="#f59e0b" transform="rotate(-10 68 40)"/>
            <text x="55" y="76" text-anchor="middle" font-family="Arial Black,sans-serif" font-weight="900" font-size="7" fill="#f472b6">DONIK DONUTS</text>
        </svg>
    @endif
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
