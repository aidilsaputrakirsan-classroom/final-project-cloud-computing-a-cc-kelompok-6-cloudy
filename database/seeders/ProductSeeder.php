<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Product::create([
            'name' => 'Laptop ASUS',
            'description' => 'Laptop untuk kebutuhan kerja dan kuliah',
            'price' => 12000000,
            'stock' => 5,
            'category_id' => 1 // id kategori "Elektronik"
        ]);

        Product::create([
            'name' => 'Kaos Polos',
            'description' => 'Kaos katun lembut ukuran L',
            'price' => 75000,
            'stock' => 30,
            'category_id' => 2 // id kategori "Pakaian"
        ]);

        Product::create([
            'name' => 'Snack Kentang',
            'description' => 'Cemilan ringan dan renyah',
            'price' => 15000,
            'stock' => 50,
            'category_id' => 3 // id kategori "Makanan"
        ]);
    }
}
