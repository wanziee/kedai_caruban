<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin
        User::create([
            'name' => 'Admin Kedai Caruban',
            'email' => 'admin@kedaicabruban.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        // Create Cashier
        User::create([
            'name' => 'Cashier Kedai Caruban',
            'email' => 'cashier@kedaicabruban.com',
            'password' => Hash::make('password123'),
            'role' => 'cashier',
        ]);

        // Create additional Cashier for testing
        User::create([
            'name' => 'Cashier 2',
            'email' => 'cashier2@kedaicabruban.com',
            'password' => Hash::make('password123'),
            'role' => 'cashier',
        ]);
    }
}
