<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DocumentCategory;

class DocumentCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DocumentCategory::truncate();

        $documentCategories = [
            ['title' => 'legal'],
            ['title' => 'granted'],
        ];
  
        foreach ($documentCategories as $key => $documentCategory) {
            DocumentCategory::create($documentCategory);
        }
    }
}
