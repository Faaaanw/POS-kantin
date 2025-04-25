<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'), // Ganti dengan password aman
            'role' => 'admin',
        ]);

        // Kasir
        User::create([
            'name' => 'Kasir',
            'email' => 'kasir@example.com',
            'password' => Hash::make('password'), // Ganti dengan password aman
            'role' => 'kasir',
        ]);
    }
}
