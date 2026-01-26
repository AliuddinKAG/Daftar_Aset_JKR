<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin User
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@example.com',
            'username' => 'admin',
            'password' => Hash::make('P@ssw0rd'), // Ganti dengan password yang secure
            'role' => 'admin',
            'is_active' => true,
        ]);

        // Create Regular User
        User::create([
            'name' => 'Regular User',
            'email' => 'user@example.com',
            'username' => 'user',
            'password' => Hash::make('user123'), // Ganti dengan password yang secure
            'role' => 'user',
            'is_active' => true,
        ]);
    }
}