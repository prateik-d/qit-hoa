<?php

namespace Database\Seeders\statecities;

use Illuminate\Database\Seeder;
use App\Models\City;
class State9TableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Create Cities for the state of DC - District of Columbia.
        //If the table 'cities' exists, insert the data to the table.
        if (City::count() >= 0) {
            $cities = [
                ['state_id' => 9, 'city' => 'Washington'],
                ['state_id' => 9, 'city' => 'Naval Anacost Annex'],
                ['state_id' => 9, 'city' => 'Washington Navy Yard']
            ];
            foreach ($cities as $key => $city) {
                City::create($city);
            }
        }
    }
}
