<div class="row g-3">
    <div class="col-md-8">
        <label class="form-label fw-semibold">Nama Produk <span class="text-danger">*</span></label>
        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
               value="{{ old('name', $product->name ?? '') }}" required>
        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-4">
        <label class="form-label fw-semibold">Kategori <span class="text-danger">*</span></label>
        <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
            <option value="">Pilih kategori</option>
            @foreach($categories as $cat)
            <option value="{{ $cat->id }}"
                {{ old('category_id', $product->category_id ?? '') == $cat->id ? 'selected' : '' }}>
                {{ $cat->name }}
            </option>
            @endforeach
        </select>
        @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-6">
        <label class="form-label fw-semibold">Harga (Rp) <span class="text-danger">*</span></label>
        <div class="input-group">
            <span class="input-group-text">Rp</span>
            <input type="number" name="price" class="form-control @error('price') is-invalid @enderror"
                   value="{{ old('price', $product->price ?? '') }}" min="0" required>
        </div>
        @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-6">
        <label class="form-label fw-semibold">Stok <span class="text-danger">*</span></label>
        <input type="number" name="stock" class="form-control @error('stock') is-invalid @enderror"
               value="{{ old('stock', $product->stock ?? 0) }}" min="0" required>
        @error('stock')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-12">
        <label class="form-label fw-semibold">Deskripsi</label>
        <textarea name="description" class="form-control" rows="3"
                  placeholder="Deskripsi produk (opsional)">{{ old('description', $product->description ?? '') }}</textarea>
    </div>

    <div class="col-12">
        <label class="form-label fw-semibold">Foto Produk</label>

        {{-- Preview gambar yang sudah ada --}}
        @if(!empty($product->image) && file_exists(public_path($product->image)))
        <div class="mb-2 d-flex align-items-center gap-3">
            <img src="{{ asset($product->image) }}" alt="foto saat ini"
                 id="currentImg"
                 style="height:80px;width:80px;object-fit:cover;border-radius:8px;border:1px solid #e2e8f0">
            <span style="font-size:12px;color:#718096">Foto saat ini</span>
        </div>
        @endif

        {{-- Preview gambar baru sebelum upload --}}
        <div id="previewWrap" style="display:none;margin-bottom:10px">
            <img id="previewImg" src="" alt="preview"
                 style="height:80px;width:80px;object-fit:cover;border-radius:8px;border:2px solid #2f855a">
            <div style="font-size:11px;color:#2f855a;margin-top:4px">
                <i class="bi bi-check-circle-fill me-1"></i>Preview gambar baru
            </div>
        </div>

        <input type="file" name="image" id="imageInput"
               class="form-control @error('image') is-invalid @enderror"
               accept="image/jpeg,image/png,image/webp">
        <div class="form-text">
            <i class="bi bi-shield-check text-success me-1"></i>
            Maks. 4MB &middot; Format: JPG, PNG, WebP &middot;
            <strong>Gambar disimpan permanen di server</strong>
        </div>
        @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-12">
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" name="is_available" id="isAvailable" value="1"
                   {{ old('is_available', $product->is_available ?? true) ? 'checked' : '' }}>
            <label class="form-check-label fw-semibold" for="isAvailable">Produk Tersedia</label>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var input = document.getElementById('imageInput');
    if (!input) return;
    input.addEventListener('change', function() {
        var wrap = document.getElementById('previewWrap');
        var img  = document.getElementById('previewImg');
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                img.src = e.target.result;
                wrap.style.display = 'block';
            };
            reader.readAsDataURL(this.files[0]);
        } else {
            wrap.style.display = 'none';
        }
    });
});
</script>
