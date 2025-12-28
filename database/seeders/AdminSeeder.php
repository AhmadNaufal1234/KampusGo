<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder; // 🔥 INI YANG KURANG
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin KampusGo',
            'email' => 'admin@kampusgo.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);
    }
}