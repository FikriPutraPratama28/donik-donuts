@extends('layouts.app')

@section('title', 'Kategori')
@section('page-title', 'Manajemen Kategori')

@section('topbar-actions')
<a href="{{ route('categories.create') }}" class="btn btn-primary btn-sm">
    <i class="bi bi-plus-lg me-1"></i>Tambah Kategori
</a>
@endsection

@section('content')
<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Nama Kategori</th>
                    <th>Deskripsi</th>
                    <th>Produk</th>
                    <th>Status</th>
                    <th>Dibuat</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $cat)
                <tr>
                    <td style="color:#a0aec0;font-size:13px">{{ $loop->iteration }}</td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div style="width:8px;height:8px;border-radius:50%;background:{{ $cat->is_active ? '#48bb78' : '#a0aec0' }}"></div>
                            <span class="fw-semibold" style="font-size:14px">{{ $cat->name }}</span>
                        </div>
                    </td>
                    <td style="font-size:13px;color:#718096;max-width:200px">
                        {{ Str::limit($cat->description, 60, '...') ?: '—' }}
                    </td>
                    <td>
                        <span class="badge bg-primary bg-opacity-10 text-primary">
                            {{ $cat->products_count }} produk
                        </span>
                    </td>
                    <td>
                        <span class="badge {{ $cat->is_active ? 'bg-success' : 'bg-secondary' }}">
                            {{ $cat->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </td>
                    <td style="font-size:12px;color:#718096">{{ $cat->created_at->format('d M Y') }}</td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('categories.edit', $cat) }}" class="btn btn-sm btn-outline-primary py-0 px-2">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('categories.destroy', $cat) }}" method="POST"
                                  onsubmit="return confirm('Hapus kategori {{ $cat->name }}?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger py-0 px-2">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-5 text-muted">
                        <i class="bi bi-tags fs-2 d-block mb-2"></i>
                        Belum ada kategori.
                        <a href="{{ route('categories.create') }}">Buat sekarang</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($categories->hasPages())
    <div class="card-footer bg-transparent">{{ $categories->links() }}</div>
    @endif
</div>
@endsection
