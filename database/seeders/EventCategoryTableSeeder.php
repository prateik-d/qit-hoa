<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EventCategory;

class EventCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        EventCategory::truncate();

        $eventCategories = [
            ['category' => 'Sports', 'status' => 1],
            ['category' => 'Musical', 'status' => 1],
        ];
  
        foreach ($eventCategories as $key => $eventCategory) {
            EventCategory::create($eventCategory);
        }
    }
}
