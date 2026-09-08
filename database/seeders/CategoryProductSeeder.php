<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class CategoryProductSeeder extends Seeder
{
    public function run(): void
    {
        $kopi = Category::create(['nama_kategori' => 'Kopi']);
        $nonKopi = Category::create(['nama_kategori' => 'Non-Kopi']);
        $makanan = Category::create(['nama_kategori' => 'Makanan Ringan']);

        $products = [
            ['category_id' => $kopi->id, 'nama_menu' => 'Espresso', 'harga' => 18000, 'stok' => 25],
            ['category_id' => $kopi->id, 'nama_menu' => 'Americano', 'harga' => 20000, 'stok' => 30],
            ['category_id' => $kopi->id, 'nama_menu' => 'Caramel Macchiato', 'harga' => 28000, 'stok' => 12],
            ['category_id' => $kopi->id, 'nama_menu' => 'Cappuccino', 'harga' => 25000, 'stok' => 20],
            ['category_id' => $nonKopi->id, 'nama_menu' => 'Ice Matcha Latte', 'harga' => 24000, 'stok' => 15],
            ['category_id' => $nonKopi->id, 'nama_menu' => 'Cokelat Panas', 'harga' => 20000, 'stok' => 18],
            ['category_id' => $nonKopi->id, 'nama_menu' => 'Teh Tarik', 'harga' => 15000, 'stok' => 22],
            ['category_id' => $makanan->id, 'nama_menu' => 'Roti Bakar Cokelat', 'harga' => 20000, 'stok' => 8],
            ['category_id' => $makanan->id, 'nama_menu' => 'Kentang Goreng', 'harga' => 15000, 'stok' => 10],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
