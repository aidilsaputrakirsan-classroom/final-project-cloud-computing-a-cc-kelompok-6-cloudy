<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Membuat user contoh
        // User::factory()->create([
        //  'name' => 'Test User',
        //  'email' => 'test@example.com',
        //]);

        // Jalankan seeder lainnya
        $this->call([
            CategorySeeder::class,
            ProductSeeder::class,
        ]);
    }
}
