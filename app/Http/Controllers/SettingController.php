<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::all_map();
        return view('settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'store_name'     => 'required|string|max:100',
            'store_address'  => 'nullable|string|max:255',
            'store_phone'    => 'nullable|string|max:20',
            'store_email'    => 'nullable|email|max:100',
            'store_city'     => 'nullable|string|max:100',
            'qris_nmid'      => 'nullable|string|max:30',
            'qris_tid'       => 'nullable|string|max:30',
            'receipt_footer' => 'nullable|string|max:500',
            'tax_rate'       => 'nullable|numeric|min:0|max:100',
            'currency'       => 'nullable|string|max:10',
            'store_logo'     => 'nullable|image|max:2048',
        ]);

        // Upload logo
        if ($request->hasFile('store_logo')) {
            // Hapus logo lama
            $old = Setting::get('store_logo_path');
            if ($old && file_exists(public_path($old))) {
                unlink(public_path($old));
            }

            $file     = $request->file('store_logo');
            $filename = 'logo-' . time() . '.' . $file->getClientOriginalExtension();
            $dest     = public_path('images');
            if (!is_dir($dest)) mkdir($dest, 0755, true);
            $file->move($dest, $filename);

            Setting::set('store_logo_path', 'images/' . $filename);
        }

        // Simpan semua setting kecuali file
        $keys = [
            'store_name', 'store_address', 'store_phone', 'store_email',
            'store_city', 'qris_nmid', 'qris_tid', 'receipt_footer',
            'tax_rate', 'currency',
        ];

        foreach ($keys as $key) {
            Setting::set($key, $request->input($key, ''));
        }

        return back()->with('success', 'Pengaturan berhasil disimpan.');
    }
}
