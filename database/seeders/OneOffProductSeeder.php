<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class OneOffProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure a default category exists (optional)
        $categoryId = Category::query()->value('id');

        Product::firstOrCreate(
            ['name' => 'Mouse Wireless'],
            [
                'description' => 'Mouse nirkabel ergonomis',
                'price' => 120000,
                'stock' => 25,
                'category_id' => $categoryId,
                'image' => null,
            ]
        );
    }
}
