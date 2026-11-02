<div class="mb-3">
    <label class="form-label fw-semibold">Nama Kategori <span class="text-danger">*</span></label>
    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
           value="{{ old('name', $category->name ?? '') }}" required placeholder="Contoh: Teh Panas">
    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>

<div class="mb-3">
    <label class="form-label fw-semibold">Deskripsi</label>
    <textarea name="description" class="form-control" rows="3"
              placeholder="Deskripsi singkat (opsional)">{{ old('description', $category->description ?? '') }}</textarea>
</div>

<div class="form-check form-switch">
    <input class="form-check-input" type="checkbox" name="is_active" id="isActive" value="1"
           {{ old('is_active', $category->is_active ?? true) ? 'checked' : '' }}>
    <label class="form-check-label fw-semibold" for="isActive">Kategori Aktif</label>
</div>
