@extends('layouts.app')

@section('title', 'Pengaturan Toko')
@section('page-title', 'Pengaturan Toko')

@push('styles')
<style>
.set-section{background:#fff;border:1px solid #e5e7eb;border-radius:14px;overflow:hidden;margin-bottom:20px}
.set-head{padding:16px 22px;border-bottom:1px solid #f3f4f6;font-weight:700;font-size:14px;display:flex;align-items:center;gap:8px}
.set-head .sh-icon{width:30px;height:30px;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:14px}
.set-body{padding:22px}
.set-row{display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:16px}
@media(max-width:640px){.set-row{grid-template-columns:1fr}}
.set-row.full{grid-template-columns:1fr}
label.set-lbl{display:block;font-size:12px;font-weight:700;color:#374151;text-transform:uppercase;letter-spacing:.4px;margin-bottom:6px}
.set-hint{font-size:11px;color:#9ca3af;margin-top:4px}
.logo-preview{width:80px;height:80px;border-radius:12px;object-fit:contain;border:1px solid #e5e7eb;background:#f9fafb;padding:4px}
.logo-placeholder{width:80px;height:80px;border-radius:12px;border:2px dashed #e5e7eb;display:flex;align-items:center;justify-content:center;background:#f9fafb;color:#d1d5db;font-size:28px}
.save-bar{position:sticky;bottom:0;background:#fff;border-top:1px solid #e5e7eb;padding:14px 22px;display:flex;align-items:center;justify-content:space-between;gap:12px;z-index:10;margin:-22px;margin-top:16px}
</style>
@endpush

@section('content')
<form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
@csrf

{{-- Informasi Toko --}}
<div class="set-section">
    <div class="set-head">
        <div class="sh-icon" style="background:#f0fdf4;color:#166534"><i class="bi bi-shop"></i></div>
        Informasi Toko
    </div>
    <div class="set-body">

        {{-- Logo --}}
        <div class="mb-4">
            <label class="set-lbl">Logo Toko</label>
            <div class="d-flex align-items-center gap-3">
                @if(!empty($settings['store_logo_path']) && file_exists(public_path($settings['store_logo_path'])))
                    <img src="{{ asset($settings['store_logo_path']) }}" class="logo-preview" id="logoPreview">
                @else
                    <div class="logo-placeholder" id="logoPlaceholder">
                        <i class="bi bi-image"></i>
                    </div>
                    <img src="" class="logo-preview d-none" id="logoPreview">
                @endif
                <div>
                    <input type="file" name="store_logo" id="logoInput" accept="image/*"
                           class="form-control" style="max-width:280px"
                           onchange="previewLogo(this)">
                    <div class="set-hint">PNG/JPG/WebP, maks. 2MB. Tampil di struk dan header.</div>
                </div>
            </div>
        </div>

        <div class="set-row">
            <div>
                <label class="set-lbl">Nama Toko *</label>
                <input type="text" name="store_name" class="form-control" required
                       value="{{ $settings['store_name'] ?? 'Donik Donuts' }}" placeholder="Contoh: Donik Donuts">
            </div>
            <div>
                <label class="set-lbl">Kota</label>
                <input type="text" name="store_city" class="form-control"
                       value="{{ $settings['store_city'] ?? '' }}" placeholder="Contoh: Jakarta">
            </div>
        </div>

        <div class="set-row full">
            <div>
                <label class="set-lbl">Alamat Toko</label>
                <textarea name="store_address" class="form-control" rows="2"
                          placeholder="Alamat lengkap toko">{{ $settings['store_address'] ?? '' }}</textarea>
            </div>
        </div>

        <div class="set-row">
            <div>
                <label class="set-lbl">No. Telepon</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-telephone" style="font-size:13px"></i></span>
                    <input type="text" name="store_phone" class="form-control"
                           value="{{ $settings['store_phone'] ?? '' }}" placeholder="08xxxxxxxxxx">
                </div>
            </div>
            <div>
                <label class="set-lbl">Email</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-envelope" style="font-size:13px"></i></span>
                    <input type="email" name="store_email" class="form-control"
                           value="{{ $settings['store_email'] ?? '' }}" placeholder="toko@email.com">
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Pengaturan Pembayaran --}}
<div class="set-section">
    <div class="set-head">
        <div class="sh-icon" style="background:#faf5ff;color:#7c3aed"><i class="bi bi-qr-code-scan"></i></div>
        Pengaturan QRIS
    </div>
    <div class="set-body">
        <div class="set-row">
            <div>
                <label class="set-lbl">NMID (Nomor Merchant)</label>
                <input type="text" name="qris_nmid" class="form-control" style="font-family:monospace"
                       value="{{ $settings['qris_nmid'] ?? 'ID2026090900001' }}" placeholder="NMID dari bank/e-wallet">
                <div class="set-hint">Didapat dari pendaftaran QRIS di bank atau penyedia.</div>
            </div>
            <div>
                <label class="set-lbl">TID (Terminal ID)</label>
                <input type="text" name="qris_tid" class="form-control" style="font-family:monospace"
                       value="{{ $settings['qris_tid'] ?? 'TK-001' }}" placeholder="TID dari bank/e-wallet">
            </div>
        </div>
    </div>
</div>

{{-- Pengaturan Transaksi --}}
<div class="set-section">
    <div class="set-head">
        <div class="sh-icon" style="background:#eff6ff;color:#1d4ed8"><i class="bi bi-receipt"></i></div>
        Pengaturan Transaksi & Struk
    </div>
    <div class="set-body">
        <div class="set-row">
            <div>
                <label class="set-lbl">Pajak (%)</label>
                <div class="input-group">
                    <input type="number" name="tax_rate" class="form-control" min="0" max="100" step="0.1"
                           value="{{ $settings['tax_rate'] ?? '0' }}" placeholder="0">
                    <span class="input-group-text">%</span>
                </div>
                <div class="set-hint">Kosongkan atau isi 0 jika tidak ada pajak.</div>
            </div>
            <div>
                <label class="set-lbl">Mata Uang</label>
                <select name="currency" class="form-select">
                    <option value="IDR" {{ ($settings['currency'] ?? 'IDR') == 'IDR' ? 'selected' : '' }}>IDR - Rupiah</option>
                    <option value="USD" {{ ($settings['currency'] ?? '') == 'USD' ? 'selected' : '' }}>USD - Dollar</option>
                    <option value="MYR" {{ ($settings['currency'] ?? '') == 'MYR' ? 'selected' : '' }}>MYR - Ringgit</option>
                </select>
            </div>
        </div>

        <div class="set-row full">
            <div>
                <label class="set-lbl">Pesan Footer Struk</label>
                <textarea name="receipt_footer" class="form-control" rows="3" maxlength="500"
                          placeholder="Contoh: Terima kasih sudah berkunjung! Semoga harimu menyenangkan.">{{ $settings['receipt_footer'] ?? 'Terima kasih sudah berkunjung!' }}</textarea>
                <div class="set-hint">Tampil di bagian bawah struk cetak. Maks. 500 karakter.</div>
            </div>
        </div>

        <div class="save-bar">
            <div style="font-size:13px;color:#9ca3af">
                <i class="bi bi-info-circle me-1"></i>
                Perubahan langsung berlaku setelah disimpan
            </div>
            <button type="submit" class="btn btn-primary px-5 fw-bold">
                <i class="bi bi-check-lg me-2"></i>Simpan Pengaturan
            </button>
        </div>
    </div>
</div>

</form>
@endsection

@push('scripts')
<script>
function previewLogo(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            var preview = document.getElementById('logoPreview');
            var placeholder = document.getElementById('logoPlaceholder');
            preview.src = e.target.result;
            preview.classList.remove('d-none');
            if (placeholder) placeholder.style.display = 'none';
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush
