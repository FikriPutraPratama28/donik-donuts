@extends('layouts.app')

@section('title', 'Manajemen Karyawan')
@section('page-title', 'Manajemen Karyawan')

@section('topbar-actions')
<a href="{{ route('users.create') }}" class="btn btn-primary btn-sm">
    <i class="bi bi-person-plus me-1"></i>Tambah Karyawan
</a>
@endsection

@push('styles')
<style>
.stat-row{display:grid;grid-template-columns:repeat(4,1fr);gap:12px;margin-bottom:20px}
@media(max-width:640px){.stat-row{grid-template-columns:1fr 1fr}}
@media(max-width:400px){.stat-row{grid-template-columns:1fr 1fr;gap:8px}}
@media(max-width:640px){
    .emp-table th,.emp-table td{padding:9px 10px;font-size:12px}
    .av-circle{width:30px;height:30px;font-size:12px}
    .action-btn{width:26px;height:26px;font-size:12px}
}
.stat-box{background:#fff;border:1px solid #e5e7eb;border-radius:12px;padding:14px 18px}
.stat-box .sv{font-size:22px;font-weight:800;color:#1c1c1e;letter-spacing:-.4px}
.stat-box .sl{font-size:12px;color:#6b7280;margin-top:3px;font-weight:500}
.emp-card{background:#fff;border-radius:14px;border:1px solid #e5e7eb;overflow:hidden}
.emp-table th{font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:#9ca3af;padding:10px 16px;background:#f9fafb;border:none}
.emp-table td{padding:12px 16px;vertical-align:middle;border-color:#f3f4f6}
.emp-table tbody tr:hover{background:#f9fafb}
.role-badge{display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.3px}
.rb-admin{background:#1a3d2b;color:#4ade80}
.rb-kasir{background:#eff6ff;color:#1d4ed8}
.status-dot{width:8px;height:8px;border-radius:50%;display:inline-block;flex-shrink:0}
.dot-on{background:#22c55e}
.dot-off{background:#e5e7eb}
.av-circle{width:36px;height:36px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:14px;font-weight:800;color:#fff;flex-shrink:0}
.action-btn{width:30px;height:30px;border-radius:7px;display:inline-flex;align-items:center;justify-content:center;border:1px solid #e5e7eb;color:#6b7280;text-decoration:none;font-size:13px;transition:all .15s;background:#fff;cursor:pointer}
.action-btn:hover{background:#f3f4f6;color:#1c1c1e}
.action-btn.danger:hover{background:#fef2f2;color:#dc2626;border-color:#fecaca}
.action-btn.warning:hover{background:#fffbeb;color:#92400e;border-color:#fde68a}
.action-btn.success:hover{background:#f0fdf4;color:#166534;border-color:#bbf7d0}
</style>
@endpush

@section('content')

<div class="stat-row">
    <div class="stat-box">
        <div class="sv">{{ $totalKaryawan }}</div>
        <div class="sl"><i class="bi bi-person-badge me-1"></i>Total Kasir</div>
    </div>
    <div class="stat-box">
        <div class="sv">{{ $totalAdmin }}</div>
        <div class="sl"><i class="bi bi-shield-fill me-1"></i>Total Admin</div>
    </div>
    <div class="stat-box">
        <div class="sv" style="color:#166534">{{ $totalAktif }}</div>
        <div class="sl"><i class="bi bi-check-circle-fill me-1 text-success"></i>Akun Aktif</div>
    </div>
    <div class="stat-box">
        <div class="sv" style="color:#dc2626">{{ $totalNonaktif }}</div>
        <div class="sl"><i class="bi bi-x-circle-fill me-1 text-danger"></i>Akun Nonaktif</div>
    </div>
</div>

{{-- Filter --}}
<div class="emp-card mb-3">
    <div style="padding:14px 20px">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-5">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0">
                        <i class="bi bi-search text-muted" style="font-size:13px"></i>
                    </span>
                    <input type="text" class="form-control border-start-0 ps-0" name="search"
                           value="{{ request('search') }}" placeholder="Cari nama atau email...">
                </div>
            </div>
            <div class="col-md-2">
                <select class="form-select" name="role">
                    <option value="">Semua Role</option>
                    <option value="admin"  {{ request('role') == 'admin'  ? 'selected' : '' }}>Admin</option>
                    <option value="kasir"  {{ request('role') == 'kasir'  ? 'selected' : '' }}>Kasir</option>
                </select>
            </div>
            <div class="col-md-2">
                <select class="form-select" name="status">
                    <option value="">Semua Status</option>
                    <option value="active"   {{ request('status') == 'active'   ? 'selected' : '' }}>Aktif</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>
            <div class="col-auto d-flex gap-2">
                <button class="btn btn-primary px-4">Filter</button>
                <a href="{{ route('users.index') }}" class="btn btn-light px-3">Reset</a>
            </div>
        </form>
    </div>
</div>

{{-- Table --}}
<div class="emp-card">
    <div style="overflow-x:auto">
        <table class="table emp-table mb-0">
            <thead>
                <tr>
                    <th>Karyawan</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th class="d-none d-lg-table-cell">No. HP</th>
                    <th class="d-none d-md-table-cell">Transaksi</th>
                    <th>Status</th>
                    <th class="d-none d-lg-table-cell">Bergabung</th>
                    <th style="width:160px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td>
                        <div style="display:flex;align-items:center;gap:10px">
                            <div class="av-circle" style="background:{{ $user->role === 'admin' ? '#1a3d2b' : '#1d4ed8' }}">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <div>
                                <div style="font-weight:700;font-size:13px;color:#1c1c1e">{{ $user->name }}</div>
                                @if($user->id === auth()->id())
                                <div style="font-size:10px;color:#9ca3af">(Anda)</div>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td style="color:#6b7280;font-size:13px">{{ $user->email }}</td>
                    <td>
                        <span class="role-badge {{ $user->role === 'admin' ? 'rb-admin' : 'rb-kasir' }}">
                            <i class="bi bi-{{ $user->role === 'admin' ? 'shield-fill' : 'person-badge' }}" style="font-size:10px"></i>
                            {{ $user->role }}
                        </span>
                    </td>
                    <td class="d-none d-lg-table-cell" style="font-size:13px;color:#6b7280">{{ $user->phone ?? '-' }}</td>
                    <td class="d-none d-md-table-cell">
                        <a href="{{ route('users.show', $user) }}"
                           style="font-size:13px;font-weight:700;color:#3d6b4f;text-decoration:none">
                            {{ $user->transactions_count }}x
                        </a>
                    </td>
                    <td>
                        <div style="display:flex;align-items:center;gap:6px">
                            <span class="status-dot {{ $user->is_active ? 'dot-on' : 'dot-off' }}"></span>
                            <span style="font-size:12px;font-weight:600;color:{{ $user->is_active ? '#166534' : '#9ca3af' }}">
                                {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </div>
                    </td>
                    <td style="font-size:12px;color:#9ca3af" class="d-none d-lg-table-cell">{{ $user->created_at->format('d M Y') }}</td>
                    <td>
                        <div style="display:flex;gap:4px;flex-wrap:wrap">
                            {{-- Detail/Aktivitas --}}
                            <a href="{{ route('users.show', $user) }}" class="action-btn success" title="Lihat Aktivitas">
                                <i class="bi bi-activity"></i>
                            </a>
                            {{-- Edit --}}
                            <a href="{{ route('users.edit', $user) }}" class="action-btn" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            {{-- Toggle Status --}}
                            @if($user->id !== auth()->id())
                            <form action="{{ route('users.toggle-status', $user) }}" method="POST" style="display:inline">
                                @csrf @method('PATCH')
                                <button type="submit" class="action-btn {{ $user->is_active ? 'warning' : 'success' }}"
                                        title="{{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                                    <i class="bi bi-{{ $user->is_active ? 'toggle-on' : 'toggle-off' }}"></i>
                                </button>
                            </form>
                            {{-- Reset Password --}}
                            <button type="button" class="action-btn warning" title="Reset Password"
                                    onclick="openReset({{ $user->id }}, '{{ $user->name }}')">
                                <i class="bi bi-key"></i>
                            </button>
                            {{-- Hapus --}}
                            <form action="{{ route('users.destroy', $user) }}" method="POST" style="display:inline"
                                  onsubmit="return confirm('Hapus karyawan {{ $user->name }}? Tidak bisa jika ada riwayat transaksi.')">
                                @csrf @method('DELETE')
                                <button type="submit" class="action-btn danger" title="Hapus">
                                    <i class="bi bi-trash3"></i>
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="text-align:center;padding:50px;color:#9ca3af">
                        <i class="bi bi-people" style="font-size:32px;display:block;margin-bottom:10px;color:#d1d5db"></i>
                        Tidak ada karyawan
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($users->hasPages())
    <div style="padding:12px 20px;border-top:1px solid #f3f4f6">
        {{ $users->links() }}
    </div>
    @endif
</div>

{{-- Modal Reset Password --}}
<div class="modal fade" id="resetModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content" style="border-radius:16px;border:none">
            <div class="modal-header border-0 pb-0">
                <h6 class="modal-title fw-bold">
                    <i class="bi bi-key me-2 text-warning"></i>Reset Password
                </h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="resetForm" method="POST">
                @csrf
                <div class="modal-body">
                    <p class="text-muted mb-3" style="font-size:13px" id="resetDesc"></p>
                    <div class="mb-3">
                        <label class="form-label fw-semibold" style="font-size:13px">Password Baru</label>
                        <input type="password" name="password" class="form-control" placeholder="Min. 6 karakter" required minlength="6">
                    </div>
                    <div class="mb-2">
                        <label class="form-label fw-semibold" style="font-size:13px">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password" required>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light rounded-3" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning rounded-3 fw-bold text-dark">
                        <i class="bi bi-key me-1"></i>Reset
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
function openReset(id, name) {
    document.getElementById('resetDesc').textContent = 'Reset password untuk: ' + name;
    document.getElementById('resetForm').action = '/users/' + id + '/reset-password';
    new bootstrap.Modal(document.getElementById('resetModal')).show();
}
</script>
@endpush
