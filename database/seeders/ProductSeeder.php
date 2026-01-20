<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $nasi = Category::where('slug', 'nasi')->first();
        $snack = Category::where('slug', 'snack')->first();
        $minuman = Category::where('slug', 'minuman')->first();

        $products = [
            [
                'category_id' => $nasi?->id,
                'name' => 'Nasi Goreng',
                'description' => 'Nasi goreng sederhana, bisa pilih pedas/tidak.',
                'price' => 15000,
                'stock' => 20,
                'is_active' => true,
            ],
            [
                'category_id' => $nasi?->id,
                'name' => 'Mie Goreng',
                'description' => 'Mie goreng rumahan.',
                'price' => 14000,
                'stock' => 20,
                'is_active' => true,
            ],
            [
                'category_id' => $snack?->id,
                'name' => 'Pisang Goreng',
                'description' => 'Pisang goreng hangat.',
                'price' => 8000,
                'stock' => 30,
                'is_active' => true,
            ],
            [
                'category_id' => $minuman?->id,
                'name' => 'Es Teh Manis',
                'description' => 'Es teh manis segar.',
                'price' => 5000,
                'stock' => 50,
                'is_active' => true,
            ],
        ];

        foreach ($products as $p) {
            if (!$p['category_id']) continue;

            Product::updateOrCreate(
                ['slug' => Str::slug($p['name'])],
                $p
            );
        }
    }
}
