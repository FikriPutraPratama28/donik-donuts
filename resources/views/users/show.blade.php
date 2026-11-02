@extends('layouts.app')
@section('title', 'Detail Karyawan')
@section('page-title', 'Detail Karyawan')

@section('topbar-actions')
<a href="{{ route('users.edit', $user) }}" class="btn btn-outline-primary btn-sm me-1">
    <i class="bi bi-pencil me-1"></i>Edit
</a>
@if($user->id !== auth()->id())
<form action="{{ route('users.toggle-status', $user) }}" method="POST" style="display:inline">
    @csrf @method('PATCH')
    <button type="submit" class="btn btn-sm {{ $user->is_active ? 'btn-outline-warning' : 'btn-outline-success' }}">
        <i class="bi bi-toggle-{{ $user->is_active ? 'on' : 'off' }} me-1"></i>
        {{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
    </button>
</form>
@endif
<a href="{{ route('users.index') }}" class="btn btn-light btn-sm ms-1">
    <i class="bi bi-arrow-left me-1"></i>Kembali
</a>
@endsection

@push('styles')
<style>
.profile-card{background:#fff;border-radius:16px;border:1px solid #e5e7eb;overflow:hidden;margin-bottom:20px}
.profile-header{background:linear-gradient(135deg,#1a3d2b 0%,#2d6a45 100%);padding:28px 28px 20px;position:relative}
.profile-av{width:70px;height:70px;border-radius:50%;background:rgba(255,255,255,.15);border:3px solid rgba(255,255,255,.3);display:flex;align-items:center;justify-content:center;font-size:26px;font-weight:800;color:#fff;margin-bottom:12px}
.profile-name{font-size:20px;font-weight:800;color:#fff;margin-bottom:4px}
.profile-sub{font-size:13px;color:rgba(255,255,255,.6)}
.profile-body{padding:20px 24px}
.info-row{display:flex;align-items:flex-start;gap:10px;padding:8px 0;border-bottom:1px solid #f9fafb}
.info-row:last-child{border-bottom:none}
.info-ico{width:32px;height:32px;border-radius:8px;background:#f3f4f6;display:flex;align-items:center;justify-content:center;font-size:13px;color:#6b7280;flex-shrink:0}
.info-lbl{font-size:11px;color:#9ca3af;text-transform:uppercase;letter-spacing:.3px;margin-bottom:2px}
.info-val{font-size:13px;font-weight:600;color:#1c1c1e}
.stat-mini{display:grid;grid-template-columns:1fr 1fr 1fr;gap:10px;padding:16px 24px;background:#f9fafb;border-top:1px solid #f3f4f6}
.sm-box{text-align:center}
.sm-v{font-size:18px;font-weight:800;color:#1c1c1e;letter-spacing:-.3px}
.sm-l{font-size:11px;color:#9ca3af;margin-top:2px}
.act-card{background:#fff;border-radius:14px;border:1px solid #e5e7eb;overflow:hidden}
.act-table th{font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:#9ca3af;padding:10px 16px;background:#f9fafb;border:none}
.act-table td{padding:11px 16px;vertical-align:middle;border-color:#f3f4f6;font-size:13px}
.act-table tbody tr:hover{background:#f9fafb}
.mpill{display:inline-flex;align-items:center;gap:4px;padding:3px 9px;border-radius:20px;font-size:11px;font-weight:600;text-transform:uppercase}
.mp-cash{background:#f0fdf4;color:#166534}
.mp-qris{background:#faf5ff;color:#7c3aed}
.mp-transfer{background:#eff6ff;color:#1d4ed8}
</style>
@endpush

@section('content')
<div class="row g-3">

    {{-- Profile Card --}}
    <div class="col-lg-4">
        <div class="profile-card">
            <div class="profile-header">
                <div class="profile-av">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                <div class="profile-name">{{ $user->name }}</div>
                <div class="profile-sub">
                    <span style="background:rgba(255,255,255,.15);padding:2px 10px;border-radius:20px;font-size:11px;font-weight:700;text-transform:uppercase">
                        {{ $user->role }}
                    </span>
                    &nbsp;
                    <span style="background:{{ $user->is_active ? 'rgba(74,222,128,.2)' : 'rgba(255,255,255,.1)' }};padding:2px 10px;border-radius:20px;font-size:11px;font-weight:700;color:{{ $user->is_active ? '#4ade80' : 'rgba(255,255,255,.4)' }}">
                        {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </div>
            </div>

            <div class="stat-mini">
                <div class="sm-box">
                    <div class="sm-v" style="color:#166534">{{ $user->transactions_count }}</div>
                    <div class="sm-l">Transaksi</div>
                </div>
                <div class="sm-box">
                    <div class="sm-v">Rp {{ $totalRevenue >= 1000000 ? number_format($totalRevenue/1000000, 1).'Jt' : number_format($totalRevenue/1000).'K' }}</div>
                    <div class="sm-l">Total Omzet</div>
                </div>
                <div class="sm-box">
                    <div class="sm-v">{{ $todayTransactions }}</div>
                    <div class="sm-l">Hari Ini</div>
                </div>
            </div>

            <div class="profile-body">
                <div class="info-row">
                    <div class="info-ico"><i class="bi bi-envelope"></i></div>
                    <div>
                        <div class="info-lbl">Email</div>
                        <div class="info-val">{{ $user->email }}</div>
                    </div>
                </div>
                <div class="info-row">
                    <div class="info-ico"><i class="bi bi-phone"></i></div>
                    <div>
                        <div class="info-lbl">No. HP</div>
                        <div class="info-val">{{ $user->phone ?? '-' }}</div>
                    </div>
                </div>
                <div class="info-row">
                    <div class="info-ico"><i class="bi bi-geo-alt"></i></div>
                    <div>
                        <div class="info-lbl">Alamat</div>
                        <div class="info-val">{{ $user->address ?? '-' }}</div>
                    </div>
                </div>
                <div class="info-row">
                    <div class="info-ico"><i class="bi bi-calendar3"></i></div>
                    <div>
                        <div class="info-lbl">Bergabung</div>
                        <div class="info-val">{{ $user->created_at->format('d M Y') }}</div>
                    </div>
                </div>
                <div class="info-row">
                    <div class="info-ico"><i class="bi bi-graph-up"></i></div>
                    <div>
                        <div class="info-lbl">Omzet Bulan Ini</div>
                        <div class="info-val" style="color:#166534">Rp {{ number_format($monthRevenue, 0, ',', '.') }}</div>
                    </div>
                </div>
            </div>

            {{-- Reset Password --}}
            <div style="padding:16px 24px;border-top:1px solid #f3f4f6">
                <button type="button" class="btn btn-warning w-100 fw-bold"
                        data-bs-toggle="modal" data-bs-target="#resetModal">
                    <i class="bi bi-key me-2"></i>Atur Ulang Password
                </button>
            </div>
        </div>

        {{-- Grafik 7 hari --}}
        <div class="profile-card">
            <div style="padding:14px 20px;border-bottom:1px solid #f3f4f6;font-weight:700;font-size:14px">
                <i class="bi bi-bar-chart me-2 text-success"></i>Penjualan 7 Hari
            </div>
            <div style="padding:16px;position:relative;height:160px">
                <canvas id="actChart"></canvas>
            </div>
        </div>
    </div>

    {{-- Aktivitas Transaksi --}}
    <div class="col-lg-8">
        <div class="act-card">
            <div style="padding:14px 20px;border-bottom:1px solid #f3f4f6;font-weight:700;font-size:14px;display:flex;align-items:center;justify-content:space-between">
                <span><i class="bi bi-activity me-2 text-primary"></i>Riwayat Transaksi ({{ $activities->total() }})</span>
            </div>
            <div style="overflow-x:auto">
                <table class="table act-table mb-0">
                    <thead>
                        <tr>
                            <th>Invoice</th>
                            <th>Pelanggan</th>
                            <th>Total</th>
                            <th>Metode</th>
                            <th>Waktu</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($activities as $trx)
                        <tr>
                            <td><span style="font-family:monospace;font-weight:700;font-size:12px">{{ $trx->invoice_number }}</span></td>
                            <td style="color:#6b7280">{{ $trx->customer_name ?? '-' }}</td>
                            <td style="font-weight:700;color:#166534">Rp {{ number_format($trx->total, 0, ',', '.') }}</td>
                            <td><span class="mpill mp-{{ $trx->payment_method }}">{{ $trx->payment_method }}</span></td>
                            <td style="color:#9ca3af;font-size:12px">{{ $trx->created_at->format('d M Y H:i') }}</td>
                            <td>
                                <a href="{{ route('transactions.show', $trx) }}"
                                   style="width:28px;height:28px;border-radius:7px;border:1px solid #e5e7eb;display:inline-flex;align-items:center;justify-content:center;color:#6b7280;text-decoration:none;font-size:13px">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" style="text-align:center;padding:50px;color:#9ca3af">
                                <i class="bi bi-receipt" style="font-size:28px;display:block;margin-bottom:10px;color:#d1d5db"></i>
                                Belum ada transaksi
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($activities->hasPages())
            <div style="padding:12px 20px;border-top:1px solid #f3f4f6">
                {{ $activities->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

{{-- Reset Password Modal --}}
<div class="modal fade" id="resetModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content" style="border-radius:16px;border:none">
            <div class="modal-header border-0 pb-0">
                <h6 class="modal-title fw-bold"><i class="bi bi-key me-2 text-warning"></i>Reset Password</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('users.reset-password', $user) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <p class="text-muted mb-3" style="font-size:13px">
                        Reset password untuk: <strong>{{ $user->name }}</strong>
                    </p>
                    <div class="mb-3">
                        <label class="form-label fw-semibold" style="font-size:13px">Password Baru <span class="text-danger">*</span></label>
                        <input type="password" name="password" class="form-control" required minlength="6" placeholder="Min. 6 karakter">
                    </div>
                    <div>
                        <label class="form-label fw-semibold" style="font-size:13px">Konfirmasi Password <span class="text-danger">*</span></label>
                        <input type="password" name="password_confirmation" class="form-control" required placeholder="Ulangi password">
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
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>
<script>
var cd = @json($chartData);
new Chart(document.getElementById('actChart'), {
    type: 'bar',
    data: {
        labels: cd.map(function(d){ return d.date; }),
        datasets: [{
            data: cd.map(function(d){ return parseFloat(d.total); }),
            backgroundColor: 'rgba(61,107,79,.45)',
            borderColor: '#3d6b4f', borderWidth: 2,
            borderRadius: 5, borderSkipped: false,
        }]
    },
    options: {
        responsive: true, maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: {
            y: { beginAtZero: true, grid: { color: '#f3f4f6' }, border: { display: false },
                ticks: { color: '#9ca3af', font: { size: 10 },
                    callback: function(v){ return v>=1000?'Rp '+(v/1000).toFixed(0)+'K':''; }
                }
            },
            x: { grid: { display: false }, border: { display: false },
                ticks: { color: '#9ca3af', font: { size: 10 } }
            }
        }
    }
});
</script>
@endpush
