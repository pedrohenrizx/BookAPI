<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin Sci-Fi',
            'email' => 'admin@scifi.com',
            'password' => Hash::make('admin123'), // senha padrão para testes
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Leitor Comum',
            'email' => 'user@scifi.com',
            'password' => Hash::make('user123'), // senha padrão para testes
            'role' => 'user',
        ]);
    }
}