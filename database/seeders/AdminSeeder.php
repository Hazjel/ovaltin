<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $email = env('ADMIN_SEED_EMAIL', 'admin@strawberry.com');
        $password = env('ADMIN_SEED_PASSWORD');

        if (! $password) {
            $this->command->error('ADMIN_SEED_PASSWORD belum diset di .env. Seeder dibatalkan.');
            return;
        }

        User::create([
            'name' => 'Administrator',
            'email' => $email,
            'password' => Hash::make($password),
            'role' => 'admin',
        ]);

        $this->command->info("Admin account created successfully: {$email}");
    }
}