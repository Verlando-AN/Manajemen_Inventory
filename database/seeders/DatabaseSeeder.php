<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\JenisBarang;
use App\Models\Status;
use App\Models\Barang;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UserSeeder::class);
        $this->call(JenisBarangSeeder::class);
        $this->call(StatusSeeder::class);
        Barang::factory()->count(20)->create();
    }
}
