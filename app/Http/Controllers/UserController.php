<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::withCount('transactions');

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->role) {
            $query->where('role', $request->role);
        }

        if ($request->status === 'active') {
            $query->where('is_active', true);
        } elseif ($request->status === 'inactive') {
            $query->where('is_active', false);
        }

        $users = $query->latest()->paginate(15)->withQueryString();

        $totalKaryawan  = User::where('role', 'kasir')->count();
        $totalAdmin     = User::where('role', 'admin')->count();
        $totalAktif     = User::where('is_active', true)->count();
        $totalNonaktif  = User::where('is_active', false)->count();

        return view('users.index', compact(
            'users', 'totalKaryawan', 'totalAdmin', 'totalAktif', 'totalNonaktif'
        ));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'role'     => 'required|in:admin,kasir',
            'phone'    => 'nullable|string|max:20',
            'address'  => 'nullable|string|max:255',
        ]);

        $data['password']  = Hash::make($data['password']);
        $data['is_active'] = true;

        User::create($data);

        return redirect()->route('users.index')
            ->with('success', 'Karyawan berhasil ditambahkan.');
    }

    public function show(User $user)
    {
        $user->loadCount('transactions');

        // Aktivitas transaksi 30 hari terakhir
        $activities = Transaction::with('items')
            ->where('user_id', $user->id)
            ->where('status', 'completed')
            ->latest()
            ->paginate(15);

        // Ringkasan statistik
        $totalRevenue = Transaction::where('user_id', $user->id)
            ->where('status', 'completed')
            ->sum('total');

        $monthRevenue = Transaction::where('user_id', $user->id)
            ->where('status', 'completed')
            ->where('created_at', '>=', Carbon::now()->startOfMonth())
            ->sum('total');

        $todayTransactions = Transaction::where('user_id', $user->id)
            ->where('status', 'completed')
            ->whereDate('created_at', Carbon::today())
            ->count();

        // Chart 7 hari
        $chartData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $chartData[] = [
                'date'  => $date->format('d M'),
                'total' => Transaction::where('user_id', $user->id)
                    ->where('status', 'completed')
                    ->whereDate('created_at', $date)
                    ->sum('total'),
            ];
        }

        return view('users.show', compact(
            'user', 'activities', 'totalRevenue', 'monthRevenue', 'todayTransactions', 'chartData'
        ));
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name'    => 'required|string|max:100',
            'email'   => 'required|email|unique:users,email,' . $user->id,
            'role'    => 'required|in:admin,kasir',
            'phone'   => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
        ]);

        $data['is_active'] = $request->boolean('is_active');
        $user->update($data);

        return redirect()->route('users.index')
            ->with('success', 'Data karyawan berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Tidak bisa menghapus akun sendiri.');
        }

        if ($user->transactions()->count() > 0) {
            return back()->with('error', 'Karyawan memiliki riwayat transaksi. Nonaktifkan saja.');
        }

        $user->delete();
        return redirect()->route('users.index')
            ->with('success', 'Karyawan berhasil dihapus.');
    }

    public function toggleStatus(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Tidak bisa menonaktifkan akun sendiri.');
        }

        $user->update(['is_active' => !$user->is_active]);

        $status = $user->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return back()->with('success', "Akun {$user->name} berhasil {$status}.");
    }

    public function resetPassword(Request $request, User $user)
    {
        $data = $request->validate([
            'password' => 'required|min:6|confirmed',
        ]);

        $user->update(['password' => Hash::make($data['password'])]);

        return back()->with('success', "Password {$user->name} berhasil direset.");
    }
}
