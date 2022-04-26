<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\VehicleColor;

class VehicleColorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        VehicleColor::truncate();
  
        $vehicleColor = [
            ['color' => 'White', 'status' => 1],
            ['color' => 'Black', 'status' => 1],
            ['color' => 'Gray', 'status' => 1],
            ['color' => 'Silver', 'status' => 1],
            ['color' => 'Red', 'status' => 1],
            ['color' => 'Blue', 'status' => 1],
            ['color' => 'Brown', 'status' => 1],
            ['color' => 'Green', 'status' => 1],
            ['color' => 'Beige', 'status' => 1],
            ['color' => 'Orange', 'status' => 1],
            ['color' => 'Gold', 'status' => 1],
            ['color' => 'Yellow', 'status' => 1],
            ['color' => 'Purple', 'status' => 1]
        ];
  
        foreach ($vehicleColor as $key => $color) {
            VehicleColor::create($color);
        }
    }
}
