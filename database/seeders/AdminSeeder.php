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
        // Create single admin account
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@strawberry.com',
            'password' => Hash::make('Strawberry2024!'),
            'role' => 'admin',
        ]);

        $this->command->info('Admin account created successfully!');
        $this->command->info('Email: admin@strawberry.com');
        $this->command->info('Password: Strawberry2024!');
    }
}