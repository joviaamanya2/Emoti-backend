<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@emoti.com',
            'phone' => '0700000000',
            'bio' => 'System Administrator',
            'password' => Hash::make('123456'),
            'role' => 'admin',
        ]);
    }
}