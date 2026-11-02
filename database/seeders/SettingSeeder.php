<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $defaults = [
            'store_name'     => 'Donik Donuts',
            'store_address'  => 'Jl. Contoh No. 1, Jakarta',
            'store_phone'    => '08123456789',
            'store_email'    => 'info@donikdonuts.com',
            'store_city'     => 'Jakarta',
            'qris_nmid'      => 'ID2026090900001',
            'qris_tid'       => 'TK-001',
            'receipt_footer' => 'Terima kasih sudah berkunjung! Semoga harimu menyenangkan.',
            'tax_rate'       => '0',
            'currency'       => 'IDR',
        ];

        foreach ($defaults as $key => $value) {
            Setting::firstOrCreate(['key' => $key], ['value' => $value]);
        }
    }
}
