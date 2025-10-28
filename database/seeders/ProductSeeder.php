<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            // Kategori Pria
            [
                'name' => 'Kemeja Formal Putih',
                'description' => 'Kemeja formal putih berbahan cotton premium, nyaman dan elegan untuk acara resmi',
                'price' => 399000,
                'stock' => 45,
                'image' => 'https://images.unsplash.com/photo-1596755094514-f87e34085b2c?w=400&h=400&fit=crop',
                'category' => 'pria'
            ],
            [
                'name' => 'Kaos Casual Pria',
                'description' => 'Kaos t-shirt casual dengan bahan cotton ringan',
                'price' => 149000,
                'stock' => 78,
                'image' => 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=400&h=400&fit=crop',
                'category' => 'pria'
            ],
            [
                'name' => 'Hoodie Streetwear',
                'description' => 'Jaket hoodie streetwear dengan desain modern',
                'price' => 699000,
                'stock' => 15,
                'image' => 'https://images.unsplash.com/photo-1551028719-00167b16eac5?w=400&h=400&fit=crop',
                'category' => 'pria'
            ],
            [
                'name' => 'Celana Jeans Slim Fit',
                'description' => 'Celana jeans dengan potongan slim fit modern',
                'price' => 549000,
                'stock' => 32,
                'image' => 'https://images.unsplash.com/photo-1542272604-787c3835535d?w=400&h=400&fit=crop',
                'category' => 'pria'
            ],
            [
                'name' => 'Sepatu Sneakers Sporty',
                'description' => 'Sepatu sneakers dengan desain sporty nyaman',
                'price' => 899000,
                'stock' => 28,
                'image' => 'https://images.unsplash.com/photo-1542291026-7eec255ccefe?w=400&h=400&fit=crop',
                'category' => 'pria'
            ],
            [
                'name' => 'Sweater Rajut Pria',
                'description' => 'Sweater rajut hangat dengan desain casual',
                'price' => 449000,
                'stock' => 15,
                'image' => 'https://images.unsplash.com/photo-1539533018447-63fcce2678e3?w=400&h=400&fit=crop',
                'category' => 'pria'
            ],

            // Kategori Wanita
            [
                'name' => 'Dress Casual Warna Pastel',
                'description' => 'Dress cantik dengan motif casual warna soft',
                'price' => 599000,
                'stock' => 23,
                'image' => 'https://images.unsplash.com/photo-1594633313593-bab3825d0caf?w=400&h=400&fit=crop',
                'category' => 'wanita'
            ],
            [
                'name' => 'Blouse Formal Wanita',
                'description' => 'Blouse formal dengan bahan sutera premium',
                'price' => 479000,
                'stock' => 34,
                'image' => 'https://images.unsplash.com/photo-1604575572524-4fb97e76a095?w=400&h=400&fit=crop',
                'category' => 'wanita'
            ],
            [
                'name' => 'Crop Top Kaos',
                'description' => 'Crop top casual dengan motif trendy',
                'price' => 199000,
                'stock' => 42,
                'image' => 'https://images.unsplash.com/photo-1595777457583-95e059d581b8?w=400&h=400&fit=crop',
                'category' => 'wanita'
            ],
            [
                'name' => 'Jaket Blazer Wanita',
                'description' => 'Jaket blazer formal dengan potongan modern',
                'price' => 799000,
                'stock' => 12,
                'image' => 'https://images.unsplash.com/photo-1567254790685-6b6d6abe4699?w=400&h=400&fit=crop',
                'category' => 'wanita'
            ],
            [
                'name' => 'Rok Mini Wanita',
                'description' => 'Rok midi dengan potongan A-line elegan',
                'price' => 379000,
                'stock' => 28,
                'image' => 'https://images.unsplash.com/photo-1594635185964-899319d6eab4?w=400&h=400&fit=crop',
                'category' => 'wanita'
            ],
            [
                'name' => 'Legging Sporty',
                'description' => 'Legging stretch untuk aktivitas olahraga',
                'price' => 279000,
                'stock' => 56,
                'image' => 'https://images.unsplash.com/photo-1544966503-7cc63b0cb9e8?w=400&h=400&fit=crop',
                'category' => 'wanita'
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
