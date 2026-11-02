<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PosController extends Controller
{
    public function index()
    {
        $categories = Category::where('is_active', true)->with(['products' => function ($q) {
            $q->where('is_available', true)->where('stock', '>', 0);
        }])->get();

        return view('pos.index', compact('categories'));
    }

    public function getProducts(Request $request)
    {
        $query = Product::where('is_available', true)->where('stock', '>', 0);

        if ($request->category_id && $request->category_id != 'all') {
            $query->where('category_id', $request->category_id);
        }

        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $products = $query->with('category')->get();

        return response()->json($products->map(fn($p) => [
            'id'        => (int) $p->id,
            'name'      => $p->name,
            'price'     => (float) $p->price,
            'stock'     => (int) $p->stock,
            'image_url' => $p->image && file_exists(public_path($p->image))
                            ? asset($p->image)
                            : null,
            'category'  => $p->category->name ?? '-',
        ]));
    }

    public function checkout(Request $request)
    {
        $data = $request->validate([
            'items'          => 'required|array|min:1',
            'items.*.id'     => 'required|exists:products,id',
            'items.*.qty'    => 'required|integer|min:1',
            'payment_method' => 'required|in:cash,transfer,qris',
            'payment_amount' => 'required|numeric|min:0',
            'discount'       => 'nullable|numeric|min:0',
            'customer_name'  => 'nullable|string|max:100',
            'notes'          => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {
            $subtotal = 0;
            $itemsData = [];

            foreach ($data['items'] as $item) {
                $product = Product::lockForUpdate()->findOrFail($item['id']);

                if ($product->stock < $item['qty']) {
                    DB::rollBack();
                    return response()->json([
                        'success' => false,
                        'message' => "Stok {$product->name} tidak cukup. Stok tersisa: {$product->stock}",
                    ], 422);
                }

                $lineTotal = $product->price * $item['qty'];
                $subtotal += $lineTotal;

                $itemsData[] = [
                    'product_id'   => $product->id,
                    'product_name' => $product->name,
                    'price'        => $product->price,
                    'quantity'     => $item['qty'],
                    'subtotal'     => $lineTotal,
                ];

                $product->decrement('stock', $item['qty']);
            }

            $discount      = $data['discount'] ?? 0;
            $tax           = 0; // bisa dikonfigurasi
            $total         = $subtotal - $discount + $tax;
            $paymentAmount = $data['payment_amount'];
            $change        = $paymentAmount - $total;

            if ($change < 0) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Jumlah pembayaran kurang.',
                ], 422);
            }

            $transaction = Transaction::create([
                'invoice_number' => Transaction::generateInvoice(),
                'user_id'        => Auth::id(),
                'subtotal'       => $subtotal,
                'discount'       => $discount,
                'tax'            => $tax,
                'total'          => $total,
                'payment_amount' => $paymentAmount,
                'change_amount'  => $change,
                'payment_method' => $data['payment_method'],
                'status'         => 'completed',
                'customer_name'  => $data['customer_name'] ?? null,
                'notes'          => $data['notes'] ?? null,
            ]);

            foreach ($itemsData as $item) {
                $item['transaction_id'] = $transaction->id;
                TransactionItem::create($item);
            }

            DB::commit();

            return response()->json([
                'success'        => true,
                'invoice_number' => $transaction->invoice_number,
                'total'          => $total,
                'change'         => $change,
                'transaction_id' => $transaction->id,
                'message'        => 'Transaksi berhasil!',
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }
}
