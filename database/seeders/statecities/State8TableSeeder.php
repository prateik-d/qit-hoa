<?php

namespace Database\Seeders\statecities;

use Illuminate\Database\Seeder;
use App\Models\City;
class State8TableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Create Cities for the state of DE - Delaware.
        //If the table 'cities' exists, insert the data to the table.
        if (City::count() >= 0) {
            $cities = [
                ['state_id' => 8, 'city' => 'Dover'],
                ['state_id' => 8, 'city' => 'Dover Afb'],
                ['state_id' => 8, 'city' => 'Camden Wyoming'],
                ['state_id' => 8, 'city' => 'Cheswold'],
                ['state_id' => 8, 'city' => 'Clayton'],
                ['state_id' => 8, 'city' => 'Felton'],
                ['state_id' => 8, 'city' => 'Frederica'],
                ['state_id' => 8, 'city' => 'Harrington'],
                ['state_id' => 8, 'city' => 'Hartly'],
                ['state_id' => 8, 'city' => 'Houston'],
                ['state_id' => 8, 'city' => 'Kenton'],
                ['state_id' => 8, 'city' => 'Little Creek'],
                ['state_id' => 8, 'city' => 'Magnolia'],
                ['state_id' => 8, 'city' => 'Marydel'],
                ['state_id' => 8, 'city' => 'Smyrna'],
                ['state_id' => 8, 'city' => 'Viola'],
                ['state_id' => 8, 'city' => 'Woodside'],
                ['state_id' => 8, 'city' => 'Bear'],
                ['state_id' => 8, 'city' => 'Newark'],
                ['state_id' => 8, 'city' => 'Claymont'],
                ['state_id' => 8, 'city' => 'Delaware City'],
                ['state_id' => 8, 'city' => 'Hockessin'],
                ['state_id' => 8, 'city' => 'Kirkwood'],
                ['state_id' => 8, 'city' => 'Middletown'],
                ['state_id' => 8, 'city' => 'Montchanin'],
                ['state_id' => 8, 'city' => 'New Castle'],
                ['state_id' => 8, 'city' => 'Odessa'],
                ['state_id' => 8, 'city' => 'Port Penn'],
                ['state_id' => 8, 'city' => 'Rockland'],
                ['state_id' => 8, 'city' => 'Saint Georges'],
                ['state_id' => 8, 'city' => 'Townsend'],
                ['state_id' => 8, 'city' => 'Winterthur'],
                ['state_id' => 8, 'city' => 'Yorklyn'],
                ['state_id' => 8, 'city' => 'Wilmington'],
                ['state_id' => 8, 'city' => 'Bethany Beach'],
                ['state_id' => 8, 'city' => 'Bethel'],
                ['state_id' => 8, 'city' => 'Bridgeville'],
                ['state_id' => 8, 'city' => 'Dagsboro'],
                ['state_id' => 8, 'city' => 'Delmar'],
                ['state_id' => 8, 'city' => 'Ellendale'],
                ['state_id' => 8, 'city' => 'Fenwick Island'],
                ['state_id' => 8, 'city' => 'Frankford'],
                ['state_id' => 8, 'city' => 'Georgetown'],
                ['state_id' => 8, 'city' => 'Greenwood'],
                ['state_id' => 8, 'city' => 'Harbeson'],
                ['state_id' => 8, 'city' => 'Laurel'],
                ['state_id' => 8, 'city' => 'Lewes'],
                ['state_id' => 8, 'city' => 'Lincoln'],
                ['state_id' => 8, 'city' => 'Milford'],
                ['state_id' => 8, 'city' => 'Millsboro'],
                ['state_id' => 8, 'city' => 'Millville'],
                ['state_id' => 8, 'city' => 'Milton'],
                ['state_id' => 8, 'city' => 'Nassau'],
                ['state_id' => 8, 'city' => 'Ocean View'],
                ['state_id' => 8, 'city' => 'Rehoboth Beach'],
                ['state_id' => 8, 'city' => 'Seaford'],
                ['state_id' => 8, 'city' => 'Selbyville']
            ];
            foreach ($cities as $key => $city) {
                City::create($city);
            }
        }
    }
}
