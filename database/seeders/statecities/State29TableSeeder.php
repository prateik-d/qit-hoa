<?php

namespace Database\Seeders\statecities;

use Illuminate\Database\Seeder;
use App\Models\City;
class State29TableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Create Cities for the state of NV - Nevada.
        //If the table 'cities' exists, insert the data to the table.
        if (City::count() >= 0) {
            $cities = [
                ['state_id' => 29, 'city' => 'Fallon'],
                ['state_id' => 29, 'city' => 'The Lakes'],
                ['state_id' => 29, 'city' => 'Henderson'],
                ['state_id' => 29, 'city' => 'Blue Diamond'],
                ['state_id' => 29, 'city' => 'Boulder City'],
                ['state_id' => 29, 'city' => 'Bunkerville'],
                ['state_id' => 29, 'city' => 'Indian Springs'],
                ['state_id' => 29, 'city' => 'Jean'],
                ['state_id' => 29, 'city' => 'Logandale'],
                ['state_id' => 29, 'city' => 'Mesquite'],
                ['state_id' => 29, 'city' => 'Moapa'],
                ['state_id' => 29, 'city' => 'Laughlin'],
                ['state_id' => 29, 'city' => 'North Las Vegas'],
                ['state_id' => 29, 'city' => 'Coyote Springs'],
                ['state_id' => 29, 'city' => 'Cal Nev Ari'],
                ['state_id' => 29, 'city' => 'Overton'],
                ['state_id' => 29, 'city' => 'Searchlight'],
                ['state_id' => 29, 'city' => 'Sloan'],
                ['state_id' => 29, 'city' => 'Las Vegas'],
                ['state_id' => 29, 'city' => 'Nellis Afb'],
                ['state_id' => 29, 'city' => 'Gardnerville'],
                ['state_id' => 29, 'city' => 'Genoa'],
                ['state_id' => 29, 'city' => 'Glenbrook'],
                ['state_id' => 29, 'city' => 'Minden'],
                ['state_id' => 29, 'city' => 'Zephyr Cove'],
                ['state_id' => 29, 'city' => 'Stateline'],
                ['state_id' => 29, 'city' => 'Carson City'],
                ['state_id' => 29, 'city' => 'Elko'],
                ['state_id' => 29, 'city' => 'Spring Creek'],
                ['state_id' => 29, 'city' => 'Carlin'],
                ['state_id' => 29, 'city' => 'Deeth'],
                ['state_id' => 29, 'city' => 'Jackpot'],
                ['state_id' => 29, 'city' => 'Jarbidge'],
                ['state_id' => 29, 'city' => 'Lamoille'],
                ['state_id' => 29, 'city' => 'Montello'],
                ['state_id' => 29, 'city' => 'Mountain City'],
                ['state_id' => 29, 'city' => 'Owyhee'],
                ['state_id' => 29, 'city' => 'Ruby Valley'],
                ['state_id' => 29, 'city' => 'Tuscarora'],
                ['state_id' => 29, 'city' => 'Wells'],
                ['state_id' => 29, 'city' => 'West Wendover'],
                ['state_id' => 29, 'city' => 'Dyer'],
                ['state_id' => 29, 'city' => 'Goldfield'],
                ['state_id' => 29, 'city' => 'Silverpeak'],
                ['state_id' => 29, 'city' => 'Eureka'],
                ['state_id' => 29, 'city' => 'Crescent Valley'],
                ['state_id' => 29, 'city' => 'Denio'],
                ['state_id' => 29, 'city' => 'Golconda'],
                ['state_id' => 29, 'city' => 'Mc Dermitt'],
                ['state_id' => 29, 'city' => 'Orovada'],
                ['state_id' => 29, 'city' => 'Paradise Valley'],
                ['state_id' => 29, 'city' => 'Valmy'],
                ['state_id' => 29, 'city' => 'Winnemucca'],
                ['state_id' => 29, 'city' => 'Austin'],
                ['state_id' => 29, 'city' => 'Battle Mountain'],
                ['state_id' => 29, 'city' => 'Alamo'],
                ['state_id' => 29, 'city' => 'Caliente'],
                ['state_id' => 29, 'city' => 'Hiko'],
                ['state_id' => 29, 'city' => 'Panaca'],
                ['state_id' => 29, 'city' => 'Pioche'],
                ['state_id' => 29, 'city' => 'Dayton'],
                ['state_id' => 29, 'city' => 'Fernley'],
                ['state_id' => 29, 'city' => 'Silver City'],
                ['state_id' => 29, 'city' => 'Silver Springs'],
                ['state_id' => 29, 'city' => 'Smith'],
                ['state_id' => 29, 'city' => 'Wellington'],
                ['state_id' => 29, 'city' => 'Yerington'],
                ['state_id' => 29, 'city' => 'Hawthorne'],
                ['state_id' => 29, 'city' => 'Luning'],
                ['state_id' => 29, 'city' => 'Mina'],
                ['state_id' => 29, 'city' => 'Schurz'],
                ['state_id' => 29, 'city' => 'Beatty'],
                ['state_id' => 29, 'city' => 'Amargosa Valley'],
                ['state_id' => 29, 'city' => 'Manhattan'],
                ['state_id' => 29, 'city' => 'Mercury'],
                ['state_id' => 29, 'city' => 'Pahrump'],
                ['state_id' => 29, 'city' => 'Round Mountain'],
                ['state_id' => 29, 'city' => 'Tonopah'],
                ['state_id' => 29, 'city' => 'Gabbs'],
                ['state_id' => 29, 'city' => 'Imlay'],
                ['state_id' => 29, 'city' => 'Lovelock'],
                ['state_id' => 29, 'city' => 'Virginia City'],
                ['state_id' => 29, 'city' => 'Crystal Bay'],
                ['state_id' => 29, 'city' => 'Empire'],
                ['state_id' => 29, 'city' => 'Gerlach'],
                ['state_id' => 29, 'city' => 'Nixon'],
                ['state_id' => 29, 'city' => 'Sparks'],
                ['state_id' => 29, 'city' => 'Sun Valley'],
                ['state_id' => 29, 'city' => 'Verdi'],
                ['state_id' => 29, 'city' => 'Wadsworth'],
                ['state_id' => 29, 'city' => 'Incline Village'],
                ['state_id' => 29, 'city' => 'Reno'],
                ['state_id' => 29, 'city' => 'Washoe Valley'],
                ['state_id' => 29, 'city' => 'Ely'],
                ['state_id' => 29, 'city' => 'Baker'],
                ['state_id' => 29, 'city' => 'Duckwater'],
                ['state_id' => 29, 'city' => 'Lund'],
                ['state_id' => 29, 'city' => 'Mc Gill'],
                ['state_id' => 29, 'city' => 'Ruth']
            ];
            foreach ($cities as $key => $city) {
                City::create($city);
            }
        }
    }
}
