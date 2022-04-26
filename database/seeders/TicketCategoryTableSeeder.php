<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TicketCategory;

class TicketCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TicketCategory::truncate();
  
        $ticketCategory = [
            ['category' => 'Club House', 'status' => 1],
            ['category' => 'Dog Park', 'status' => 1],
            ['category' => 'Gated Access', 'status' => 1],
            ['category' => 'Fitness Center', 'status' => 1],
            ['category' => 'Irrigation', 'status' => 1],
            ['category' => 'Landscape', 'status' => 1],
            ['category' => 'Parks/Playground', 'status' => 1],
            ['category' => 'Pool', 'status' => 1],
            ['category' => 'Street Signs', 'status' => 1],
            ['category' => 'Streetlights', 'status' => 1],
            ['category' => 'Violations', 'status' => 1],
            ['category' => 'other', 'status' => 1]
        ];
  
        foreach ($ticketCategory as $key => $categories) {
            TicketCategory::create($categories);
        }
    }
}
