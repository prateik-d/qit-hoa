<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ClassifiedCategory;

class ClassifiedCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ClassifiedCategory::truncate();

        $classifiedCategories = [
            ['category' => 'Two-Wheeler', 'status' => 1, 'added_by' => 1],
            ['category' => 'Electronics', 'status' => 1, 'added_by' => 1],
            ['category' => 'Four-Wheeler', 'status' => 1, 'added_by' => 1],
            ['category' => 'Computer', 'status' => 1, 'added_by' => 1],
        ];
  
        foreach ($classifiedCategories as $key => $classifiedCategory) {
            ClassifiedCategory::create($classifiedCategory);
        }
    }
}
