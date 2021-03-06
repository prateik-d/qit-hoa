<?php

namespace Database\Seeders\statecities;

use Illuminate\Database\Seeder;
use App\Models\City;
class State42TableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Create Cities for the state of SD - South Dakota.
        //If the table 'cities' exists, insert the data to the table.
        if (City::count() >= 0) {
            $cities = [
                ['state_id' => 42, 'city' => 'Plankinton'],
                ['state_id' => 42, 'city' => 'Stickney'],
                ['state_id' => 42, 'city' => 'White Lake'],
                ['state_id' => 42, 'city' => 'Cavour'],
                ['state_id' => 42, 'city' => 'Hitchcock'],
                ['state_id' => 42, 'city' => 'Huron'],
                ['state_id' => 42, 'city' => 'Virgil'],
                ['state_id' => 42, 'city' => 'Wessington'],
                ['state_id' => 42, 'city' => 'Wolsey'],
                ['state_id' => 42, 'city' => 'Yale'],
                ['state_id' => 42, 'city' => 'Martin'],
                ['state_id' => 42, 'city' => 'Tuthill'],
                ['state_id' => 42, 'city' => 'Allen'],
                ['state_id' => 42, 'city' => 'Scotland'],
                ['state_id' => 42, 'city' => 'Springfield'],
                ['state_id' => 42, 'city' => 'Tabor'],
                ['state_id' => 42, 'city' => 'Tyndall'],
                ['state_id' => 42, 'city' => 'Avon'],
                ['state_id' => 42, 'city' => 'Aurora'],
                ['state_id' => 42, 'city' => 'Brookings'],
                ['state_id' => 42, 'city' => 'Elkton'],
                ['state_id' => 42, 'city' => 'Sinai'],
                ['state_id' => 42, 'city' => 'Volga'],
                ['state_id' => 42, 'city' => 'Bruce'],
                ['state_id' => 42, 'city' => 'White'],
                ['state_id' => 42, 'city' => 'Aberdeen'],
                ['state_id' => 42, 'city' => 'Barnard'],
                ['state_id' => 42, 'city' => 'Bath'],
                ['state_id' => 42, 'city' => 'Claremont'],
                ['state_id' => 42, 'city' => 'Columbia'],
                ['state_id' => 42, 'city' => 'Ferney'],
                ['state_id' => 42, 'city' => 'Frederick'],
                ['state_id' => 42, 'city' => 'Groton'],
                ['state_id' => 42, 'city' => 'Hecla'],
                ['state_id' => 42, 'city' => 'Houghton'],
                ['state_id' => 42, 'city' => 'Stratford'],
                ['state_id' => 42, 'city' => 'Warner'],
                ['state_id' => 42, 'city' => 'Westport'],
                ['state_id' => 42, 'city' => 'Chamberlain'],
                ['state_id' => 42, 'city' => 'Kimball'],
                ['state_id' => 42, 'city' => 'Pukwana'],
                ['state_id' => 42, 'city' => 'Fort Thompson'],
                ['state_id' => 42, 'city' => 'Gann Valley'],
                ['state_id' => 42, 'city' => 'Belle Fourche'],
                ['state_id' => 42, 'city' => 'Newell'],
                ['state_id' => 42, 'city' => 'Nisland'],
                ['state_id' => 42, 'city' => 'Vale'],
                ['state_id' => 42, 'city' => 'Herreid'],
                ['state_id' => 42, 'city' => 'Mound City'],
                ['state_id' => 42, 'city' => 'Pollock'],
                ['state_id' => 42, 'city' => 'Dante'],
                ['state_id' => 42, 'city' => 'Geddes'],
                ['state_id' => 42, 'city' => 'Lake Andes'],
                ['state_id' => 42, 'city' => 'Marty'],
                ['state_id' => 42, 'city' => 'Pickstown'],
                ['state_id' => 42, 'city' => 'Platte'],
                ['state_id' => 42, 'city' => 'Wagner'],
                ['state_id' => 42, 'city' => 'Bradley'],
                ['state_id' => 42, 'city' => 'Clark'],
                ['state_id' => 42, 'city' => 'Garden City'],
                ['state_id' => 42, 'city' => 'Raymond'],
                ['state_id' => 42, 'city' => 'Vienna'],
                ['state_id' => 42, 'city' => 'Willow Lake'],
                ['state_id' => 42, 'city' => 'Carpenter'],
                ['state_id' => 42, 'city' => 'Burbank'],
                ['state_id' => 42, 'city' => 'Irene'],
                ['state_id' => 42, 'city' => 'Vermillion'],
                ['state_id' => 42, 'city' => 'Wakonda'],
                ['state_id' => 42, 'city' => 'Watertown'],
                ['state_id' => 42, 'city' => 'Florence'],
                ['state_id' => 42, 'city' => 'Henry'],
                ['state_id' => 42, 'city' => 'Kranzburg'],
                ['state_id' => 42, 'city' => 'South Shore'],
                ['state_id' => 42, 'city' => 'Wallace'],
                ['state_id' => 42, 'city' => 'Bullhead'],
                ['state_id' => 42, 'city' => 'Keldron'],
                ['state_id' => 42, 'city' => 'Little Eagle'],
                ['state_id' => 42, 'city' => 'Mc Intosh'],
                ['state_id' => 42, 'city' => 'Mc Laughlin'],
                ['state_id' => 42, 'city' => 'Morristown'],
                ['state_id' => 42, 'city' => 'Trail City'],
                ['state_id' => 42, 'city' => 'Wakpala'],
                ['state_id' => 42, 'city' => 'Walker'],
                ['state_id' => 42, 'city' => 'Watauga'],
                ['state_id' => 42, 'city' => 'Buffalo Gap'],
                ['state_id' => 42, 'city' => 'Custer'],
                ['state_id' => 42, 'city' => 'Fairburn'],
                ['state_id' => 42, 'city' => 'Hermosa'],
                ['state_id' => 42, 'city' => 'Pringle'],
                ['state_id' => 42, 'city' => 'Mitchell'],
                ['state_id' => 42, 'city' => 'Ethan'],
                ['state_id' => 42, 'city' => 'Mount Vernon'],
                ['state_id' => 42, 'city' => 'Bristol'],
                ['state_id' => 42, 'city' => 'Grenville'],
                ['state_id' => 42, 'city' => 'Roslyn'],
                ['state_id' => 42, 'city' => 'Waubay'],
                ['state_id' => 42, 'city' => 'Webster'],
                ['state_id' => 42, 'city' => 'Andover'],
                ['state_id' => 42, 'city' => 'Pierpont'],
                ['state_id' => 42, 'city' => 'Astoria'],
                ['state_id' => 42, 'city' => 'Brandt'],
                ['state_id' => 42, 'city' => 'Clear Lake'],
                ['state_id' => 42, 'city' => 'Gary'],
                ['state_id' => 42, 'city' => 'Goodwin'],
                ['state_id' => 42, 'city' => 'Toronto'],
                ['state_id' => 42, 'city' => 'Eagle Butte'],
                ['state_id' => 42, 'city' => 'Glencross'],
                ['state_id' => 42, 'city' => 'Isabel'],
                ['state_id' => 42, 'city' => 'Lantry'],
                ['state_id' => 42, 'city' => 'Ridgeview'],
                ['state_id' => 42, 'city' => 'Timber Lake'],
                ['state_id' => 42, 'city' => 'Whitehorse'],
                ['state_id' => 42, 'city' => 'Armour'],
                ['state_id' => 42, 'city' => 'Corsica'],
                ['state_id' => 42, 'city' => 'Delmont'],
                ['state_id' => 42, 'city' => 'Harrison'],
                ['state_id' => 42, 'city' => 'New Holland'],
                ['state_id' => 42, 'city' => 'Bowdle'],
                ['state_id' => 42, 'city' => 'Hosmer'],
                ['state_id' => 42, 'city' => 'Ipswich'],
                ['state_id' => 42, 'city' => 'Roscoe'],
                ['state_id' => 42, 'city' => 'Edgemont'],
                ['state_id' => 42, 'city' => 'Hot Springs'],
                ['state_id' => 42, 'city' => 'Oelrichs'],
                ['state_id' => 42, 'city' => 'Oral'],
                ['state_id' => 42, 'city' => 'Smithwick'],
                ['state_id' => 42, 'city' => 'Cresbard'],
                ['state_id' => 42, 'city' => 'Faulkton'],
                ['state_id' => 42, 'city' => 'Onaka'],
                ['state_id' => 42, 'city' => 'Orient'],
                ['state_id' => 42, 'city' => 'Rockham'],
                ['state_id' => 42, 'city' => 'Seneca'],
                ['state_id' => 42, 'city' => 'Big Stone City'],
                ['state_id' => 42, 'city' => 'Labolt'],
                ['state_id' => 42, 'city' => 'Marvin'],
                ['state_id' => 42, 'city' => 'Milbank'],
                ['state_id' => 42, 'city' => 'Revillo'],
                ['state_id' => 42, 'city' => 'Stockholm'],
                ['state_id' => 42, 'city' => 'Strandburg'],
                ['state_id' => 42, 'city' => 'Twin Brooks'],
                ['state_id' => 42, 'city' => 'Bonesteel'],
                ['state_id' => 42, 'city' => 'Fairfax'],
                ['state_id' => 42, 'city' => 'Burke'],
                ['state_id' => 42, 'city' => 'Dallas'],
                ['state_id' => 42, 'city' => 'Gregory'],
                ['state_id' => 42, 'city' => 'Herrick'],
                ['state_id' => 42, 'city' => 'Saint Charles'],
                ['state_id' => 42, 'city' => 'Midland'],
                ['state_id' => 42, 'city' => 'Milesville'],
                ['state_id' => 42, 'city' => 'Philip'],
                ['state_id' => 42, 'city' => 'Bryant'],
                ['state_id' => 42, 'city' => 'Castlewood'],
                ['state_id' => 42, 'city' => 'Estelline'],
                ['state_id' => 42, 'city' => 'Hayti'],
                ['state_id' => 42, 'city' => 'Hazel'],
                ['state_id' => 42, 'city' => 'Lake Norden'],
                ['state_id' => 42, 'city' => 'Miller'],
                ['state_id' => 42, 'city' => 'Ree Heights'],
                ['state_id' => 42, 'city' => 'Saint Lawrence'],
                ['state_id' => 42, 'city' => 'Alexandria'],
                ['state_id' => 42, 'city' => 'Emery'],
                ['state_id' => 42, 'city' => 'Fulton'],
                ['state_id' => 42, 'city' => 'Ralph'],
                ['state_id' => 42, 'city' => 'Reva'],
                ['state_id' => 42, 'city' => 'Buffalo'],
                ['state_id' => 42, 'city' => 'Camp Crook'],
                ['state_id' => 42, 'city' => 'Ludlow'],
                ['state_id' => 42, 'city' => 'Redig'],
                ['state_id' => 42, 'city' => 'Pierre'],
                ['state_id' => 42, 'city' => 'Blunt'],
                ['state_id' => 42, 'city' => 'Harrold'],
                ['state_id' => 42, 'city' => 'Freeman'],
                ['state_id' => 42, 'city' => 'Menno'],
                ['state_id' => 42, 'city' => 'Olivet'],
                ['state_id' => 42, 'city' => 'Dimock'],
                ['state_id' => 42, 'city' => 'Kaylor'],
                ['state_id' => 42, 'city' => 'Parkston'],
                ['state_id' => 42, 'city' => 'Tripp'],
                ['state_id' => 42, 'city' => 'Highmore'],
                ['state_id' => 42, 'city' => 'Stephan'],
                ['state_id' => 42, 'city' => 'Holabird'],
                ['state_id' => 42, 'city' => 'Belvidere'],
                ['state_id' => 42, 'city' => 'Kadoka'],
                ['state_id' => 42, 'city' => 'Long Valley'],
                ['state_id' => 42, 'city' => 'Wanblee'],
                ['state_id' => 42, 'city' => 'Interior'],
                ['state_id' => 42, 'city' => 'Alpena'],
                ['state_id' => 42, 'city' => 'Lane'],
                ['state_id' => 42, 'city' => 'Wessington Springs'],
                ['state_id' => 42, 'city' => 'Draper'],
                ['state_id' => 42, 'city' => 'Murdo'],
                ['state_id' => 42, 'city' => 'Okaton'],
                ['state_id' => 42, 'city' => 'Oldham'],
                ['state_id' => 42, 'city' => 'Arlington'],
                ['state_id' => 42, 'city' => 'Badger'],
                ['state_id' => 42, 'city' => 'De Smet'],
                ['state_id' => 42, 'city' => 'Erwin'],
                ['state_id' => 42, 'city' => 'Lake Preston'],
                ['state_id' => 42, 'city' => 'Iroquois'],
                ['state_id' => 42, 'city' => 'Chester'],
                ['state_id' => 42, 'city' => 'Madison'],
                ['state_id' => 42, 'city' => 'Nunda'],
                ['state_id' => 42, 'city' => 'Ramona'],
                ['state_id' => 42, 'city' => 'Rutland'],
                ['state_id' => 42, 'city' => 'Wentworth'],
                ['state_id' => 42, 'city' => 'Winfred'],
                ['state_id' => 42, 'city' => 'Deadwood'],
                ['state_id' => 42, 'city' => 'Lead'],
                ['state_id' => 42, 'city' => 'Nemo'],
                ['state_id' => 42, 'city' => 'Saint Onge'],
                ['state_id' => 42, 'city' => 'Spearfish'],
                ['state_id' => 42, 'city' => 'Whitewood'],
                ['state_id' => 42, 'city' => 'Canton'],
                ['state_id' => 42, 'city' => 'Fairview'],
                ['state_id' => 42, 'city' => 'Harrisburg'],
                ['state_id' => 42, 'city' => 'Hudson'],
                ['state_id' => 42, 'city' => 'Lennox'],
                ['state_id' => 42, 'city' => 'Tea'],
                ['state_id' => 42, 'city' => 'Worthing'],
                ['state_id' => 42, 'city' => 'Oacoma'],
                ['state_id' => 42, 'city' => 'Kennebec'],
                ['state_id' => 42, 'city' => 'Lower Brule'],
                ['state_id' => 42, 'city' => 'Presho'],
                ['state_id' => 42, 'city' => 'Reliance'],
                ['state_id' => 42, 'city' => 'Vivian'],
                ['state_id' => 42, 'city' => 'Canistota'],
                ['state_id' => 42, 'city' => 'Montrose'],
                ['state_id' => 42, 'city' => 'Salem'],
                ['state_id' => 42, 'city' => 'Bridgewater'],
                ['state_id' => 42, 'city' => 'Spencer'],
                ['state_id' => 42, 'city' => 'Eureka'],
                ['state_id' => 42, 'city' => 'Leola'],
                ['state_id' => 42, 'city' => 'Long Lake'],
                ['state_id' => 42, 'city' => 'Eden'],
                ['state_id' => 42, 'city' => 'Lake City'],
                ['state_id' => 42, 'city' => 'Veblen'],
                ['state_id' => 42, 'city' => 'Amherst'],
                ['state_id' => 42, 'city' => 'Britton'],
                ['state_id' => 42, 'city' => 'Langford'],
                ['state_id' => 42, 'city' => 'Faith'],
                ['state_id' => 42, 'city' => 'Ellsworth Afb'],
                ['state_id' => 42, 'city' => 'Black Hawk'],
                ['state_id' => 42, 'city' => 'Enning'],
                ['state_id' => 42, 'city' => 'Fort Meade'],
                ['state_id' => 42, 'city' => 'Howes'],
                ['state_id' => 42, 'city' => 'Mud Butte'],
                ['state_id' => 42, 'city' => 'Piedmont'],
                ['state_id' => 42, 'city' => 'Sturgis'],
                ['state_id' => 42, 'city' => 'Union Center'],
                ['state_id' => 42, 'city' => 'White Owl'],
                ['state_id' => 42, 'city' => 'Norris'],
                ['state_id' => 42, 'city' => 'White River'],
                ['state_id' => 42, 'city' => 'Wood'],
                ['state_id' => 42, 'city' => 'Canova'],
                ['state_id' => 42, 'city' => 'Carthage'],
                ['state_id' => 42, 'city' => 'Fedora'],
                ['state_id' => 42, 'city' => 'Howard'],
                ['state_id' => 42, 'city' => 'Baltic'],
                ['state_id' => 42, 'city' => 'Brandon'],
                ['state_id' => 42, 'city' => 'Colton'],
                ['state_id' => 42, 'city' => 'Crooks'],
                ['state_id' => 42, 'city' => 'Dell Rapids'],
                ['state_id' => 42, 'city' => 'Garretson'],
                ['state_id' => 42, 'city' => 'Hartford'],
                ['state_id' => 42, 'city' => 'Humboldt'],
                ['state_id' => 42, 'city' => 'Lyons'],
                ['state_id' => 42, 'city' => 'Renner'],
                ['state_id' => 42, 'city' => 'Valley Springs'],
                ['state_id' => 42, 'city' => 'Sioux Falls'],
                ['state_id' => 42, 'city' => 'Colman'],
                ['state_id' => 42, 'city' => 'Egan'],
                ['state_id' => 42, 'city' => 'Flandreau'],
                ['state_id' => 42, 'city' => 'Trent'],
                ['state_id' => 42, 'city' => 'Rapid City'],
                ['state_id' => 42, 'city' => 'Box Elder'],
                ['state_id' => 42, 'city' => 'Caputa'],
                ['state_id' => 42, 'city' => 'Hill City'],
                ['state_id' => 42, 'city' => 'Keystone'],
                ['state_id' => 42, 'city' => 'New Underwood'],
                ['state_id' => 42, 'city' => 'Owanka'],
                ['state_id' => 42, 'city' => 'Quinn'],
                ['state_id' => 42, 'city' => 'Scenic'],
                ['state_id' => 42, 'city' => 'Wall'],
                ['state_id' => 42, 'city' => 'Wasta'],
                ['state_id' => 42, 'city' => 'Bison'],
                ['state_id' => 42, 'city' => 'Lemmon'],
                ['state_id' => 42, 'city' => 'Lodgepole'],
                ['state_id' => 42, 'city' => 'Meadow'],
                ['state_id' => 42, 'city' => 'Prairie City'],
                ['state_id' => 42, 'city' => 'Gettysburg'],
                ['state_id' => 42, 'city' => 'Hoven'],
                ['state_id' => 42, 'city' => 'Lebanon'],
                ['state_id' => 42, 'city' => 'Tolstoy'],
                ['state_id' => 42, 'city' => 'Claire City'],
                ['state_id' => 42, 'city' => 'Corona'],
                ['state_id' => 42, 'city' => 'New Effington'],
                ['state_id' => 42, 'city' => 'Ortley'],
                ['state_id' => 42, 'city' => 'Peever'],
                ['state_id' => 42, 'city' => 'Rosholt'],
                ['state_id' => 42, 'city' => 'Sisseton'],
                ['state_id' => 42, 'city' => 'Summit'],
                ['state_id' => 42, 'city' => 'Wilmot'],
                ['state_id' => 42, 'city' => 'Artesian'],
                ['state_id' => 42, 'city' => 'Letcher'],
                ['state_id' => 42, 'city' => 'Woonsocket'],
                ['state_id' => 42, 'city' => 'Batesland'],
                ['state_id' => 42, 'city' => 'Kyle'],
                ['state_id' => 42, 'city' => 'Manderson'],
                ['state_id' => 42, 'city' => 'Oglala'],
                ['state_id' => 42, 'city' => 'Pine Ridge'],
                ['state_id' => 42, 'city' => 'Porcupine'],
                ['state_id' => 42, 'city' => 'Wounded Knee'],
                ['state_id' => 42, 'city' => 'Ashton'],
                ['state_id' => 42, 'city' => 'Brentford'],
                ['state_id' => 42, 'city' => 'Conde'],
                ['state_id' => 42, 'city' => 'Doland'],
                ['state_id' => 42, 'city' => 'Frankfort'],
                ['state_id' => 42, 'city' => 'Mansfield'],
                ['state_id' => 42, 'city' => 'Mellette'],
                ['state_id' => 42, 'city' => 'Northville'],
                ['state_id' => 42, 'city' => 'Redfield'],
                ['state_id' => 42, 'city' => 'Tulare'],
                ['state_id' => 42, 'city' => 'Turton'],
                ['state_id' => 42, 'city' => 'Fort Pierre'],
                ['state_id' => 42, 'city' => 'Hayes'],
                ['state_id' => 42, 'city' => 'Agar'],
                ['state_id' => 42, 'city' => 'Onida'],
                ['state_id' => 42, 'city' => 'Mission'],
                ['state_id' => 42, 'city' => 'Okreek'],
                ['state_id' => 42, 'city' => 'Parmelee'],
                ['state_id' => 42, 'city' => 'Rosebud'],
                ['state_id' => 42, 'city' => 'Saint Francis'],
                ['state_id' => 42, 'city' => 'Colome'],
                ['state_id' => 42, 'city' => 'Hamill'],
                ['state_id' => 42, 'city' => 'Ideal'],
                ['state_id' => 42, 'city' => 'Winner'],
                ['state_id' => 42, 'city' => 'Witten'],
                ['state_id' => 42, 'city' => 'Centerville'],
                ['state_id' => 42, 'city' => 'Chancellor'],
                ['state_id' => 42, 'city' => 'Davis'],
                ['state_id' => 42, 'city' => 'Hurley'],
                ['state_id' => 42, 'city' => 'Marion'],
                ['state_id' => 42, 'city' => 'Monroe'],
                ['state_id' => 42, 'city' => 'Parker'],
                ['state_id' => 42, 'city' => 'Viborg'],
                ['state_id' => 42, 'city' => 'Alcester'],
                ['state_id' => 42, 'city' => 'Beresford'],
                ['state_id' => 42, 'city' => 'Elk Point'],
                ['state_id' => 42, 'city' => 'Jefferson'],
                ['state_id' => 42, 'city' => 'North Sioux City'],
                ['state_id' => 42, 'city' => 'Akaska'],
                ['state_id' => 42, 'city' => 'Java'],
                ['state_id' => 42, 'city' => 'Selby'],
                ['state_id' => 42, 'city' => 'Mobridge'],
                ['state_id' => 42, 'city' => 'Glenham'],
                ['state_id' => 42, 'city' => 'Gayville'],
                ['state_id' => 42, 'city' => 'Lesterville'],
                ['state_id' => 42, 'city' => 'Mission Hill'],
                ['state_id' => 42, 'city' => 'Utica'],
                ['state_id' => 42, 'city' => 'Volin'],
                ['state_id' => 42, 'city' => 'Yankton'],
                ['state_id' => 42, 'city' => 'Cherry Creek'],
                ['state_id' => 42, 'city' => 'Dupree', 'state_id' => 42]
            ];
            foreach ($cities as $key => $city) {
                City::create($city);
            }
        }
    }
}
