<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker;
use App\Models\VehicleModel;

class VehicleModelTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        VehicleModel::truncate();

        $vehicleModel = [
            ['vehicle_make_id' =>  1, 'model' => 'A-Class', 'status' => 1],
            ['vehicle_make_id' =>  2, 'model' => 'A3', 'status' => 1],
            ['vehicle_make_id' =>  2, 'model' => 'A4', 'status' => 1],
            ['vehicle_make_id' =>  2, 'model' => 'A4 allroad', 'status' => 1],
            ['vehicle_make_id' =>  2, 'model' => 'A5', 'status' => 1],
            ['vehicle_make_id' =>  2, 'model' => 'A6', 'status' => 1],
            ['vehicle_make_id' =>  2, 'model' => 'A7', 'status' => 1],
            ['vehicle_make_id' =>  2, 'model' => 'A8', 'status' => 1],
            ['vehicle_make_id' =>  3, 'model' => 'Accord', 'status' => 1],
            ['vehicle_make_id' =>  4, 'model' => 'Air', 'status' => 1],
            ['vehicle_make_id' =>  5, 'model' => 'Altima', 'status' => 1]
        ];
  
        foreach ($vehicleModel as $key => $model) {
            VehicleModel::create($model);
        }
    }
}
