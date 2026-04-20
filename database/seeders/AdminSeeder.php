<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Check if admin already exists to prevent duplicates
        if (!User::where('email', 'admin@seis.com')->exists()) {
            User::create([
                'name' => 'System Administrator',
                'email' => 'admin@seis.com',
                'password' => Hash::make('adminclide'), // Securely hashed
                'role' => 'admin',
            ]);
            
            $this->command->info('Admin account created successfully!');
        }
    }
}