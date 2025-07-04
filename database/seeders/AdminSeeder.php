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
        // Create admin user
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@portalberita.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'joined_at' => now(),
        ]);

        // Create sample regular user
        User::create([
            'name' => 'Pengguna',
            'email' => 'user@portalberita.com',
            'password' => Hash::make('user123'),
            'role' => 'user',
            'joined_at' => now(),
        ]);
    }
}
