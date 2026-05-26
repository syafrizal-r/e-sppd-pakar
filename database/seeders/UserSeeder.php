<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Admin Pengelola Keuangan',
            'email' => 'admin@pertanian.sumutprov.go.id',
            'password' => Hash::make('password123'), // Password untuk login
        ]);
    }
}