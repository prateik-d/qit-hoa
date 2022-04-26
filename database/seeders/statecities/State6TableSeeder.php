<?php
namespace Database\Seeders\statecities;

use Illuminate\Database\Seeder;
use App\Models\City;
class State6TableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Create Cities for the state of CO - Colorado.
        //If the table 'cities' exists, insert the data to the table.
        if (City::count() >= 0) {
            $cities = [
                ['state_id' => 6, 'city' => 'Aurora'],
                ['state_id' => 6, 'city' => 'Commerce City'],
                ['state_id' => 6, 'city' => 'Dupont'],
                ['state_id' => 6, 'city' => 'Westminster'],
                ['state_id' => 6, 'city' => 'Bennett'],
                ['state_id' => 6, 'city' => 'Strasburg'],
                ['state_id' => 6, 'city' => 'Watkins'],
                ['state_id' => 6, 'city' => 'Denver'],
                ['state_id' => 6, 'city' => 'Thornton'],
                ['state_id' => 6, 'city' => 'Brighton'],
                ['state_id' => 6, 'city' => 'Eastlake'],
                ['state_id' => 6, 'city' => 'Henderson'],
                ['state_id' => 6, 'city' => 'Alamosa'],
                ['state_id' => 6, 'city' => 'Hooper'],
                ['state_id' => 6, 'city' => 'Mosca'],
                ['state_id' => 6, 'city' => 'Byers'],
                ['state_id' => 6, 'city' => 'Deer Trail'],
                ['state_id' => 6, 'city' => 'Englewood'],
                ['state_id' => 6, 'city' => 'Littleton'],
                ['state_id' => 6, 'city' => 'Arboles'],
                ['state_id' => 6, 'city' => 'Chromo'],
                ['state_id' => 6, 'city' => 'Pagosa Springs'],
                ['state_id' => 6, 'city' => 'Campo'],
                ['state_id' => 6, 'city' => 'Pritchett'],
                ['state_id' => 6, 'city' => 'Springfield'],
                ['state_id' => 6, 'city' => 'Two Buttes'],
                ['state_id' => 6, 'city' => 'Vilas'],
                ['state_id' => 6, 'city' => 'Walsh'],
                ['state_id' => 6, 'city' => 'Fort Lyon'],
                ['state_id' => 6, 'city' => 'Hasty'],
                ['state_id' => 6, 'city' => 'Las Animas'],
                ['state_id' => 6, 'city' => 'Mc Clave'],
                ['state_id' => 6, 'city' => 'Broomfield'],
                ['state_id' => 6, 'city' => 'Eldorado Springs'],
                ['state_id' => 6, 'city' => 'Lafayette'],
                ['state_id' => 6, 'city' => 'Louisville'],
                ['state_id' => 6, 'city' => 'Boulder'],
                ['state_id' => 6, 'city' => 'Jamestown'],
                ['state_id' => 6, 'city' => 'Nederland'],
                ['state_id' => 6, 'city' => 'Pinecliffe'],
                ['state_id' => 6, 'city' => 'Ward'],
                ['state_id' => 6, 'city' => 'Longmont'],
                ['state_id' => 6, 'city' => 'Allenspark'],
                ['state_id' => 6, 'city' => 'Hygiene'],
                ['state_id' => 6, 'city' => 'Lyons'],
                ['state_id' => 6, 'city' => 'Niwot'],
                ['state_id' => 6, 'city' => 'Salida'],
                ['state_id' => 6, 'city' => 'Buena Vista'],
                ['state_id' => 6, 'city' => 'Monarch'],
                ['state_id' => 6, 'city' => 'Granite'],
                ['state_id' => 6, 'city' => 'Nathrop'],
                ['state_id' => 6, 'city' => 'Poncha Springs'],
                ['state_id' => 6, 'city' => 'Arapahoe'],
                ['state_id' => 6, 'city' => 'Cheyenne Wells'],
                ['state_id' => 6, 'city' => 'Kit Carson'],
                ['state_id' => 6, 'city' => 'Wild Horse'],
                ['state_id' => 6, 'city' => 'Dumont'],
                ['state_id' => 6, 'city' => 'Empire'],
                ['state_id' => 6, 'city' => 'Georgetown'],
                ['state_id' => 6, 'city' => 'Idaho Springs'],
                ['state_id' => 6, 'city' => 'Silver Plume'],
                ['state_id' => 6, 'city' => 'Antonito'],
                ['state_id' => 6, 'city' => 'Capulin'],
                ['state_id' => 6, 'city' => 'Conejos'],
                ['state_id' => 6, 'city' => 'La Jara'],
                ['state_id' => 6, 'city' => 'Manassa'],
                ['state_id' => 6, 'city' => 'Romeo'],
                ['state_id' => 6, 'city' => 'Sanford'],
                ['state_id' => 6, 'city' => 'Blanca'],
                ['state_id' => 6, 'city' => 'Chama'],
                ['state_id' => 6, 'city' => 'Fort Garland'],
                ['state_id' => 6, 'city' => 'Jaroso'],
                ['state_id' => 6, 'city' => 'San Luis'],
                ['state_id' => 6, 'city' => 'Crowley'],
                ['state_id' => 6, 'city' => 'Olney Springs'],
                ['state_id' => 6, 'city' => 'Ordway'],
                ['state_id' => 6, 'city' => 'Sugar City'],
                ['state_id' => 6, 'city' => 'Westcliffe'],
                ['state_id' => 6, 'city' => 'Wetmore'],
                ['state_id' => 6, 'city' => 'Austin'],
                ['state_id' => 6, 'city' => 'Cedaredge'],
                ['state_id' => 6, 'city' => 'Cory'],
                ['state_id' => 6, 'city' => 'Crawford'],
                ['state_id' => 6, 'city' => 'Delta'],
                ['state_id' => 6, 'city' => 'Eckert'],
                ['state_id' => 6, 'city' => 'Hotchkiss'],
                ['state_id' => 6, 'city' => 'Lazear'],
                ['state_id' => 6, 'city' => 'Paonia'],
                ['state_id' => 6, 'city' => 'Cahone'],
                ['state_id' => 6, 'city' => 'Dove Creek'],
                ['state_id' => 6, 'city' => 'Rico'],
                ['state_id' => 6, 'city' => 'Castle Rock'],
                ['state_id' => 6, 'city' => 'Franktown'],
                ['state_id' => 6, 'city' => 'Larkspur'],
                ['state_id' => 6, 'city' => 'Lone Tree'],
                ['state_id' => 6, 'city' => 'Louviers'],
                ['state_id' => 6, 'city' => 'Parker'],
                ['state_id' => 6, 'city' => 'Sedalia'],
                ['state_id' => 6, 'city' => 'Bond'],
                ['state_id' => 6, 'city' => 'Burns'],
                ['state_id' => 6, 'city' => 'Mc Coy'],
                ['state_id' => 6, 'city' => 'Avon'],
                ['state_id' => 6, 'city' => 'Basalt'],
                ['state_id' => 6, 'city' => 'Eagle'],
                ['state_id' => 6, 'city' => 'Edwards'],
                ['state_id' => 6, 'city' => 'Gypsum'],
                ['state_id' => 6, 'city' => 'Minturn'],
                ['state_id' => 6, 'city' => 'Red Cliff'],
                ['state_id' => 6, 'city' => 'Wolcott'],
                ['state_id' => 6, 'city' => 'Vail'],
                ['state_id' => 6, 'city' => 'Agate'],
                ['state_id' => 6, 'city' => 'Elbert'],
                ['state_id' => 6, 'city' => 'Elizabeth'],
                ['state_id' => 6, 'city' => 'Kiowa'],
                ['state_id' => 6, 'city' => 'Matheson'],
                ['state_id' => 6, 'city' => 'Simla'],
                ['state_id' => 6, 'city' => 'Monument'],
                ['state_id' => 6, 'city' => 'Palmer Lake'],
                ['state_id' => 6, 'city' => 'Calhan'],
                ['state_id' => 6, 'city' => 'Cascade'],
                ['state_id' => 6, 'city' => 'Fountain'],
                ['state_id' => 6, 'city' => 'Green Mountain Falls'],
                ['state_id' => 6, 'city' => 'Manitou Springs'],
                ['state_id' => 6, 'city' => 'Peyton'],
                ['state_id' => 6, 'city' => 'Ramah'],
                ['state_id' => 6, 'city' => 'Rush'],
                ['state_id' => 6, 'city' => 'Usaf Academy'],
                ['state_id' => 6, 'city' => 'Yoder'],
                ['state_id' => 6, 'city' => 'Colorado Springs'],
                ['state_id' => 6, 'city' => 'Canon City'],
                ['state_id' => 6, 'city' => 'Coal Creek'],
                ['state_id' => 6, 'city' => 'Coaldale'],
                ['state_id' => 6, 'city' => 'Cotopaxi'],
                ['state_id' => 6, 'city' => 'Florence'],
                ['state_id' => 6, 'city' => 'Hillside'],
                ['state_id' => 6, 'city' => 'Howard'],
                ['state_id' => 6, 'city' => 'Penrose'],
                ['state_id' => 6, 'city' => 'Rockvale'],
                ['state_id' => 6, 'city' => 'Glenwood Springs'],
                ['state_id' => 6, 'city' => 'Carbondale'],
                ['state_id' => 6, 'city' => 'Parachute'],
                ['state_id' => 6, 'city' => 'Battlement Mesa'],
                ['state_id' => 6, 'city' => 'New Castle'],
                ['state_id' => 6, 'city' => 'Rifle'],
                ['state_id' => 6, 'city' => 'Silt'],
                ['state_id' => 6, 'city' => 'Black Hawk'],
                ['state_id' => 6, 'city' => 'Central City'],
                ['state_id' => 6, 'city' => 'Rollinsville'],
                ['state_id' => 6, 'city' => 'Fraser'],
                ['state_id' => 6, 'city' => 'Granby'],
                ['state_id' => 6, 'city' => 'Grand Lake'],
                ['state_id' => 6, 'city' => 'Hot Sulphur Springs'],
                ['state_id' => 6, 'city' => 'Kremmling'],
                ['state_id' => 6, 'city' => 'Parshall'],
                ['state_id' => 6, 'city' => 'Tabernash'],
                ['state_id' => 6, 'city' => 'Winter Park'],
                ['state_id' => 6, 'city' => 'Almont'],
                ['state_id' => 6, 'city' => 'Crested Butte'],
                ['state_id' => 6, 'city' => 'Gunnison'],
                ['state_id' => 6, 'city' => 'Ohio City'],
                ['state_id' => 6, 'city' => 'Parlin'],
                ['state_id' => 6, 'city' => 'Pitkin'],
                ['state_id' => 6, 'city' => 'Powderhorn'],
                ['state_id' => 6, 'city' => 'Somerset'],
                ['state_id' => 6, 'city' => 'Lake City'],
                ['state_id' => 6, 'city' => 'Gardner'],
                ['state_id' => 6, 'city' => 'La Veta'],
                ['state_id' => 6, 'city' => 'Walsenburg'],
                ['state_id' => 6, 'city' => 'Coalmont'],
                ['state_id' => 6, 'city' => 'Cowdrey'],
                ['state_id' => 6, 'city' => 'Rand'],
                ['state_id' => 6, 'city' => 'Walden'],
                ['state_id' => 6, 'city' => 'Arvada'],
                ['state_id' => 6, 'city' => 'Wheat Ridge'],
                ['state_id' => 6, 'city' => 'Golden'],
                ['state_id' => 6, 'city' => 'Buffalo Creek'],
                ['state_id' => 6, 'city' => 'Conifer'],
                ['state_id' => 6, 'city' => 'Evergreen'],
                ['state_id' => 6, 'city' => 'Idledale'],
                ['state_id' => 6, 'city' => 'Indian Hills'],
                ['state_id' => 6, 'city' => 'Kittredge'],
                ['state_id' => 6, 'city' => 'Morrison'],
                ['state_id' => 6, 'city' => 'Pine'],
                ['state_id' => 6, 'city' => 'Arlington'],
                ['state_id' => 6, 'city' => 'Eads'],
                ['state_id' => 6, 'city' => 'Haswell'],
                ['state_id' => 6, 'city' => 'Sheridan Lake'],
                ['state_id' => 6, 'city' => 'Bethune'],
                ['state_id' => 6, 'city' => 'Burlington'],
                ['state_id' => 6, 'city' => 'Flagler'],
                ['state_id' => 6, 'city' => 'Seibert'],
                ['state_id' => 6, 'city' => 'Stratton'],
                ['state_id' => 6, 'city' => 'Vona'],
                ['state_id' => 6, 'city' => 'Climax'],
                ['state_id' => 6, 'city' => 'Leadville'],
                ['state_id' => 6, 'city' => 'Twin Lakes'],
                ['state_id' => 6, 'city' => 'Bayfield'],
                ['state_id' => 6, 'city' => 'Ignacio'],
                ['state_id' => 6, 'city' => 'Durango'],
                ['state_id' => 6, 'city' => 'Hesperus'],
                ['state_id' => 6, 'city' => 'Marvel'],
                ['state_id' => 6, 'city' => 'Estes Park'],
                ['state_id' => 6, 'city' => 'Bellvue'],
                ['state_id' => 6, 'city' => 'Berthoud'],
                ['state_id' => 6, 'city' => 'Drake'],
                ['state_id' => 6, 'city' => 'Fort Collins'],
                ['state_id' => 6, 'city' => 'Glen Haven'],
                ['state_id' => 6, 'city' => 'Laporte'],
                ['state_id' => 6, 'city' => 'Livermore'],
                ['state_id' => 6, 'city' => 'Loveland'],
                ['state_id' => 6, 'city' => 'Masonville'],
                ['state_id' => 6, 'city' => 'Red Feather Lakes'],
                ['state_id' => 6, 'city' => 'Timnath'],
                ['state_id' => 6, 'city' => 'Wellington'],
                ['state_id' => 6, 'city' => 'Aguilar'],
                ['state_id' => 6, 'city' => 'Boncarbo'],
                ['state_id' => 6, 'city' => 'Branson'],
                ['state_id' => 6, 'city' => 'Hoehne'],
                ['state_id' => 6, 'city' => 'Kim'],
                ['state_id' => 6, 'city' => 'Model'],
                ['state_id' => 6, 'city' => 'Trinchera'],
                ['state_id' => 6, 'city' => 'Trinidad'],
                ['state_id' => 6, 'city' => 'Weston'],
                ['state_id' => 6, 'city' => 'Arriba'],
                ['state_id' => 6, 'city' => 'Genoa'],
                ['state_id' => 6, 'city' => 'Hugo'],
                ['state_id' => 6, 'city' => 'Karval'],
                ['state_id' => 6, 'city' => 'Limon'],
                ['state_id' => 6, 'city' => 'Atwood'],
                ['state_id' => 6, 'city' => 'Crook'],
                ['state_id' => 6, 'city' => 'Fleming'],
                ['state_id' => 6, 'city' => 'Iliff'],
                ['state_id' => 6, 'city' => 'Merino'],
                ['state_id' => 6, 'city' => 'Padroni'],
                ['state_id' => 6, 'city' => 'Peetz'],
                ['state_id' => 6, 'city' => 'Sterling'],
                ['state_id' => 6, 'city' => 'Grand Junction'],
                ['state_id' => 6, 'city' => 'Clifton'],
                ['state_id' => 6, 'city' => 'Fruita'],
                ['state_id' => 6, 'city' => 'Gateway'],
                ['state_id' => 6, 'city' => 'Glade Park'],
                ['state_id' => 6, 'city' => 'Loma'],
                ['state_id' => 6, 'city' => 'Mack'],
                ['state_id' => 6, 'city' => 'Palisade'],
                ['state_id' => 6, 'city' => 'Whitewater'],
                ['state_id' => 6, 'city' => 'Collbran'],
                ['state_id' => 6, 'city' => 'De Beque'],
                ['state_id' => 6, 'city' => 'Mesa'],
                ['state_id' => 6, 'city' => 'Molina'],
                ['state_id' => 6, 'city' => 'Creede'],
                ['state_id' => 6, 'city' => 'Dinosaur'],
                ['state_id' => 6, 'city' => 'Craig'],
                ['state_id' => 6, 'city' => 'Hamilton'],
                ['state_id' => 6, 'city' => 'Maybell'],
                ['state_id' => 6, 'city' => 'Slater'],
                ['state_id' => 6, 'city' => 'Cortez'],
                ['state_id' => 6, 'city' => 'Dolores'],
                ['state_id' => 6, 'city' => 'Lewis'],
                ['state_id' => 6, 'city' => 'Mancos'],
                ['state_id' => 6, 'city' => 'Mesa Verde National Park'],
                ['state_id' => 6, 'city' => 'Pleasant View'],
                ['state_id' => 6, 'city' => 'Towaoc'],
                ['state_id' => 6, 'city' => 'Yellow Jacket'],
                ['state_id' => 6, 'city' => 'Cimarron'],
                ['state_id' => 6, 'city' => 'Montrose'],
                ['state_id' => 6, 'city' => 'Bedrock'],
                ['state_id' => 6, 'city' => 'Naturita'],
                ['state_id' => 6, 'city' => 'Nucla'],
                ['state_id' => 6, 'city' => 'Olathe'],
                ['state_id' => 6, 'city' => 'Paradox'],
                ['state_id' => 6, 'city' => 'Redvale'],
                ['state_id' => 6, 'city' => 'Orchard'],
                ['state_id' => 6, 'city' => 'Weldona'],
                ['state_id' => 6, 'city' => 'Wiggins'],
                ['state_id' => 6, 'city' => 'Fort Morgan'],
                ['state_id' => 6, 'city' => 'Log Lane Village'],
                ['state_id' => 6, 'city' => 'Brush'],
                ['state_id' => 6, 'city' => 'Hillrose'],
                ['state_id' => 6, 'city' => 'Snyder'],
                ['state_id' => 6, 'city' => 'Cheraw'],
                ['state_id' => 6, 'city' => 'Fowler'],
                ['state_id' => 6, 'city' => 'La Junta'],
                ['state_id' => 6, 'city' => 'Manzanola'],
                ['state_id' => 6, 'city' => 'Rocky Ford'],
                ['state_id' => 6, 'city' => 'Swink'],
                ['state_id' => 6, 'city' => 'Ouray'],
                ['state_id' => 6, 'city' => 'Ridgway'],
                ['state_id' => 6, 'city' => 'Alma'],
                ['state_id' => 6, 'city' => 'Bailey'],
                ['state_id' => 6, 'city' => 'Como'],
                ['state_id' => 6, 'city' => 'Fairplay'],
                ['state_id' => 6, 'city' => 'Grant'],
                ['state_id' => 6, 'city' => 'Hartsel'],
                ['state_id' => 6, 'city' => 'Jefferson'],
                ['state_id' => 6, 'city' => 'Shawnee'],
                ['state_id' => 6, 'city' => 'Guffey'],
                ['state_id' => 6, 'city' => 'Lake George'],
                ['state_id' => 6, 'city' => 'Amherst'],
                ['state_id' => 6, 'city' => 'Haxtun'],
                ['state_id' => 6, 'city' => 'Holyoke'],
                ['state_id' => 6, 'city' => 'Paoli'],
                ['state_id' => 6, 'city' => 'Aspen'],
                ['state_id' => 6, 'city' => 'Snowmass Village'],
                ['state_id' => 6, 'city' => 'Meredith'],
                ['state_id' => 6, 'city' => 'Snowmass'],
                ['state_id' => 6, 'city' => 'Woody Creek'],
                ['state_id' => 6, 'city' => 'Granada'],
                ['state_id' => 6, 'city' => 'Hartman'],
                ['state_id' => 6, 'city' => 'Holly'],
                ['state_id' => 6, 'city' => 'Lamar'],
                ['state_id' => 6, 'city' => 'Wiley'],
                ['state_id' => 6, 'city' => 'Pueblo'],
                ['state_id' => 6, 'city' => 'Colorado City'],
                ['state_id' => 6, 'city' => 'Avondale'],
                ['state_id' => 6, 'city' => 'Beulah'],
                ['state_id' => 6, 'city' => 'Boone'],
                ['state_id' => 6, 'city' => 'Rye'],
                ['state_id' => 6, 'city' => 'Meeker'],
                ['state_id' => 6, 'city' => 'Rangely'],
                ['state_id' => 6, 'city' => 'Del Norte'],
                ['state_id' => 6, 'city' => 'Homelake'],
                ['state_id' => 6, 'city' => 'Monte Vista'],
                ['state_id' => 6, 'city' => 'South Fork'],
                ['state_id' => 6, 'city' => 'Clark'],
                ['state_id' => 6, 'city' => 'Oak Creek'],
                ['state_id' => 6, 'city' => 'Phippsburg'],
                ['state_id' => 6, 'city' => 'Steamboat Springs'],
                ['state_id' => 6, 'city' => 'Toponas'],
                ['state_id' => 6, 'city' => 'Yampa'],
                ['state_id' => 6, 'city' => 'Hayden'],
                ['state_id' => 6, 'city' => 'Center'],
                ['state_id' => 6, 'city' => 'Crestone'],
                ['state_id' => 6, 'city' => 'Moffat'],
                ['state_id' => 6, 'city' => 'Saguache'],
                ['state_id' => 6, 'city' => 'Villa Grove'],
                ['state_id' => 6, 'city' => 'Sargents'],
                ['state_id' => 6, 'city' => 'Silverton'],
                ['state_id' => 6, 'city' => 'Egnar'],
                ['state_id' => 6, 'city' => 'Norwood'],
                ['state_id' => 6, 'city' => 'Ophir'],
                ['state_id' => 6, 'city' => 'Placerville'],
                ['state_id' => 6, 'city' => 'Telluride'],
                ['state_id' => 6, 'city' => 'Julesburg'],
                ['state_id' => 6, 'city' => 'Ovid'],
                ['state_id' => 6, 'city' => 'Sedgwick'],
                ['state_id' => 6, 'city' => 'Breckenridge'],
                ['state_id' => 6, 'city' => 'Dillon'],
                ['state_id' => 6, 'city' => 'Frisco'],
                ['state_id' => 6, 'city' => 'Silverthorne'],
                ['state_id' => 6, 'city' => 'Cripple Creek'],
                ['state_id' => 6, 'city' => 'Divide'],
                ['state_id' => 6, 'city' => 'Florissant'],
                ['state_id' => 6, 'city' => 'Victor'],
                ['state_id' => 6, 'city' => 'Woodland Park'],
                ['state_id' => 6, 'city' => 'Akron'],
                ['state_id' => 6, 'city' => 'Lindon'],
                ['state_id' => 6, 'city' => 'Otis'],
                ['state_id' => 6, 'city' => 'Woodrow'],
                ['state_id' => 6, 'city' => 'Anton'],
                ['state_id' => 6, 'city' => 'Cope'],
                ['state_id' => 6, 'city' => 'Dacono'],
                ['state_id' => 6, 'city' => 'Erie'],
                ['state_id' => 6, 'city' => 'Firestone'],
                ['state_id' => 6, 'city' => 'Frederick'],
                ['state_id' => 6, 'city' => 'Johnstown'],
                ['state_id' => 6, 'city' => 'Mead'],
                ['state_id' => 6, 'city' => 'Milliken'],
                ['state_id' => 6, 'city' => 'Severance'],
                ['state_id' => 6, 'city' => 'Windsor'],
                ['state_id' => 6, 'city' => 'Ault'],
                ['state_id' => 6, 'city' => 'Briggsdale'],
                ['state_id' => 6, 'city' => 'Carr'],
                ['state_id' => 6, 'city' => 'Eaton'],
                ['state_id' => 6, 'city' => 'Evans'],
                ['state_id' => 6, 'city' => 'Fort Lupton'],
                ['state_id' => 6, 'city' => 'Galeton'],
                ['state_id' => 6, 'city' => 'Gilcrest'],
                ['state_id' => 6, 'city' => 'Gill'],
                ['state_id' => 6, 'city' => 'Greeley'],
                ['state_id' => 6, 'city' => 'Hudson'],
                ['state_id' => 6, 'city' => 'Keenesburg'],
                ['state_id' => 6, 'city' => 'Kersey'],
                ['state_id' => 6, 'city' => 'La Salle'],
                ['state_id' => 6, 'city' => 'Lucerne'],
                ['state_id' => 6, 'city' => 'Nunn'],
                ['state_id' => 6, 'city' => 'Pierce'],
                ['state_id' => 6, 'city' => 'Platteville'],
                ['state_id' => 6, 'city' => 'Roggen'],
                ['state_id' => 6, 'city' => 'Grover'],
                ['state_id' => 6, 'city' => 'Hereford'],
                ['state_id' => 6, 'city' => 'New Raymer'],
                ['state_id' => 6, 'city' => 'Stoneham'],
                ['state_id' => 6, 'city' => 'Eckley'],
                ['state_id' => 6, 'city' => 'Idalia'],
                ['state_id' => 6, 'city' => 'Vernon'],
                ['state_id' => 6, 'city' => 'Wray'],
                ['state_id' => 6, 'city' => 'Yuma'],
                ['state_id' => 6, 'city' => 'Joes'],
                ['state_id' => 6, 'city' => 'Kirk']
            ];
            foreach ($cities as $key => $city) {
                City::create($city);
            }
        }
    }
}
