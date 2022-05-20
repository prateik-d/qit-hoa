<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\VotingCategory;

class VotingCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        VotingCategory::truncate();

        $votingCategories = [
            ['title' => 'Board of Director', 'added_by' => 1],
            ['title' => 'Treasurer', 'added_by' => 1],
            ['title' => 'Chairman', 'added_by' => 1],
            ['title' => 'Management Committee', 'added_by' => 1],
            ['title' => 'Violations Comittee', 'added_by' => 1],
        ];
  
        foreach ($votingCategories as $key => $votingCategory) {
            VotingCategory::create($votingCategory);
        }
    }
}
