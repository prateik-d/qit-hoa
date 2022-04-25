<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\VehicleMake;

class VehicleMakeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        VehicleMake::truncate();
  
        $vehicleMake = [
            ['make' => 'Mercedes-Benz', 'status' => 1],
            ['make' => 'Audi', 'status' => 1],
            ['make' => 'GMC', 'status' => 1],
            ['make' => 'Hyundai', 'status' => 1],
            ['make' => 'Honda', 'status' => 1],
            ['make' => 'Lucid', 'status' => 1],
            ['make' => 'Nissan', 'status' => 1],
            ['make' => 'Volkswagen', 'status' => 1]
        ];
  
        foreach ($vehicleMake as $key => $make) {
            VehicleMake::create($make);
        }
    }
}
