<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $today     = Carbon::today();
        $thisMonth = Carbon::now()->startOfMonth();

        // Ringkasan hari ini
        $todaySales = Transaction::whereDate('created_at', $today)
            ->where('status', 'completed')
            ->sum('total');

        $todayTransactions = Transaction::whereDate('created_at', $today)
            ->where('status', 'completed')
            ->count();

        // Ringkasan bulan ini
        $monthSales = Transaction::where('created_at', '>=', $thisMonth)
            ->where('status', 'completed')
            ->sum('total');

        $monthTransactions = Transaction::where('created_at', '>=', $thisMonth)
            ->where('status', 'completed')
            ->count();

        // Produk terlaris hari ini
        $topProducts = DB::table('transaction_items')
            ->join('transactions', 'transaction_items.transaction_id', '=', 'transactions.id')
            ->join('products', 'transaction_items.product_id', '=', 'products.id')
            ->whereDate('transactions.created_at', $today)
            ->where('transactions.status', 'completed')
            ->select(
                'products.name',
                DB::raw('SUM(transaction_items.quantity) as total_qty'),
                DB::raw('SUM(transaction_items.subtotal) as total_revenue')
            )
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('total_qty')
            ->limit(5)
            ->get();

        // Grafik penjualan 7 hari terakhir
        $chartData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $chartData[] = [
                'date'  => $date->format('d M'),
                'total' => (float) Transaction::whereDate('created_at', $date)
                    ->where('status', 'completed')
                    ->sum('total'),
            ];
        }

        // Transaksi terbaru
        $recentTransactions = Transaction::with('user')
            ->where('status', 'completed')
            ->latest()
            ->limit(10)
            ->get();

        $totalProducts = Product::where('is_available', true)->count();
        $totalUsers    = User::where('is_active', true)->count();
        $lowStock      = Product::where('stock', '<=', 10)->where('is_available', true)->count();

        // Produk stok rendah (untuk widget notifikasi)
        $lowStockProducts = Product::with('category')
            ->where('stock', '<=', 10)
            ->where('is_available', true)
            ->orderBy('stock')
            ->limit(8)
            ->get();

        // Breakdown metode bayar bulan ini
        $paymentBreakdown = [];
        foreach (['cash', 'transfer', 'qris'] as $m) {
            $q = Transaction::where('payment_method', $m)
                ->where('status', 'completed')
                ->where('created_at', '>=', $thisMonth);
            $paymentBreakdown[$m] = [
                'count' => $q->count(),
                'total' => (float) $q->sum('total'),
            ];
        }

        // Grafik penjualan per jam hari ini (untuk real-time)
        $hourlyData = [];
        for ($h = 0; $h < 24; $h++) {
            $hourlyData[] = [
                'hour'  => str_pad($h, 2, '0', STR_PAD_LEFT) . ':00',
                'total' => (float) Transaction::whereDate('created_at', $today)
                    ->whereRaw('HOUR(created_at) = ?', [$h])
                    ->where('status', 'completed')
                    ->sum('total'),
            ];
        }

        return view('dashboard', compact(
            'todaySales',
            'todayTransactions',
            'monthSales',
            'monthTransactions',
            'topProducts',
            'chartData',
            'hourlyData',
            'recentTransactions',
            'totalProducts',
            'totalUsers',
            'lowStock',
            'lowStockProducts',
            'paymentBreakdown'
        ));
    }

    /**
     * API endpoint — dipanggil AJAX untuk refresh data real-time.
     * Mengembalikan JSON berisi semua data grafik + stat cards.
     */
    public function chartData(Request $request)
    {
        $today     = Carbon::today();
        $thisMonth = Carbon::now()->startOfMonth();

        // Stat cards
        $todaySales = (float) Transaction::whereDate('created_at', $today)
            ->where('status', 'completed')->sum('total');

        $todayTransactions = Transaction::whereDate('created_at', $today)
            ->where('status', 'completed')->count();

        $monthSales = (float) Transaction::where('created_at', '>=', $thisMonth)
            ->where('status', 'completed')->sum('total');

        $monthTransactions = Transaction::where('created_at', '>=', $thisMonth)
            ->where('status', 'completed')->count();

        $lowStock = Product::where('stock', '<=', 10)->where('is_available', true)->count();

        // Grafik 7 hari terakhir
        $chartData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $chartData[] = [
                'date'  => $date->format('d M'),
                'total' => (float) Transaction::whereDate('created_at', $date)
                    ->where('status', 'completed')->sum('total'),
            ];
        }

        // Grafik per jam hari ini
        $hourlyData = [];
        for ($h = 0; $h < 24; $h++) {
            $hourlyData[] = [
                'hour'  => str_pad($h, 2, '0', STR_PAD_LEFT) . ':00',
                'total' => (float) Transaction::whereDate('created_at', $today)
                    ->whereRaw('HOUR(created_at) = ?', [$h])
                    ->where('status', 'completed')->sum('total'),
            ];
        }

        // Payment breakdown bulan ini
        $paymentBreakdown = [];
        foreach (['cash', 'transfer', 'qris'] as $m) {
            $q = Transaction::where('payment_method', $m)
                ->where('status', 'completed')
                ->where('created_at', '>=', $thisMonth);
            $paymentBreakdown[$m] = [
                'count' => $q->count(),
                'total' => (float) $q->sum('total'),
            ];
        }

        // Top produk hari ini
        $topProducts = DB::table('transaction_items')
            ->join('transactions', 'transaction_items.transaction_id', '=', 'transactions.id')
            ->join('products', 'transaction_items.product_id', '=', 'products.id')
            ->whereDate('transactions.created_at', $today)
            ->where('transactions.status', 'completed')
            ->select(
                'products.name',
                DB::raw('SUM(transaction_items.quantity) as total_qty'),
                DB::raw('SUM(transaction_items.subtotal) as total_revenue')
            )
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('total_qty')
            ->limit(5)
            ->get();

        // Transaksi terbaru (5 terakhir)
        $recentTransactions = Transaction::with('user')
            ->where('status', 'completed')
            ->latest()
            ->limit(5)
            ->get()
            ->map(fn ($t) => [
                'invoice_number' => $t->invoice_number,
                'cashier'        => $t->user->name ?? '-',
                'total'          => (float) $t->total,
                'payment_method' => $t->payment_method,
                'created_at'     => $t->created_at->format('d M H:i'),
                'show_url'       => route('transactions.show', $t),
            ]);

        return response()->json([
            'timestamp'          => now()->format('H:i:s'),
            'todaySales'         => $todaySales,
            'todayTransactions'  => $todayTransactions,
            'monthSales'         => $monthSales,
            'monthTransactions'  => $monthTransactions,
            'lowStock'           => $lowStock,
            'chartData'          => $chartData,
            'hourlyData'         => $hourlyData,
            'paymentBreakdown'   => $paymentBreakdown,
            'topProducts'        => $topProducts,
            'recentTransactions' => $recentTransactions,
        ]);
    }
}
