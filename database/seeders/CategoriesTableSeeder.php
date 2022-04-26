<?php


namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->truncate();

        DB::table('categories')->insert(
            [
                [
                    'category' => 'Electrical Vehicle/e-Power',
                    'description' => Str::words(50),
                    'is_hidden' => 1
                ],
                [
                    'category' => 'Compact Car',
                    'description' => Str::words(50),
                    'is_hidden' => 1
                ],
                [
                    'category' => 'Light Car',
                    'description' => Str::words(50),
                    'is_hidden' => 1
                ],
                [
                    'category' => 'Minivan',
                    'description' => Str::words(50),
                    'is_hidden' => 1
                ],
                [
                    'category' => 'Sports & Specialty',
                    'description' => Str::words(50),
                    'is_hidden' => 1
                ],
                [
                    'category' => 'Sedan',
                    'description' => Str::words(50),
                    'is_hidden' => 1
                ],
            ]
        );
    }
}
