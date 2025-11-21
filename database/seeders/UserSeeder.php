<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::updateOrCreate(
            ['email' => 'user@cloudywear.test'],
            [
                'name' => 'User',
                'password' => 'password123', // Biarkan cast 'hashed' yang menangani hashing
                'role' => 'user',
                'email_verified_at' => now(),
            ]
        );
    }
}

