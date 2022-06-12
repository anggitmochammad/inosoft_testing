<?php

namespace Database\Seeders;

use App\Models\Mobil;
use App\Models\Kendaraan;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class MobilSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

       $kendaraanSeeder = new KendaraanSeeder();

       for ($i=0; $i < 10; $i++) {
            Mobil::create([
                'id_kendaraan' => $kendaraanSeeder->getKendaraan[$i]['id'],
                'mesin' => 'Mesin ' . Str::random(1),
                'kapasitas_penumpang' => '8',
                'tipe' => 'tipe ' . Str::random(1),
            ]);
        }
       }
    }
