<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin User
        User::create([
            'name' => 'Admin Strawberry',
            'email' => 'admin@strawberry.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Create Regular User
        User::create([
            'name' => 'User Biasa',
            'email' => 'user@strawberry.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        // Create additional demo users
        User::create([
            'name' => 'Manager Produk',
            'email' => 'manager@strawberry.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Staff Penjualan',
            'email' => 'staff@strawberry.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);
    }
}
