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
        User::updateOrCreate(
            ['email' => 'adminbaru@minimarket.com'],
            [
                'name' => 'Admin Baru',
                'role' => 'admin',
                'password' => Hash::make('admin123'),
            ]
        );

        User::updateOrCreate(
            ['email' => 'kasir@minimarket.com'],
            [
                'name' => 'Kasir',
                'role' => 'kasir',
                'password' => Hash::make('kasir123'),
            ]
        );
    }
}
