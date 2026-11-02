<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category');

        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->category_id) {
            $query->where('category_id', $request->category_id);
        }

        $products   = $query->latest()->paginate(12)->withQueryString();
        $categories = Category::where('is_active', true)->get();

        return view('products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::where('is_active', true)->get();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id'  => 'required|exists:categories,id',
            'name'         => 'required|string|max:150',
            'description'  => 'nullable|string',
            'price'        => 'required|numeric|min:0',
            'stock'        => 'required|integer|min:0',
            'image'        => 'nullable|image|max:4096',
            'is_available' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $this->saveImage($request->file('image'));
        }

        $data['is_available'] = $request->boolean('is_available', true);

        Product::create($data);

        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(Product $product)
    {
        $categories = Category::where('is_active', true)->get();
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'category_id'  => 'required|exists:categories,id',
            'name'         => 'required|string|max:150',
            'description'  => 'nullable|string',
            'price'        => 'required|numeric|min:0',
            'stock'        => 'required|integer|min:0',
            'image'        => 'nullable|image|max:4096',
            'is_available' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            // Hapus gambar lama
            $this->deleteImage($product->image);
            $data['image'] = $this->saveImage($request->file('image'));
        }

        $data['is_available'] = $request->boolean('is_available');

        $product->update($data);

        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product)
    {
        $this->deleteImage($product->image);
        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil dihapus.');
    }

    /**
     * Simpan gambar langsung ke public/images/products/
     * Tidak bergantung pada storage link atau artisan.
     */
    private function saveImage($file): string
    {
        $ext      = $file->getClientOriginalExtension();
        $filename = Str::uuid() . '.' . $ext;
        $dest     = public_path('images/products');

        if (!is_dir($dest)) {
            mkdir($dest, 0755, true);
        }

        $file->move($dest, $filename);

        return 'images/products/' . $filename;
    }

    /**
     * Hapus gambar dari public/
     */
    private function deleteImage(?string $path): void
    {
        if (!$path) return;

        $full = public_path($path);
        if (file_exists($full)) {
            unlink($full);
        }
    }
}
