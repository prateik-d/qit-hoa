<?php
namespace Database\Seeders\statecities;

use Illuminate\Database\Seeder;
use App\Models\City;
class State12TableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Create Cities for the state of HI - Hawaii.
        //If the table 'cities' exists, insert the data to the table.
        if (City::count() >= 0) {
            $cities = [
                ['state_id' => 12, 'city' => 'Captain Cook'],
                ['state_id' => 12, 'city' => 'Hakalau'],
                ['state_id' => 12, 'city' => 'Hawaii National Park'],
                ['state_id' => 12, 'city' => 'Hawi'],
                ['state_id' => 12, 'city' => 'Hilo'],
                ['state_id' => 12, 'city' => 'Holualoa'],
                ['state_id' => 12, 'city' => 'Honaunau'],
                ['state_id' => 12, 'city' => 'Honokaa'],
                ['state_id' => 12, 'city' => 'Honomu'],
                ['state_id' => 12, 'city' => 'Ocean View'],
                ['state_id' => 12, 'city' => 'Waikoloa'],
                ['state_id' => 12, 'city' => 'Keauhou'],
                ['state_id' => 12, 'city' => 'Kailua Kona'],
                ['state_id' => 12, 'city' => 'Kamuela'],
                ['state_id' => 12, 'city' => 'Keaau'],
                ['state_id' => 12, 'city' => 'Kealakekua'],
                ['state_id' => 12, 'city' => 'Kapaau'],
                ['state_id' => 12, 'city' => 'Kurtistown'],
                ['state_id' => 12, 'city' => 'Laupahoehoe'],
                ['state_id' => 12, 'city' => 'Mountain View'],
                ['state_id' => 12, 'city' => 'Naalehu'],
                ['state_id' => 12, 'city' => 'Ninole'],
                ['state_id' => 12, 'city' => 'Ookala'],
                ['state_id' => 12, 'city' => 'Paauilo'],
                ['state_id' => 12, 'city' => 'Pahala'],
                ['state_id' => 12, 'city' => 'Pahoa'],
                ['state_id' => 12, 'city' => 'Papaaloa'],
                ['state_id' => 12, 'city' => 'Papaikou'],
                ['state_id' => 12, 'city' => 'Pepeekeo'],
                ['state_id' => 12, 'city' => 'Volcano'],
                ['state_id' => 12, 'city' => 'Aiea'],
                ['state_id' => 12, 'city' => 'Ewa Beach'],
                ['state_id' => 12, 'city' => 'Kapolei'],
                ['state_id' => 12, 'city' => 'Haleiwa'],
                ['state_id' => 12, 'city' => 'Hauula'],
                ['state_id' => 12, 'city' => 'Kaaawa'],
                ['state_id' => 12, 'city' => 'Kahuku'],
                ['state_id' => 12, 'city' => 'Kailua'],
                ['state_id' => 12, 'city' => 'Kaneohe'],
                ['state_id' => 12, 'city' => 'Kunia'],
                ['state_id' => 12, 'city' => 'Laie'],
                ['state_id' => 12, 'city' => 'Pearl City'],
                ['state_id' => 12, 'city' => 'Wahiawa'],
                ['state_id' => 12, 'city' => 'Mililani'],
                ['state_id' => 12, 'city' => 'Waialua'],
                ['state_id' => 12, 'city' => 'Waianae'],
                ['state_id' => 12, 'city' => 'Waimanalo'],
                ['state_id' => 12, 'city' => 'Waipahu'],
                ['state_id' => 12, 'city' => 'Honolulu'],
                ['state_id' => 12, 'city' => 'Jbphh'],
                ['state_id' => 12, 'city' => 'Wheeler Army Airfield'],
                ['state_id' => 12, 'city' => 'Schofield Barracks'],
                ['state_id' => 12, 'city' => 'Fort Shafter'],
                ['state_id' => 12, 'city' => 'Tripler Army Medical Center'],
                ['state_id' => 12, 'city' => 'Camp H M Smith'],
                ['state_id' => 12, 'city' => 'Mcbh Kaneohe Bay'],
                ['state_id' => 12, 'city' => 'Wake Island'],
                ['state_id' => 12, 'city' => 'Anahola'],
                ['state_id' => 12, 'city' => 'Eleele'],
                ['state_id' => 12, 'city' => 'Hanalei'],
                ['state_id' => 12, 'city' => 'Hanamaulu'],
                ['state_id' => 12, 'city' => 'Hanapepe'],
                ['state_id' => 12, 'city' => 'Princeville'],
                ['state_id' => 12, 'city' => 'Kalaheo'],
                ['state_id' => 12, 'city' => 'Kapaa'],
                ['state_id' => 12, 'city' => 'Kaumakani'],
                ['state_id' => 12, 'city' => 'Kealia'],
                ['state_id' => 12, 'city' => 'Kekaha'],
                ['state_id' => 12, 'city' => 'Kilauea'],
                ['state_id' => 12, 'city' => 'Koloa'],
                ['state_id' => 12, 'city' => 'Lawai'],
                ['state_id' => 12, 'city' => 'Lihue'],
                ['state_id' => 12, 'city' => 'Makaweli'],
                ['state_id' => 12, 'city' => 'Waimea'],
                ['state_id' => 12, 'city' => 'Haiku'],
                ['state_id' => 12, 'city' => 'Hana'],
                ['state_id' => 12, 'city' => 'Hoolehua'],
                ['state_id' => 12, 'city' => 'Kahului'],
                ['state_id' => 12, 'city' => 'Kalaupapa'],
                ['state_id' => 12, 'city' => 'Kaunakakai'],
                ['state_id' => 12, 'city' => 'Kihei'],
                ['state_id' => 12, 'city' => 'Kualapuu'],
                ['state_id' => 12, 'city' => 'Lahaina'],
                ['state_id' => 12, 'city' => 'Lanai City'],
                ['state_id' => 12, 'city' => 'Makawao'],
                ['state_id' => 12, 'city' => 'Maunaloa'],
                ['state_id' => 12, 'city' => 'Paia'],
                ['state_id' => 12, 'city' => 'Puunene'],
                ['state_id' => 12, 'city' => 'Pukalani'],
                ['state_id' => 12, 'city' => 'Kula'],
                ['state_id' => 12, 'city' => 'Wailuku']
            ];
            foreach ($cities as $key => $city) {
                City::create($city);
            }
        }
    }
}
