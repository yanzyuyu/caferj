<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'nama' => 'Administrator',
            'email' => 'admin@caferj.local',
            'password' => bcrypt('admin123'),
            'role' => 'admin',
        ]);

        User::create([
            'nama' => 'Kasir Utama',
            'email' => 'kasir@caferj.local',
            'password' => bcrypt('kasir123'),
            'role' => 'kasir',
        ]);
    }
}
