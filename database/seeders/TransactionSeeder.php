<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class TransactionSeeder extends Seeder
{
    public function run(): void
    {
        $kasir    = User::where('role', 'kasir')->first();
        $admin    = User::where('role', 'admin')->first();
        $products = Product::all();

        if ($products->isEmpty()) return;

        $methods = ['cash', 'cash', 'cash', 'transfer', 'qris'];

        // 7 hari terakhir, 5–15 transaksi per hari
        for ($day = 6; $day >= 0; $day--) {
            $date  = Carbon::today()->subDays($day);
            $count = rand(5, 15);

            for ($t = 0; $t < $count; $t++) {
                $user     = rand(0, 1) ? $kasir : $admin;
                $method   = $methods[array_rand($methods)];
                $subtotal = 0;
                $items    = [];

                // 1–4 item per transaksi
                $itemCount = rand(1, 4);
                $picked    = $products->random(min($itemCount, $products->count()));

                foreach ($picked as $p) {
                    $qty      = rand(1, 3);
                    $line     = (float) $p->price * $qty;
                    $subtotal += $line;
                    $items[]  = [
                        'product_id'   => $p->id,
                        'product_name' => $p->name,
                        'price'        => (float) $p->price,
                        'quantity'     => $qty,
                        'subtotal'     => $line,
                    ];
                }

                $total  = $subtotal;
                $paid   = $method === 'cash'
                    ? $total + (rand(0, 3) * 5000)
                    : $total;
                $change = $paid - $total;

                $trx = Transaction::create([
                    'invoice_number' => 'TK-' . $date->format('Ymd') . '-' . str_pad($t + 1, 4, '0', STR_PAD_LEFT),
                    'user_id'        => $user->id,
                    'subtotal'       => $subtotal,
                    'discount'       => 0,
                    'tax'            => 0,
                    'total'          => $total,
                    'payment_amount' => $paid,
                    'change_amount'  => $change,
                    'payment_method' => $method,
                    'status'         => 'completed',
                    'created_at'     => $date->copy()->addHours(rand(8, 20))->addMinutes(rand(0, 59)),
                    'updated_at'     => $date->copy()->addHours(rand(8, 20))->addMinutes(rand(0, 59)),
                ]);

                foreach ($items as $item) {
                    $item['transaction_id'] = $trx->id;
                    TransactionItem::create($item);
                }
            }
        }
    }
}
