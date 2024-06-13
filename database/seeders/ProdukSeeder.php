<?php

namespace Database\Seeders;

use App\Models\Produk;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create('id_ID');
        for ($i = 0; $i < 10; $i++) {
            Produk::create([
                'judul' => $faker->sentence,
                'deskripsi' => $faker->paragraph,
                'durasi' => $faker->numberBetween(1,24),
                'kategori' => $faker->word
            ]);
        };
    }
}
