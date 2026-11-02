<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category');

        if ($request->category_id) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->status === 'low') {
            $query->where('stock', '<=', 10);
        } elseif ($request->status === 'empty') {
            $query->where('stock', 0);
        }

        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $products   = $query->orderBy('stock')->paginate(20)->withQueryString();
        $categories = Category::where('is_active', true)->get();

        $lowCount   = Product::where('stock', '<=', 10)->where('stock', '>', 0)->count();
        $emptyCount = Product::where('stock', 0)->count();
        $totalStock = Product::sum('stock');

        return view('stock.index', compact(
            'products', 'categories', 'lowCount', 'emptyCount', 'totalStock'
        ));
    }

    public function updateStock(Request $request, Product $product)
    {
        $data = $request->validate([
            'stock'  => 'required|integer|min:0',
            'action' => 'required|in:set,add,reduce',
        ]);

        match ($data['action']) {
            'set'    => $product->update(['stock' => $data['stock']]),
            'add'    => $product->increment('stock', $data['stock']),
            'reduce' => $product->decrement('stock', min($data['stock'], $product->stock)),
        };

        return response()->json([
            'success'   => true,
            'new_stock' => $product->fresh()->stock,
            'message'   => 'Stok berhasil diperbarui.',
        ]);
    }

    public function bulkUpdate(Request $request)
    {
        $data = $request->validate([
            'items'          => 'required|array',
            'items.*.id'     => 'required|exists:products,id',
            'items.*.stock'  => 'required|integer|min:0',
            'items.*.action' => 'required|in:set,add',
        ]);

        foreach ($data['items'] as $item) {
            $product = Product::find($item['id']);
            if ($item['action'] === 'set') {
                $product->update(['stock' => $item['stock']]);
            } else {
                $product->increment('stock', $item['stock']);
            }
        }

        return redirect()->route('stock.index')
            ->with('success', count($data['items']) . ' produk berhasil diperbarui.');
    }
}
