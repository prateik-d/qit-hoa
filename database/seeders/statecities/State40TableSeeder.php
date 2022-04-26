<?php

namespace Database\Seeders\statecities;

use Illuminate\Database\Seeder;
use App\Models\City;
class State40TableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Create Cities for the state of RI - Rhode Island.
        //If the table 'cities' exists, insert the data to the table.
        if (City::count() >= 0) {
            $cities = [
                ['state_id' => 40, 'city' => 'Barrington'],
                ['state_id' => 40, 'city' => 'Bristol'],
                ['state_id' => 40, 'city' => 'Prudence Island'],
                ['state_id' => 40, 'city' => 'Warren'],
                ['state_id' => 40, 'city' => 'Coventry'],
                ['state_id' => 40, 'city' => 'West Greenwich'],
                ['state_id' => 40, 'city' => 'East Greenwich'],
                ['state_id' => 40, 'city' => 'Greene'],
                ['state_id' => 40, 'city' => 'Warwick'],
                ['state_id' => 40, 'city' => 'West Warwick'],
                ['state_id' => 40, 'city' => 'Adamsville'],
                ['state_id' => 40, 'city' => 'Jamestown'],
                ['state_id' => 40, 'city' => 'Little Compton'],
                ['state_id' => 40, 'city' => 'Newport'],
                ['state_id' => 40, 'city' => 'Middletown'],
                ['state_id' => 40, 'city' => 'Portsmouth'],
                ['state_id' => 40, 'city' => 'Tiverton'],
                ['state_id' => 40, 'city' => 'Albion'],
                ['state_id' => 40, 'city' => 'Chepachet'],
                ['state_id' => 40, 'city' => 'Clayville'],
                ['state_id' => 40, 'city' => 'Fiskeville'],
                ['state_id' => 40, 'city' => 'Forestdale'],
                ['state_id' => 40, 'city' => 'Foster'],
                ['state_id' => 40, 'city' => 'Glendale'],
                ['state_id' => 40, 'city' => 'Greenville'],
                ['state_id' => 40, 'city' => 'Harmony'],
                ['state_id' => 40, 'city' => 'Harrisville'],
                ['state_id' => 40, 'city' => 'Hope'],
                ['state_id' => 40, 'city' => 'Manville'],
                ['state_id' => 40, 'city' => 'Mapleville'],
                ['state_id' => 40, 'city' => 'North Scituate'],
                ['state_id' => 40, 'city' => 'Oakland'],
                ['state_id' => 40, 'city' => 'Pascoag'],
                ['state_id' => 40, 'city' => 'Pawtucket'],
                ['state_id' => 40, 'city' => 'Central Falls'],
                ['state_id' => 40, 'city' => 'Cumberland'],
                ['state_id' => 40, 'city' => 'Lincoln'],
                ['state_id' => 40, 'city' => 'Slatersville'],
                ['state_id' => 40, 'city' => 'Woonsocket'],
                ['state_id' => 40, 'city' => 'North Smithfield'],
                ['state_id' => 40, 'city' => 'Providence'],
                ['state_id' => 40, 'city' => 'Cranston'],
                ['state_id' => 40, 'city' => 'North Providence'],
                ['state_id' => 40, 'city' => 'East Providence'],
                ['state_id' => 40, 'city' => 'Riverside'],
                ['state_id' => 40, 'city' => 'Rumford'],
                ['state_id' => 40, 'city' => 'Smithfield'],
                ['state_id' => 40, 'city' => 'Johnston'],
                ['state_id' => 40, 'city' => 'Ashaway'],
                ['state_id' => 40, 'city' => 'Block Island'],
                ['state_id' => 40, 'city' => 'Bradford'],
                ['state_id' => 40, 'city' => 'Carolina'],
                ['state_id' => 40, 'city' => 'Charlestown'],
                ['state_id' => 40, 'city' => 'Exeter'],
                ['state_id' => 40, 'city' => 'Hope Valley'],
                ['state_id' => 40, 'city' => 'Hopkinton'],
                ['state_id' => 40, 'city' => 'Kenyon'],
                ['state_id' => 40, 'city' => 'North Kingstown'],
                ['state_id' => 40, 'city' => 'Rockville'],
                ['state_id' => 40, 'city' => 'Saunderstown'],
                ['state_id' => 40, 'city' => 'Shannock'],
                ['state_id' => 40, 'city' => 'Slocum'],
                ['state_id' => 40, 'city' => 'Wakefield'],
                ['state_id' => 40, 'city' => 'Kingston'],
                ['state_id' => 40, 'city' => 'Narragansett'],
                ['state_id' => 40, 'city' => 'Peace Dale'],
                ['state_id' => 40, 'city' => 'Westerly'],
                ['state_id' => 40, 'city' => 'West Kingston'],
                ['state_id' => 40, 'city' => 'Wood River Junction'],
                ['state_id' => 40, 'city' => 'Wyoming', 'state_id' => 40]
            ];
            foreach ($cities as $key => $city) {
                City::create($city);
            }
        }
    }
}
