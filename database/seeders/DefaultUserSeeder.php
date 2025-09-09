<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DefaultUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create default admin user if it doesn't exist
        if (!User::where('email', 'admin@gallery.local')->exists()) {
            User::create([
                'name' => 'Admin Gallery',
                'email' => 'admin@gallery.local',
                'email_verified_at' => now(),
                'password' => Hash::make('password123'),
            ]);
        }
    }
}
