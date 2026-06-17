<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Use env variables or fallback defaults
        $email = env('ADMIN_EMAIL', 'admin@emoti.com');
        $password = env('ADMIN_PASSWORD', 'EmotiStrongPass123');

        if (! User::where('email', $email)->exists()) {
            User::create([
                'name' => 'Admin',
                'email' => $email,
                'password' => Hash::make($password),
                // Add any role/permission if your app uses them
            ]);
        }
    }
}
?>
