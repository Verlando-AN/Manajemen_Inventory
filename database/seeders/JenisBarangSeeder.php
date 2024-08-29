<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JenisBarang;

class JenisBarangSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        JenisBarang::create([
            'nama_jenis' => 'Laptop',
        ]);
        JenisBarang::create([
            'nama_jenis' => 'Monitor',
        ]);
        JenisBarang::create([
            'nama_jenis' => 'Meja',
        ]);
        JenisBarang::create([
            'nama_jenis' => 'Kursi',
        ]);
        JenisBarang::create([
            'nama_jenis' => 'Komputer',
        ]);

    }
}
