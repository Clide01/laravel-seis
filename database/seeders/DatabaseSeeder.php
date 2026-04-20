<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
public function run() {
    \App\Models\User::create([
        'name' => 'System Admin',
        'email' => 'admin@seis.com',
        'password' => bcrypt('password'),
        'role' => 'admin',
    ]);
}
}
