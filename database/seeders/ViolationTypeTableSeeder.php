<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ViolationType;

class ViolationTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ViolationType::truncate();

        $violationTypes = [
            ['type' => 'Landscaping'],
            ['type' => 'parking'],
            ['type' => 'structural'],
            ['type' => 'lawn maintenance'],
            ['type' => 'Trash bins'],
            ['type' => 'other'],
        ];
  
        foreach ($violationTypes as $key => $violationType) {
            ViolationType::create($violationType);
        }
    }
}
