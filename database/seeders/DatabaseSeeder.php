<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Buat Akun Admin
        User::create([
            'name' => 'Administrator LMS',
            'username' => 'admin',
            'email' => 'admin@skbokutimur.sch.id',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);
    }
}
