<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Database\Factories\UserFactory;

class DatabaseSeeder extends Seeder
{
    

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(10)->create();

        $this->call([
            KendaraanSeeder::class,
            MobilSeeder::class,
            MotorSeeder::class, 
            PenjualanSeeder::class, 
            StokSeeder::class, 
        ]);
        
    }
}
