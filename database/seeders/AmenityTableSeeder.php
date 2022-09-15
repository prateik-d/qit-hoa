<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Amenity;

class AmenityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Amenity::truncate();

        $amenities = [
            ['title' => 'Swimming Pool', 'description' => 'A spillway is one of the most relaxing pool water elements homeowners choose to add during their pool construction, Swim-Up Pool Bar, LED Pool Lighting, Repurposed Fountains, Outdoor Fire Pit, ixtures Made of Natural Rock, Jump Rock, Waterfalls.', 'booking_price' => '$70', 'days_available' => 'Monday', 'timeslots' => '6 AM to 7 AM'],
            ['title' => 'Gym', 'description' => 'Fitness First specialises in safe cardiovascular exercise programmes to enable you to improve your lifestyle, health and general wellbeing, Studio, Personal Training Counter, Cardio Theater, Cycling Studio, Members Lounge, Luxurious Changing Room, Security', 'booking_price' => '$200', 'days_available' => 'Tuesday', 'timeslots' => '7 AM to 8 AM'],
            ['title' => 'Library', 'description' => 'Borrowing and Ordering Material, Ask A Librarian, Student IT and Learning Support, Photocopying/Printing/Scanning, Wireless Access.', 'booking_price' => '$300', 'days_available' => 'Wednesday', 'timeslots' => '6 AM to 7 AM'],
            ['title' => 'Hall', 'description' => 'Amenities are a service or item offered to guests or placed in the guest room, bathroom and kitchen etc', 'booking_price' => '$230', 'days_available' => 'Thursday', 'timeslots' => '6 AM to 7 AM'],
            ['title' => 'Park', 'description' => 'Parks may consist of grassy areas, rocks, soil and trees, but may also contain buildings and other artifacts such as monuments, fountains or playground structures.', 'booking_price' => '$700', 'days_available' => 'Friday','timeslots' => '6 AM to 7 AM'],
            ['title' => 'School', 'description' => 'The School Library. The spacious school library is stocked with periodicals, newspapers and an impressive index of titles, covering both fiction and non-fiction, Multi-purpose Hall, Art Room, Music Room, Cafeteria, Books and Uniforms Store, Medicare.', 'booking_price' => '$1000', 'days_available'=> 'Saturday', 'timeslots' => '6 AM to 7 AM'],
            ['title' => 'Park', 'description' => 'Parks may consist of grassy areas, rocks, soil and trees, but may also contain buildings and other artifacts such as monuments, fountains or playground structures.', 'booking_price' => '$700', 'days_available' => 'Friday', 'timeslots' => '6 AM to 7 AM'],
            ['title' => 'Shopping Center', 'description' => 'Shopping centres may contain restaurants, banks, theatres, professional offices, service stations, and other establishments.', 'booking_price' => '$400', 'days_available' => 'Sunday', 'timeslots' => '6 AM to 7 AM'],
        ];
  
        foreach ($amenities as $key => $amenity) {
            Amenity::create($amenity);
        }
    }
}
