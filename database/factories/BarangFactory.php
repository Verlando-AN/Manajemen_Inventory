<?php

namespace Database\Factories;

use App\Models\Barang;
use App\Models\JenisBarang;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class BarangFactory extends Factory
{
    protected $model = Barang::class;

    public function definition()
    {
        return [
            'jenis_barang_id' => JenisBarang::inRandomOrder()->first()->id,
            'user_id' => User::inRandomOrder()->first()->id,
            'nama_barang' => $this->faker->word(),
            'barcode' => $this->faker->unique()->isbn13(),
            'stok' => $this->faker->numberBetween(1, 100),
            'deskripsi' => $this->faker->sentence(),
        ];
    }
}
