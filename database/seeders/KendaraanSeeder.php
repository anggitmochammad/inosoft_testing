<?php

namespace Database\Seeders;

use App\Models\Mobil;
use App\Models\Kendaraan;
use App\Models\Motor;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class KendaraanSeeder extends Seeder
{
    public $getKendaraan;

    public function __construct($limit = 1)
    {
        $kendaraan = Kendaraan::all();
        $this->getKendaraan = $kendaraan;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $warna = ['merah','putih','ungu','kuning','pink','hijau','biru'];

        for ($i=0; $i < 20; $i++) {
            Kendaraan::create([
                'tahun' => 20 . rand(00, 22),
                'warna' => Arr::random($warna),
                'harga' => 10 . rand(0000, 9999),
            ]);
        }        
    }
}
