<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::with(['user', 'items']);

        if ($request->search) {
            $query->where('invoice_number', 'like', '%' . $request->search . '%')
                ->orWhere('customer_name', 'like', '%' . $request->search . '%');
        }

        if ($request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        if ($request->payment_method) {
            $query->where('payment_method', $request->payment_method);
        }

        // Kasir hanya bisa lihat transaksi sendiri
        if (!Auth::user()->isAdmin()) {
            $query->where('user_id', Auth::id());
        }

        $transactions = $query->latest()->paginate(15)->withQueryString();

        $totalRevenue = $query->clone()->where('status', 'completed')->sum('total');

        return view('transactions.index', compact('transactions', 'totalRevenue'));
    }

    public function show(Transaction $transaction)
    {
        // Kasir hanya bisa lihat transaksi sendiri
        if (!Auth::user()->isAdmin() && $transaction->user_id !== Auth::id()) {
            abort(403);
        }

        $transaction->load(['user', 'items.product']);
        return view('transactions.show', compact('transaction'));
    }

    public function printReceipt(Transaction $transaction)
    {
        $transaction->load(['user', 'items']);
        return view('transactions.receipt', compact('transaction'));
    }
}
