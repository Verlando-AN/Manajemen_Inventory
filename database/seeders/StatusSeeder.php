<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Status;

class StatusSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        Status::create([
            'status' => 'proses',
        ]);
        Status::create([
            'status' => 'diterima',
        ]);
        Status::create([
            'status' => 'diperbaiki',
        ]);
        Status::create([
            'status' => 'selesai',
        ]);
      

    }
}
