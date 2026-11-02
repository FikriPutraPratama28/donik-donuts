<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        $menu = [
            'TEA SERIES' => [
                ['name' => 'Original Tea',       'price' => 10000, 'stock' => 100],
                ['name' => 'Lemon Tea',           'price' => 12000, 'stock' => 100],
                ['name' => 'Honey Lemon Tea',     'price' => 14000, 'stock' => 80],
                ['name' => 'Jasmine Tea',         'price' => 12000, 'stock' => 80],
                ['name' => 'Peach Tea',           'price' => 14000, 'stock' => 80],
                ['name' => 'Strawberry Tea',      'price' => 14000, 'stock' => 80],
                ['name' => 'Passion Fruit Tea',   'price' => 15000, 'stock' => 70],
                ['name' => 'Taro Tea',            'price' => 15000, 'stock' => 70],
            ],
            'YAKULT SERIES' => [
                ['name' => 'Yakult Original',     'price' => 14000, 'stock' => 80],
                ['name' => 'Yakult Lemon',        'price' => 15000, 'stock' => 80],
                ['name' => 'Yakult Strawberry',   'price' => 15000, 'stock' => 80],
                ['name' => 'Yakult Peach',        'price' => 15000, 'stock' => 70],
                ['name' => 'Yakult Mango',        'price' => 15000, 'stock' => 70],
                ['name' => 'Yakult Grape',        'price' => 15000, 'stock' => 70],
            ],
            'BLEND SERIES' => [
                ['name' => 'Thai Tea',            'price' => 16000, 'stock' => 80],
                ['name' => 'Matcha Latte',        'price' => 18000, 'stock' => 70],
                ['name' => 'Taro Latte',          'price' => 18000, 'stock' => 70],
                ['name' => 'Brown Sugar Milk Tea','price' => 18000, 'stock' => 70],
                ['name' => 'Wintermelon Milk Tea','price' => 18000, 'stock' => 60],
                ['name' => 'Cheese Tea',          'price' => 20000, 'stock' => 60],
                ['name' => 'Okinawa Milk Tea',    'price' => 18000, 'stock' => 60],
            ],
            'COFFEE SERIES' => [
                ['name' => 'Americano',           'price' => 15000, 'stock' => 80],
                ['name' => 'Latte',               'price' => 18000, 'stock' => 70],
                ['name' => 'Cappuccino',          'price' => 18000, 'stock' => 70],
                ['name' => 'Hazelnut Latte',      'price' => 20000, 'stock' => 60],
                ['name' => 'Caramel Latte',       'price' => 20000, 'stock' => 60],
                ['name' => 'Vietnam Drip',        'price' => 18000, 'stock' => 70],
                ['name' => 'Dalgona Coffee',      'price' => 20000, 'stock' => 60],
            ],
        ];

        foreach ($menu as $catName => $products) {
            $cat = Category::create([
                'name'        => $catName,
                'slug'        => Str::slug($catName),
                'description' => $catName . ' pilihan Donik Donuts',
                'is_active'   => true,
            ]);

            foreach ($products as $p) {
                Product::create([
                    'category_id'  => $cat->id,
                    'name'         => $p['name'],
                    'slug'         => Str::slug($p['name']) . '-' . time() . rand(1, 9999),
                    'price'        => $p['price'],
                    'stock'        => $p['stock'],
                    'is_available' => true,
                ]);
            }
        }
    }
}
