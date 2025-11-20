<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::updateOrCreate(
            ['email' => 'admin@cloudywear.test'],
            [
                'name' => 'Admin',
                'password' => 'password123', // Biarkan cast 'hashed' yang menangani hashing
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );
    }
}
