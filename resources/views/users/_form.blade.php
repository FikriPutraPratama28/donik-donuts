<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
               value="{{ old('name', $user->name ?? '') }}" required placeholder="Contoh: Budi Santoso">
        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-6">
        <label class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
               value="{{ old('email', $user->email ?? '') }}" required placeholder="email@tehkota.com">
        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-6">
        <label class="form-label fw-semibold">No. HP</label>
        <div class="input-group">
            <span class="input-group-text"><i class="bi bi-phone text-muted"></i></span>
            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror"
                   value="{{ old('phone', $user->phone ?? '') }}" placeholder="08xxxxxxxxxx">
        </div>
        @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-6">
        <label class="form-label fw-semibold">Role <span class="text-danger">*</span></label>
        <select name="role" class="form-select @error('role') is-invalid @enderror" required>
            <option value="kasir" {{ old('role', $user->role ?? 'kasir') == 'kasir' ? 'selected' : '' }}>Kasir</option>
            <option value="admin" {{ old('role', $user->role ?? '') == 'admin' ? 'selected' : '' }}>Admin</option>
        </select>
        @error('role')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-12">
        <label class="form-label fw-semibold">Alamat</label>
        <textarea name="address" class="form-control" rows="2"
                  placeholder="Alamat lengkap (opsional)">{{ old('address', $user->address ?? '') }}</textarea>
    </div>

    @if(!isset($editMode))
    {{-- Create: wajib password --}}
    <div class="col-md-6">
        <label class="form-label fw-semibold">Password <span class="text-danger">*</span></label>
        <div class="input-group">
            <input type="password" name="password" id="pwdInp"
                   class="form-control @error('password') is-invalid @enderror"
                   required minlength="6" placeholder="Min. 6 karakter">
            <button type="button" class="input-group-text bg-white" onclick="togglePwd('pwdInp','eyeA')">
                <i class="bi bi-eye" id="eyeA"></i>
            </button>
        </div>
        @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6">
        <label class="form-label fw-semibold">Konfirmasi Password <span class="text-danger">*</span></label>
        <div class="input-group">
            <input type="password" name="password_confirmation" id="pwdInp2"
                   class="form-control" required minlength="6" placeholder="Ulangi password">
            <button type="button" class="input-group-text bg-white" onclick="togglePwd('pwdInp2','eyeB')">
                <i class="bi bi-eye" id="eyeB"></i>
            </button>
        </div>
    </div>
    @endif

    @if(isset($editMode))
    <div class="col-12">
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" name="is_active" id="isActive" value="1"
                   {{ old('is_active', $user->is_active ?? true) ? 'checked' : '' }}>
            <label class="form-check-label fw-semibold" for="isActive">Akun Aktif</label>
        </div>
        <div class="form-text">Nonaktifkan untuk mencegah karyawan login</div>
    </div>
    @endif
</div>

<script>
function togglePwd(inputId, iconId) {
    var inp = document.getElementById(inputId);
    var ico = document.getElementById(iconId);
    if (inp.type === 'password') { inp.type = 'text'; ico.className = 'bi bi-eye-slash'; }
    else { inp.type = 'password'; ico.className = 'bi bi-eye'; }
}
</script>
