<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        if (!User::where('email', 'admin@example.com')->exists()) {
            User::create([
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]);
            $this->command->info('Admin user created!');
        } else {
            $this->command->info('Admin user already exists.');
        }

        if (!User::where('email', 'user@example.com')->exists()) {
            User::create([
                'name' => 'Regular User',
                'email' => 'user@example.com',
                'password' => Hash::make('password'),
                'role' => 'user',
            ]);
            $this->command->info('Regular user created!');
        } else {
            $this->command->info('Regular user already exists.');
        }
    }
}