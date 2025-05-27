<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Usuario admin general
        User::create([
            'name' => 'Admin',
            'email' => 'admin@tiendas.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);


    }
}
