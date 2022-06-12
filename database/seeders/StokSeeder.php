<?php

namespace Database\Seeders;

use App\Models\Stok;
use App\Models\Kendaraan;
use Illuminate\Database\Seeder;

class StokSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $kendaraanSeeder = new KendaraanSeeder();

        foreach ($kendaraanSeeder->getKendaraan as $key => $value) {
            Stok::create([
                'id_kendaraan' => $value->id,
                'jumlah' => rand(000, 999),
            ]);
        }
    }
}
