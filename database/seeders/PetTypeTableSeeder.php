<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PetType;
class PetTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PetType::truncate();

        $petTypes = [
            ['type' => 'Max', 'status' => 1],
            ['type' => 'Charlie', 'status' => 1],
            ['type' => 'Daisy', 'status' => 1],
            ['type' => 'Baraby', 'status' => 1],
            ['type' => 'Rocky', 'status' => 1]
        ];
  
        foreach ($petTypes as $key => $petType) {
            PetType::create($petType);
        }
    }
}
