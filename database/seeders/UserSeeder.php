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
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password123'),
            'role' => 'admin',
        ]);

        User::create([
            'username' => 'user1',
            'email' => 'user@gmail.com',
            'password' => bcrypt('password123'), 
            'role' => 'user',
        ]);
        User::create([
            'username' => 'teknisi',
            'email' => 'teknisi@gmail.com',
            'password' => bcrypt('password123'), 
            'role' => 'teknisi',
        ]);
    }
}
