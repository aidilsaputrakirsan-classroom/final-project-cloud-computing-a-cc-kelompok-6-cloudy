<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'user@cloudywear.test'],
            [
                'name' => 'User',
                'password' => Hash::make('password123'), // HARUS HASH!
                'role' => 'user',
                'email_verified_at' => now(),
            ]
        );
    }
}