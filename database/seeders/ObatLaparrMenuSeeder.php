<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ObatLaparrMenuSeeder extends Seeder
{
    public function run(): void
    {
        // Kategori utama untuk menu (ubah nama jika kamu mau kategori lain)
        $category = Category::firstOrCreate(
            ['slug' => 'menu-obat-laparr'],
            ['name' => 'Menu Obat Laparr', 'slug' => 'menu-obat-laparr']
        );

        $items = [
            ['name' => 'Tteobokki', 'price' => 10000, 'description' => null],
            ['name' => 'Rabokki', 'price' => 12000, 'description' => null],
            ['name' => 'Gimbap (chicken katsu)', 'price' => 15000, 'description' => null],
            ['name' => 'Odeng (2 tusuk) handmade korea', 'price' => 10000, 'description' => null],
            ['name' => 'Odeng strip (4 tusuk) handmade indo', 'price' => 10000, 'description' => null],
            ['name' => 'Dakbal (ceker pedas) pakai tulang', 'price' => 15000, 'description' => null],
            ['name' => 'Dakbal (ceker pedas) tanpa tulang', 'price' => 20000, 'description' => null],
            ['name' => 'Bunggeoppang (isi coklat) 1 pcs', 'price' => 10000, 'description' => null],
            ['name' => 'Mandu (isi ayam & sayuran)', 'price' => 18000, 'description' => null],
            ['name' => 'Kimchi 15 gr', 'price' => 15000, 'description' => null],
        ];

        foreach ($items as $it) {
            $baseSlug = Str::slug($it['name']);
            $slug = $baseSlug;
            $i = 2;

            while (Product::where('slug', $slug)->exists()) {
                $slug = $baseSlug . '-' . $i;
                $i++;
            }

            Product::updateOrCreate(
                ['slug' => $slug],
                [
                    'category_id' => $category->id,
                    'name' => $it['name'],
                    'description' => $it['description'],
                    'price' => $it['price'],
                    'stock' => 20,        // default stok awal, silakan ubah
                    'photo_path' => null, // nanti upload dari admin
                    'is_active' => true,
                ]
            );
        }
    }
}
