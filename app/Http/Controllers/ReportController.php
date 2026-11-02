<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $dateFrom = $request->date_from
            ? Carbon::parse($request->date_from)->startOfDay()
            : Carbon::now()->startOfMonth();

        $dateTo = $request->date_to
            ? Carbon::parse($request->date_to)->endOfDay()
            : Carbon::now()->endOfDay();

        $method = $request->payment_method;

        // ── Ringkasan ──
        $query = Transaction::where('status', 'completed')
            ->whereBetween('created_at', [$dateFrom, $dateTo]);

        if ($method) $query->where('payment_method', $method);

        $totalRevenue      = (clone $query)->sum('total');
        $totalTransactions = (clone $query)->count();
        $totalDiscount     = (clone $query)->sum('discount');
        $avgTransaction    = $totalTransactions > 0 ? $totalRevenue / $totalTransactions : 0;

        // ── Per hari ──
        $dailyData = (clone $query)
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count, SUM(total) as revenue')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // ── Per kategori ──
        $categoryData = DB::table('transaction_items')
            ->join('transactions', 'transaction_items.transaction_id', '=', 'transactions.id')
            ->join('products', 'transaction_items.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->where('transactions.status', 'completed')
            ->whereBetween('transactions.created_at', [$dateFrom, $dateTo])
            ->when($method, fn($q) => $q->where('transactions.payment_method', $method))
            ->select(
                'categories.name as category',
                DB::raw('SUM(transaction_items.quantity) as total_qty'),
                DB::raw('SUM(transaction_items.subtotal) as total_revenue')
            )
            ->groupBy('categories.id', 'categories.name')
            ->orderByDesc('total_revenue')
            ->get();

        // ── Per produk terlaris ──
        $topProducts = DB::table('transaction_items')
            ->join('transactions', 'transaction_items.transaction_id', '=', 'transactions.id')
            ->where('transactions.status', 'completed')
            ->whereBetween('transactions.created_at', [$dateFrom, $dateTo])
            ->when($method, fn($q) => $q->where('transactions.payment_method', $method))
            ->select(
                'transaction_items.product_name',
                DB::raw('SUM(transaction_items.quantity) as total_qty'),
                DB::raw('SUM(transaction_items.subtotal) as total_revenue')
            )
            ->groupBy('transaction_items.product_id', 'transaction_items.product_name')
            ->orderByDesc('total_qty')
            ->limit(10)
            ->get();

        // ── Metode bayar ──
        $paymentData = (clone $query)
            ->selectRaw('payment_method, COUNT(*) as count, SUM(total) as revenue')
            ->groupBy('payment_method')
            ->get();

        // ── Transaksi list ──
        $transactions = (clone $query)
            ->with('user')
            ->latest()
            ->paginate(20)
            ->withQueryString();

        $categories = Category::all();

        return view('reports.index', compact(
            'dateFrom', 'dateTo', 'method',
            'totalRevenue', 'totalTransactions', 'totalDiscount', 'avgTransaction',
            'dailyData', 'categoryData', 'topProducts', 'paymentData',
            'transactions', 'categories'
        ));
    }

    public function exportCsv(Request $request)
    {
        $dateFrom = $request->date_from
            ? Carbon::parse($request->date_from)->startOfDay()
            : Carbon::now()->startOfMonth();
        $dateTo = $request->date_to
            ? Carbon::parse($request->date_to)->endOfDay()
            : Carbon::now()->endOfDay();

        $transactions = Transaction::with(['user', 'items'])
            ->where('status', 'completed')
            ->whereBetween('created_at', [$dateFrom, $dateTo])
            ->when($request->payment_method, fn($q) => $q->where('payment_method', $request->payment_method))
            ->latest()
            ->get();

        $filename = 'laporan-' . $dateFrom->format('Ymd') . '-' . $dateTo->format('Ymd') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($transactions) {
            $file = fopen('php://output', 'w');
            // BOM untuk Excel
            fwrite($file, "\xEF\xBB\xBF");
            // Header
            fputcsv($file, ['Invoice', 'Tanggal', 'Kasir', 'Pelanggan', 'Subtotal', 'Diskon', 'Total', 'Metode', 'Item']);

            foreach ($transactions as $trx) {
                fputcsv($file, [
                    $trx->invoice_number,
                    $trx->created_at->format('d/m/Y H:i'),
                    $trx->user->name,
                    $trx->customer_name ?? '-',
                    $trx->subtotal,
                    $trx->discount,
                    $trx->total,
                    strtoupper($trx->payment_method),
                    $trx->items->count(),
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportPdf(Request $request)
    {
        $dateFrom = $request->date_from
            ? Carbon::parse($request->date_from)->startOfDay()
            : Carbon::now()->startOfMonth();
        $dateTo = $request->date_to
            ? Carbon::parse($request->date_to)->endOfDay()
            : Carbon::now()->endOfDay();

        $transactions = Transaction::with('user')
            ->where('status', 'completed')
            ->whereBetween('created_at', [$dateFrom, $dateTo])
            ->when($request->payment_method, fn($q) => $q->where('payment_method', $request->payment_method))
            ->latest()
            ->get();

        $totalRevenue = $transactions->sum('total');

        return view('reports.pdf', compact('transactions', 'totalRevenue', 'dateFrom', 'dateTo'));
    }
}
