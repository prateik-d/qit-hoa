<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Breed;
class BreedTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Breed::truncate();

        $breeds = [
            ['pet_type_id' => '1', 'breed' => 'German Shepherd', 'status' => 1],
            ['pet_type_id' => '2', 'breed' => 'Golden Retriever', 'status' => 1],
            ['pet_type_id' => '3', 'breed' => 'Beagle', 'status' => 1],
            ['pet_type_id' => '4', 'breed' => 'Bulldog', 'status' => 1],
            ['pet_type_id' => '5', 'breed' => 'Boxer', 'status' => 1]
        ];
  
        foreach ($breeds as $key => $breed) {
            Breed::create($breed);
        }
    }
}
