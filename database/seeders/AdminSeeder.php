<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        User::updateOrCreate(
            ['email' => 'admin@emoti.com'],
            [
                'name' => 'Super Admin',
                'contact' => '0700000000',
                'password' => Hash::make('123456'),
                'role' => 'admin',
            ]
        );
    }
}