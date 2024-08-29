<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->count(10)->create();

        User::create([
            'username' => 'admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password123'),
            'role' => 'admin',
        ]);

        User::create([
            'username' => 'user1',
            'email' => 'user1@example.com',
            'password' => bcrypt('password123'), 
            'role' => 'user',
        ]);
    }
}
