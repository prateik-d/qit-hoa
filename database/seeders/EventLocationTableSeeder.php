<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EventLocation;

class EventLocationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        EventLocation::truncate();

        $eventLocations = [
            ['location' => 'Club House', 'status' => 1],
            ['location' => 'Hall', 'status' => 1],
        ];
  
        foreach ($eventLocations as $key => $eventLocation) {
            EventLocation::create($eventLocation);
        }
    }
}
