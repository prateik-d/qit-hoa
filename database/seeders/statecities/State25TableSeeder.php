<?php
namespace Database\Seeders\statecities;

use Illuminate\Database\Seeder;
use App\Models\City;
class State25TableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Create Cities for the state of MS - Mississippi.
        //If the table 'cities' exists, insert the data to the table.
        if (City::count() >= 0) {
            $cities = [
                ['state_id' => 25, 'city' => 'Natchez'],
                ['state_id' => 25, 'city' => 'Sibley'],
                ['state_id' => 25, 'city' => 'Washington'],
                ['state_id' => 25, 'city' => 'Corinth'],
                ['state_id' => 25, 'city' => 'Glen'],
                ['state_id' => 25, 'city' => 'Rienzi'],
                ['state_id' => 25, 'city' => 'Crosby'],
                ['state_id' => 25, 'city' => 'Gloster'],
                ['state_id' => 25, 'city' => 'Liberty'],
                ['state_id' => 25, 'city' => 'Smithdale'],
                ['state_id' => 25, 'city' => 'Ethel'],
                ['state_id' => 25, 'city' => 'Kosciusko'],
                ['state_id' => 25, 'city' => 'Mc Adams'],
                ['state_id' => 25, 'city' => 'Mc Cool'],
                ['state_id' => 25, 'city' => 'Sallis'],
                ['state_id' => 25, 'city' => 'Ashland'],
                ['state_id' => 25, 'city' => 'Hickory Flat'],
                ['state_id' => 25, 'city' => 'Michigan City'],
                ['state_id' => 25, 'city' => 'Alligator'],
                ['state_id' => 25, 'city' => 'Benoit'],
                ['state_id' => 25, 'city' => 'Beulah'],
                ['state_id' => 25, 'city' => 'Boyle'],
                ['state_id' => 25, 'city' => 'Cleveland'],
                ['state_id' => 25, 'city' => 'Duncan'],
                ['state_id' => 25, 'city' => 'Gunnison'],
                ['state_id' => 25, 'city' => 'Merigold'],
                ['state_id' => 25, 'city' => 'Mound Bayou'],
                ['state_id' => 25, 'city' => 'Pace'],
                ['state_id' => 25, 'city' => 'Rosedale'],
                ['state_id' => 25, 'city' => 'Scott'],
                ['state_id' => 25, 'city' => 'Shaw'],
                ['state_id' => 25, 'city' => 'Shelby'],
                ['state_id' => 25, 'city' => 'Winstonville'],
                ['state_id' => 25, 'city' => 'Derma'],
                ['state_id' => 25, 'city' => 'Vardaman'],
                ['state_id' => 25, 'city' => 'Banner'],
                ['state_id' => 25, 'city' => 'Big Creek'],
                ['state_id' => 25, 'city' => 'Bruce'],
                ['state_id' => 25, 'city' => 'Calhoun City'],
                ['state_id' => 25, 'city' => 'Pittsboro'],
                ['state_id' => 25, 'city' => 'Slate Spring'],
                ['state_id' => 25, 'city' => 'Mantee'],
                ['state_id' => 25, 'city' => 'Carrollton'],
                ['state_id' => 25, 'city' => 'Coila'],
                ['state_id' => 25, 'city' => 'Mc Carley'],
                ['state_id' => 25, 'city' => 'North Carrollton'],
                ['state_id' => 25, 'city' => 'Sidon'],
                ['state_id' => 25, 'city' => 'Vaiden'],
                ['state_id' => 25, 'city' => 'Houlka'],
                ['state_id' => 25, 'city' => 'Houston'],
                ['state_id' => 25, 'city' => 'Okolona'],
                ['state_id' => 25, 'city' => 'Trebloc'],
                ['state_id' => 25, 'city' => 'Van Vleet'],
                ['state_id' => 25, 'city' => 'Woodland'],
                ['state_id' => 25, 'city' => 'Ackerman'],
                ['state_id' => 25, 'city' => 'French Camp'],
                ['state_id' => 25, 'city' => 'Weir'],
                ['state_id' => 25, 'city' => 'Hermanville'],
                ['state_id' => 25, 'city' => 'Pattison'],
                ['state_id' => 25, 'city' => 'Port Gibson'],
                ['state_id' => 25, 'city' => 'Enterprise'],
                ['state_id' => 25, 'city' => 'Pachuta'],
                ['state_id' => 25, 'city' => 'Quitman'],
                ['state_id' => 25, 'city' => 'Shubuta'],
                ['state_id' => 25, 'city' => 'Stonewall'],
                ['state_id' => 25, 'city' => 'Cedarbluff'],
                ['state_id' => 25, 'city' => 'Montpelier'],
                ['state_id' => 25, 'city' => 'Pheba'],
                ['state_id' => 25, 'city' => 'West Point'],
                ['state_id' => 25, 'city' => 'Clarksdale'],
                ['state_id' => 25, 'city' => 'Coahoma'],
                ['state_id' => 25, 'city' => 'Farrell'],
                ['state_id' => 25, 'city' => 'Friars Point'],
                ['state_id' => 25, 'city' => 'Jonestown'],
                ['state_id' => 25, 'city' => 'Lula'],
                ['state_id' => 25, 'city' => 'Lyon'],
                ['state_id' => 25, 'city' => 'Sherard'],
                ['state_id' => 25, 'city' => 'Dublin'],
                ['state_id' => 25, 'city' => 'Rena Lara'],
                ['state_id' => 25, 'city' => 'Crystal Springs'],
                ['state_id' => 25, 'city' => 'Gallman'],
                ['state_id' => 25, 'city' => 'Georgetown'],
                ['state_id' => 25, 'city' => 'Hazlehurst'],
                ['state_id' => 25, 'city' => 'Wesson'],
                ['state_id' => 25, 'city' => 'Mount Olive'],
                ['state_id' => 25, 'city' => 'Collins'],
                ['state_id' => 25, 'city' => 'Seminary'],
                ['state_id' => 25, 'city' => 'Hernando'],
                ['state_id' => 25, 'city' => 'Horn Lake'],
                ['state_id' => 25, 'city' => 'Lake Cormorant'],
                ['state_id' => 25, 'city' => 'Nesbit'],
                ['state_id' => 25, 'city' => 'Olive Branch'],
                ['state_id' => 25, 'city' => 'Southaven'],
                ['state_id' => 25, 'city' => 'Walls'],
                ['state_id' => 25, 'city' => 'Hattiesburg'],
                ['state_id' => 25, 'city' => 'Brooklyn'],
                ['state_id' => 25, 'city' => 'Petal'],
                ['state_id' => 25, 'city' => 'Bude'],
                ['state_id' => 25, 'city' => 'Mc Call Creek'],
                ['state_id' => 25, 'city' => 'Meadville'],
                ['state_id' => 25, 'city' => 'Roxie'],
                ['state_id' => 25, 'city' => 'Lucedale'],
                ['state_id' => 25, 'city' => 'State Line'],
                ['state_id' => 25, 'city' => 'Leakesville'],
                ['state_id' => 25, 'city' => 'Mc Lain'],
                ['state_id' => 25, 'city' => 'Neely'],
                ['state_id' => 25, 'city' => 'Grenada'],
                ['state_id' => 25, 'city' => 'Elliott'],
                ['state_id' => 25, 'city' => 'Gore Springs'],
                ['state_id' => 25, 'city' => 'Holcomb'],
                ['state_id' => 25, 'city' => 'Tie Plant'],
                ['state_id' => 25, 'city' => 'Bay Saint Louis'],
                ['state_id' => 25, 'city' => 'Stennis Space Center'],
                ['state_id' => 25, 'city' => 'Diamondhead'],
                ['state_id' => 25, 'city' => 'Kiln'],
                ['state_id' => 25, 'city' => 'Lakeshore'],
                ['state_id' => 25, 'city' => 'Pearlington'],
                ['state_id' => 25, 'city' => 'Waveland'],
                ['state_id' => 25, 'city' => 'Gulfport'],
                ['state_id' => 25, 'city' => 'Biloxi'],
                ['state_id' => 25, 'city' => 'Diberville'],
                ['state_id' => 25, 'city' => 'Long Beach'],
                ['state_id' => 25, 'city' => 'Pass Christian'],
                ['state_id' => 25, 'city' => 'Saucier'],
                ['state_id' => 25, 'city' => 'Bolton'],
                ['state_id' => 25, 'city' => 'Clinton'],
                ['state_id' => 25, 'city' => 'Edwards'],
                ['state_id' => 25, 'city' => 'Raymond'],
                ['state_id' => 25, 'city' => 'Terry'],
                ['state_id' => 25, 'city' => 'Tougaloo'],
                ['state_id' => 25, 'city' => 'Utica'],
                ['state_id' => 25, 'city' => 'Jackson'],
                ['state_id' => 25, 'city' => 'Byram'],
                ['state_id' => 25, 'city' => 'Cruger'],
                ['state_id' => 25, 'city' => 'Durant'],
                ['state_id' => 25, 'city' => 'Goodman'],
                ['state_id' => 25, 'city' => 'Lexington'],
                ['state_id' => 25, 'city' => 'Pickens'],
                ['state_id' => 25, 'city' => 'Tchula'],
                ['state_id' => 25, 'city' => 'West'],
                ['state_id' => 25, 'city' => 'Isola'],
                ['state_id' => 25, 'city' => 'Belzoni'],
                ['state_id' => 25, 'city' => 'Louise'],
                ['state_id' => 25, 'city' => 'Midnight'],
                ['state_id' => 25, 'city' => 'Silver City'],
                ['state_id' => 25, 'city' => 'Grace'],
                ['state_id' => 25, 'city' => 'Mayersville'],
                ['state_id' => 25, 'city' => 'Valley Park'],
                ['state_id' => 25, 'city' => 'Fulton'],
                ['state_id' => 25, 'city' => 'Golden'],
                ['state_id' => 25, 'city' => 'Mantachie'],
                ['state_id' => 25, 'city' => 'Nettleton'],
                ['state_id' => 25, 'city' => 'Tremont'],
                ['state_id' => 25, 'city' => 'Escatawpa'],
                ['state_id' => 25, 'city' => 'Gautier'],
                ['state_id' => 25, 'city' => 'Hurley'],
                ['state_id' => 25, 'city' => 'Moss Point'],
                ['state_id' => 25, 'city' => 'Ocean Springs'],
                ['state_id' => 25, 'city' => 'Vancleave'],
                ['state_id' => 25, 'city' => 'Pascagoula'],
                ['state_id' => 25, 'city' => 'Louin'],
                ['state_id' => 25, 'city' => 'Paulding'],
                ['state_id' => 25, 'city' => 'Rose Hill'],
                ['state_id' => 25, 'city' => 'Vossburg'],
                ['state_id' => 25, 'city' => 'Bay Springs'],
                ['state_id' => 25, 'city' => 'Heidelberg'],
                ['state_id' => 25, 'city' => 'Moss'],
                ['state_id' => 25, 'city' => 'Stringer'],
                ['state_id' => 25, 'city' => 'Fayette'],
                ['state_id' => 25, 'city' => 'Harriston'],
                ['state_id' => 25, 'city' => 'Lorman'],
                ['state_id' => 25, 'city' => 'Union Church'],
                ['state_id' => 25, 'city' => 'Bassfield'],
                ['state_id' => 25, 'city' => 'Carson'],
                ['state_id' => 25, 'city' => 'Prentiss'],
                ['state_id' => 25, 'city' => 'Eastabuchie'],
                ['state_id' => 25, 'city' => 'Ellisville'],
                ['state_id' => 25, 'city' => 'Laurel'],
                ['state_id' => 25, 'city' => 'Moselle'],
                ['state_id' => 25, 'city' => 'Sandersville'],
                ['state_id' => 25, 'city' => 'Soso'],
                ['state_id' => 25, 'city' => 'De Kalb'],
                ['state_id' => 25, 'city' => 'Porterville'],
                ['state_id' => 25, 'city' => 'Preston'],
                ['state_id' => 25, 'city' => 'Scooba'],
                ['state_id' => 25, 'city' => 'Abbeville'],
                ['state_id' => 25, 'city' => 'Oxford'],
                ['state_id' => 25, 'city' => 'Taylor'],
                ['state_id' => 25, 'city' => 'Tula'],
                ['state_id' => 25, 'city' => 'University'],
                ['state_id' => 25, 'city' => 'Waterford'],
                ['state_id' => 25, 'city' => 'Toccopola'],
                ['state_id' => 25, 'city' => 'Paris'],
                ['state_id' => 25, 'city' => 'Lumberton'],
                ['state_id' => 25, 'city' => 'Purvis'],
                ['state_id' => 25, 'city' => 'Sumrall'],
                ['state_id' => 25, 'city' => 'Meridian'],
                ['state_id' => 25, 'city' => 'Bailey'],
                ['state_id' => 25, 'city' => 'Collinsville'],
                ['state_id' => 25, 'city' => 'Daleville'],
                ['state_id' => 25, 'city' => 'Lauderdale'],
                ['state_id' => 25, 'city' => 'Marion'],
                ['state_id' => 25, 'city' => 'Toomsuba'],
                ['state_id' => 25, 'city' => 'Newhebron'],
                ['state_id' => 25, 'city' => 'Jayess'],
                ['state_id' => 25, 'city' => 'Monticello'],
                ['state_id' => 25, 'city' => 'Oak Vale'],
                ['state_id' => 25, 'city' => 'Silver Creek'],
                ['state_id' => 25, 'city' => 'Sontag'],
                ['state_id' => 25, 'city' => 'Carthage'],
                ['state_id' => 25, 'city' => 'Lena'],
                ['state_id' => 25, 'city' => 'Madden'],
                ['state_id' => 25, 'city' => 'Thomastown'],
                ['state_id' => 25, 'city' => 'Walnut Grove'],
                ['state_id' => 25, 'city' => 'Tupelo'],
                ['state_id' => 25, 'city' => 'Baldwyn'],
                ['state_id' => 25, 'city' => 'Belden'],
                ['state_id' => 25, 'city' => 'Guntown'],
                ['state_id' => 25, 'city' => 'Mooreville'],
                ['state_id' => 25, 'city' => 'Plantersville'],
                ['state_id' => 25, 'city' => 'Saltillo'],
                ['state_id' => 25, 'city' => 'Shannon'],
                ['state_id' => 25, 'city' => 'Verona'],
                ['state_id' => 25, 'city' => 'Greenwood'],
                ['state_id' => 25, 'city' => 'Itta Bena'],
                ['state_id' => 25, 'city' => 'Minter City'],
                ['state_id' => 25, 'city' => 'Money'],
                ['state_id' => 25, 'city' => 'Morgan City'],
                ['state_id' => 25, 'city' => 'Schlater'],
                ['state_id' => 25, 'city' => 'Swiftown'],
                ['state_id' => 25, 'city' => 'Brookhaven'],
                ['state_id' => 25, 'city' => 'Bogue Chitto'],
                ['state_id' => 25, 'city' => 'Ruth'],
                ['state_id' => 25, 'city' => 'Columbus'],
                ['state_id' => 25, 'city' => 'Artesia'],
                ['state_id' => 25, 'city' => 'Crawford'],
                ['state_id' => 25, 'city' => 'Mayhew'],
                ['state_id' => 25, 'city' => 'Steens'],
                ['state_id' => 25, 'city' => 'Camden'],
                ['state_id' => 25, 'city' => 'Canton'],
                ['state_id' => 25, 'city' => 'Flora'],
                ['state_id' => 25, 'city' => 'Madison'],
                ['state_id' => 25, 'city' => 'Ridgeland'],
                ['state_id' => 25, 'city' => 'Sharon'],
                ['state_id' => 25, 'city' => 'Columbia'],
                ['state_id' => 25, 'city' => 'Sandy Hook'],
                ['state_id' => 25, 'city' => 'Foxworth'],
                ['state_id' => 25, 'city' => 'Kokomo'],
                ['state_id' => 25, 'city' => 'Byhalia'],
                ['state_id' => 25, 'city' => 'Holly Springs'],
                ['state_id' => 25, 'city' => 'Lamar'],
                ['state_id' => 25, 'city' => 'Mount Pleasant'],
                ['state_id' => 25, 'city' => 'Potts Camp'],
                ['state_id' => 25, 'city' => 'Red Banks'],
                ['state_id' => 25, 'city' => 'Victoria'],
                ['state_id' => 25, 'city' => 'Amory'],
                ['state_id' => 25, 'city' => 'Becker'],
                ['state_id' => 25, 'city' => 'Gattman'],
                ['state_id' => 25, 'city' => 'Greenwood Springs'],
                ['state_id' => 25, 'city' => 'Smithville'],
                ['state_id' => 25, 'city' => 'Aberdeen'],
                ['state_id' => 25, 'city' => 'Caledonia'],
                ['state_id' => 25, 'city' => 'Hamilton'],
                ['state_id' => 25, 'city' => 'Prairie'],
                ['state_id' => 25, 'city' => 'Duck Hill'],
                ['state_id' => 25, 'city' => 'Winona'],
                ['state_id' => 25, 'city' => 'Kilmichael'],
                ['state_id' => 25, 'city' => 'Stewart'],
                ['state_id' => 25, 'city' => 'Philadelphia'],
                ['state_id' => 25, 'city' => 'Union'],
                ['state_id' => 25, 'city' => 'Conehatta'],
                ['state_id' => 25, 'city' => 'Chunky'],
                ['state_id' => 25, 'city' => 'Decatur'],
                ['state_id' => 25, 'city' => 'Hickory'],
                ['state_id' => 25, 'city' => 'Lawrence'],
                ['state_id' => 25, 'city' => 'Little Rock'],
                ['state_id' => 25, 'city' => 'Newton'],
                ['state_id' => 25, 'city' => 'Macon'],
                ['state_id' => 25, 'city' => 'Shuqualak'],
                ['state_id' => 25, 'city' => 'Brooksville'],
                ['state_id' => 25, 'city' => 'Starkville'],
                ['state_id' => 25, 'city' => 'Mississippi State'],
                ['state_id' => 25, 'city' => 'Sturgis'],
                ['state_id' => 25, 'city' => 'Batesville'],
                ['state_id' => 25, 'city' => 'Como'],
                ['state_id' => 25, 'city' => 'Courtland'],
                ['state_id' => 25, 'city' => 'Crenshaw'],
                ['state_id' => 25, 'city' => 'Pope'],
                ['state_id' => 25, 'city' => 'Sarah'],
                ['state_id' => 25, 'city' => 'Sardis'],
                ['state_id' => 25, 'city' => 'Carriere'],
                ['state_id' => 25, 'city' => 'Mc Neill'],
                ['state_id' => 25, 'city' => 'Nicholson'],
                ['state_id' => 25, 'city' => 'Picayune'],
                ['state_id' => 25, 'city' => 'Poplarville'],
                ['state_id' => 25, 'city' => 'Beaumont'],
                ['state_id' => 25, 'city' => 'New Augusta'],
                ['state_id' => 25, 'city' => 'Ovett'],
                ['state_id' => 25, 'city' => 'Richton'],
                ['state_id' => 25, 'city' => 'Chatawa'],
                ['state_id' => 25, 'city' => 'Fernwood'],
                ['state_id' => 25, 'city' => 'Mccomb'],
                ['state_id' => 25, 'city' => 'Magnolia'],
                ['state_id' => 25, 'city' => 'Osyka'],
                ['state_id' => 25, 'city' => 'Summit'],
                ['state_id' => 25, 'city' => 'Algoma'],
                ['state_id' => 25, 'city' => 'Ecru'],
                ['state_id' => 25, 'city' => 'Pontotoc'],
                ['state_id' => 25, 'city' => 'Randolph'],
                ['state_id' => 25, 'city' => 'Sherman'],
                ['state_id' => 25, 'city' => 'Thaxton'],
                ['state_id' => 25, 'city' => 'Booneville'],
                ['state_id' => 25, 'city' => 'Marietta'],
                ['state_id' => 25, 'city' => 'New Site'],
                ['state_id' => 25, 'city' => 'Wheeler'],
                ['state_id' => 25, 'city' => 'Belen'],
                ['state_id' => 25, 'city' => 'Crowder'],
                ['state_id' => 25, 'city' => 'Darling'],
                ['state_id' => 25, 'city' => 'Falcon'],
                ['state_id' => 25, 'city' => 'Lambert'],
                ['state_id' => 25, 'city' => 'Marks'],
                ['state_id' => 25, 'city' => 'Vance'],
                ['state_id' => 25, 'city' => 'Brandon'],
                ['state_id' => 25, 'city' => 'Florence'],
                ['state_id' => 25, 'city' => 'Pelahatchie'],
                ['state_id' => 25, 'city' => 'Piney Woods'],
                ['state_id' => 25, 'city' => 'Puckett'],
                ['state_id' => 25, 'city' => 'Sandhill'],
                ['state_id' => 25, 'city' => 'Star'],
                ['state_id' => 25, 'city' => 'Whitfield'],
                ['state_id' => 25, 'city' => 'Pearl'],
                ['state_id' => 25, 'city' => 'Richland'],
                ['state_id' => 25, 'city' => 'Flowood'],
                ['state_id' => 25, 'city' => 'Forest'],
                ['state_id' => 25, 'city' => 'Harperville'],
                ['state_id' => 25, 'city' => 'Hillsboro'],
                ['state_id' => 25, 'city' => 'Lake'],
                ['state_id' => 25, 'city' => 'Ludlow'],
                ['state_id' => 25, 'city' => 'Morton'],
                ['state_id' => 25, 'city' => 'Pulaski'],
                ['state_id' => 25, 'city' => 'Sebastopol'],
                ['state_id' => 25, 'city' => 'Anguilla'],
                ['state_id' => 25, 'city' => 'Panther Burn'],
                ['state_id' => 25, 'city' => 'Cary'],
                ['state_id' => 25, 'city' => 'Delta City'],
                ['state_id' => 25, 'city' => 'Rolling Fork'],
                ['state_id' => 25, 'city' => 'Braxton'],
                ['state_id' => 25, 'city' => 'D Lo'],
                ['state_id' => 25, 'city' => 'Harrisville'],
                ['state_id' => 25, 'city' => 'Magee'],
                ['state_id' => 25, 'city' => 'Mendenhall'],
                ['state_id' => 25, 'city' => 'Pinola'],
                ['state_id' => 25, 'city' => 'Mize'],
                ['state_id' => 25, 'city' => 'Raleigh'],
                ['state_id' => 25, 'city' => 'Taylorsville'],
                ['state_id' => 25, 'city' => 'Mc Henry'],
                ['state_id' => 25, 'city' => 'Perkinston'],
                ['state_id' => 25, 'city' => 'Wiggins'],
                ['state_id' => 25, 'city' => 'Doddsville'],
                ['state_id' => 25, 'city' => 'Drew'],
                ['state_id' => 25, 'city' => 'Parchman'],
                ['state_id' => 25, 'city' => 'Indianola'],
                ['state_id' => 25, 'city' => 'Inverness'],
                ['state_id' => 25, 'city' => 'Moorhead'],
                ['state_id' => 25, 'city' => 'Rome'],
                ['state_id' => 25, 'city' => 'Ruleville'],
                ['state_id' => 25, 'city' => 'Sunflower'],
                ['state_id' => 25, 'city' => 'Cascilla'],
                ['state_id' => 25, 'city' => 'Charleston'],
                ['state_id' => 25, 'city' => 'Enid'],
                ['state_id' => 25, 'city' => 'Glendora'],
                ['state_id' => 25, 'city' => 'Philipp'],
                ['state_id' => 25, 'city' => 'Sumner'],
                ['state_id' => 25, 'city' => 'Swan Lake'],
                ['state_id' => 25, 'city' => 'Tippo'],
                ['state_id' => 25, 'city' => 'Tutwiler'],
                ['state_id' => 25, 'city' => 'Webb'],
                ['state_id' => 25, 'city' => 'Arkabutla'],
                ['state_id' => 25, 'city' => 'Coldwater'],
                ['state_id' => 25, 'city' => 'Independence'],
                ['state_id' => 25, 'city' => 'Senatobia'],
                ['state_id' => 25, 'city' => 'Blue Mountain'],
                ['state_id' => 25, 'city' => 'Dumas'],
                ['state_id' => 25, 'city' => 'Falkner'],
                ['state_id' => 25, 'city' => 'Ripley'],
                ['state_id' => 25, 'city' => 'Tiplersville'],
                ['state_id' => 25, 'city' => 'Walnut'],
                ['state_id' => 25, 'city' => 'Belmont'],
                ['state_id' => 25, 'city' => 'Burnsville'],
                ['state_id' => 25, 'city' => 'Dennis'],
                ['state_id' => 25, 'city' => 'Iuka'],
                ['state_id' => 25, 'city' => 'Tishomingo'],
                ['state_id' => 25, 'city' => 'Dundee'],
                ['state_id' => 25, 'city' => 'Robinsonville'],
                ['state_id' => 25, 'city' => 'Sledge'],
                ['state_id' => 25, 'city' => 'Tunica'],
                ['state_id' => 25, 'city' => 'Etta'],
                ['state_id' => 25, 'city' => 'Myrtle'],
                ['state_id' => 25, 'city' => 'New Albany'],
                ['state_id' => 25, 'city' => 'Blue Springs'],
                ['state_id' => 25, 'city' => 'Tylertown'],
                ['state_id' => 25, 'city' => 'Redwood'],
                ['state_id' => 25, 'city' => 'Vicksburg'],
                ['state_id' => 25, 'city' => 'Greenville'],
                ['state_id' => 25, 'city' => 'Arcola'],
                ['state_id' => 25, 'city' => 'Avon'],
                ['state_id' => 25, 'city' => 'Chatham'],
                ['state_id' => 25, 'city' => 'Glen Allan'],
                ['state_id' => 25, 'city' => 'Hollandale'],
                ['state_id' => 25, 'city' => 'Leland'],
                ['state_id' => 25, 'city' => 'Metcalfe'],
                ['state_id' => 25, 'city' => 'Stoneville'],
                ['state_id' => 25, 'city' => 'Wayside'],
                ['state_id' => 25, 'city' => 'Winterville'],
                ['state_id' => 25, 'city' => 'Buckatunna'],
                ['state_id' => 25, 'city' => 'Clara'],
                ['state_id' => 25, 'city' => 'Waynesboro'],
                ['state_id' => 25, 'city' => 'Bellefontaine'],
                ['state_id' => 25, 'city' => 'Eupora'],
                ['state_id' => 25, 'city' => 'Maben'],
                ['state_id' => 25, 'city' => 'Mathiston'],
                ['state_id' => 25, 'city' => 'Walthall'],
                ['state_id' => 25, 'city' => 'Centreville'],
                ['state_id' => 25, 'city' => 'Woodville'],
                ['state_id' => 25, 'city' => 'Louisville'],
                ['state_id' => 25, 'city' => 'Noxapater'],
                ['state_id' => 25, 'city' => 'Coffeeville'],
                ['state_id' => 25, 'city' => 'Oakland'],
                ['state_id' => 25, 'city' => 'Scobey'],
                ['state_id' => 25, 'city' => 'Tillatoba'],
                ['state_id' => 25, 'city' => 'Water Valley'],
                ['state_id' => 25, 'city' => 'Benton'],
                ['state_id' => 25, 'city' => 'Bentonia'],
                ['state_id' => 25, 'city' => 'Holly Bluff'],
                ['state_id' => 25, 'city' => 'Satartia'],
                ['state_id' => 25, 'city' => 'Tinsley'],
                ['state_id' => 25, 'city' => 'Vaughan'],
                ['state_id' => 25, 'city' => 'Yazoo City']
            ];
            foreach ($cities as $key => $city) {
                City::create($city);
            }
        }
    }
}
