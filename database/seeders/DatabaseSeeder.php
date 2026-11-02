<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name'      => 'Admin Donik Donuts',
            'email'     => 'admin@donikdonuts.com',
            'password'  => Hash::make('admin123'),
            'role'      => 'admin',
            'is_active' => true,
        ]);

        // Kasir
        User::create([
            'name'      => 'Kasir 1',
            'email'     => 'kasir@donuts.com',
            'password'  => Hash::make('donuts123'),
            'role'      => 'kasir',
            'is_active' => true,
        ]);

        // Kategori
        $categories = [
            ['name' => 'Teh Panas',   'slug' => 'teh-panas',   'description' => 'Minuman teh panas pilihan'],
            ['name' => 'Teh Dingin',  'slug' => 'teh-dingin',  'description' => 'Teh segar dengan es'],
            ['name' => 'Teh Susu',    'slug' => 'teh-susu',    'description' => 'Perpaduan teh dan susu creamy'],
            ['name' => 'Makanan',     'slug' => 'makanan',     'description' => 'Camilan dan makanan pendamping'],
        ];

        foreach ($categories as $cat) {
            Category::create(array_merge($cat, ['is_active' => true]));
        }

        $cat1 = Category::where('slug', 'teh-panas')->first();
        $cat2 = Category::where('slug', 'teh-dingin')->first();
        $cat3 = Category::where('slug', 'teh-susu')->first();
        $cat4 = Category::where('slug', 'makanan')->first();

        $products = [
            // Teh Panas
            ['category_id' => $cat1->id, 'name' => 'Teh Original',       'price' => 8000,  'stock' => 100],
            ['category_id' => $cat1->id, 'name' => 'Teh Jahe',           'price' => 10000, 'stock' => 50],
            ['category_id' => $cat1->id, 'name' => 'Teh Melati',         'price' => 9000,  'stock' => 80],
            ['category_id' => $cat1->id, 'name' => 'Teh Lemon Panas',    'price' => 11000, 'stock' => 60],
            // Teh Dingin
            ['category_id' => $cat2->id, 'name' => 'Es Teh Manis',       'price' => 8000,  'stock' => 150],
            ['category_id' => $cat2->id, 'name' => 'Es Teh Lemon',       'price' => 12000, 'stock' => 100],
            ['category_id' => $cat2->id, 'name' => 'Es Teh Tarik',       'price' => 14000, 'stock' => 80],
            ['category_id' => $cat2->id, 'name' => 'Es Teh Poci',        'price' => 10000, 'stock' => 90],
            // Teh Susu
            ['category_id' => $cat3->id, 'name' => 'Teh Susu Original',  'price' => 15000, 'stock' => 70],
            ['category_id' => $cat3->id, 'name' => 'Teh Susu Gula Aren', 'price' => 18000, 'stock' => 60],
            ['category_id' => $cat3->id, 'name' => 'Thai Tea',           'price' => 18000, 'stock' => 50],
            ['category_id' => $cat3->id, 'name' => 'Teh Susu Tarik',     'price' => 16000, 'stock' => 65],
            // Makanan
            ['category_id' => $cat4->id, 'name' => 'Roti Bakar',         'price' => 12000, 'stock' => 40],
            ['category_id' => $cat4->id, 'name' => 'Singkong Goreng',    'price' => 10000, 'stock' => 50],
            ['category_id' => $cat4->id, 'name' => 'Pisang Goreng',      'price' => 8000,  'stock' => 60],
        ];

        foreach ($products as $p) {
            Product::create(array_merge($p, [
                'slug'         => \Illuminate\Support\Str::slug($p['name']) . '-' . time() . rand(1, 999),
                'is_available' => true,
            ]));
        }
    }
}
