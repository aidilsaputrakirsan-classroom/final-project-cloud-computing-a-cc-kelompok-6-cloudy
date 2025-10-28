<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            ['name' => 'Laptop ASUS', 'price' => 15000000, 'stock' => 10],
            ['name' => 'Laptop Acer', 'price' => 12500000, 'stock' => 8],
            ['name' => 'Keyboard Mechanical', 'price' => 850000, 'stock' => 15],
            ['name' => 'Mouse Wireless', 'price' => 250000, 'stock' => 25],
            ['name' => 'Monitor 24 Inch', 'price' => 2000000, 'stock' => 5],
            ['name' => 'Headset Gaming', 'price' => 500000, 'stock' => 20],
            ['name' => 'SSD 1TB', 'price' => 1300000, 'stock' => 12],
            ['name' => 'Flashdisk 64GB', 'price' => 120000, 'stock' => 30],
        ];

        foreach ($products as $product) {
            DB::table('products')->insert([
                'name' => $product['name'],
                'price' => $product['price'],
                'stock' => $product['stock'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
