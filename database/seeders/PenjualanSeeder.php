<?php

namespace Database\Seeders;

use App\Models\Kendaraan;
use App\Models\Penjualan;
use Illuminate\Database\Seeder;

class PenjualanSeeder extends Seeder
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
            Penjualan::create([
                'id_kendaraan' => $value->id,
                'jumlah' => rand(000, 999),
            ]);
        }
    }
}
