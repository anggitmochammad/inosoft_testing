<?php

namespace Database\Seeders;

use App\Models\Motor;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class MotorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $kendaraanSeeder = new KendaraanSeeder();

            for ($i = 10; $i < 20; $i++) {
                Motor::create([
                    'id_kendaraan' => $kendaraanSeeder->getKendaraan[$i]['id'],
                    'mesin' => 'Mesin ' . Str::random(1),
                    'tipe_suspensi' => 'Tipe ' . Str::random(1),
                    'tipe_transmisi' => 'Tipe ' . Str::random(2),
                ]);
            }

        }
}
