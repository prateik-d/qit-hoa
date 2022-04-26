<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(1)->create();
        $this->call(CategoriesTableSeeder::class);
        $this->call(RoleTableSeeder::class);
        $this->call(TicketCategoryTableSeeder::class);
        $this->call(VehicleColorTableSeeder::class);
        $this->call(VehicleMakeTableSeeder::class);
        $this->call(VehicleModelTableSeeder::class);
        $this->call(StateTableSeeder::class);
        // Seeder of Cities by States
        //AL - Alabama
        $this->call([statecities\state1TableSeeder::class]);
        //AK - Alaska
        $this->call([statecities\state2TableSeeder::class]);
        //AZ - Arizona
        $this->call([statecities\state3TableSeeder::class]);
        //AR - Arkansas
        $this->call([statecities\state4TableSeeder::class]);
         //CA - California
        $this->call([statecities\state5TableSeeder::class]);
        //CO - Colorado
        $this->call([statecities\state6TableSeeder::class]);
        //CT - Connecticut
        $this->call([statecities\state7TableSeeder::class]);
        //DE - Delaware
        $this->call([statecities\state8TableSeeder::class]);
        //DC - District of Columbia
        $this->call([statecities\state9TableSeeder::class]);
        //FL - Florida
        $this->call([statecities\state10TableSeeder::class]);
        //GA - Georgia
        $this->call([statecities\state11TableSeeder::class]);
        //HI - Hawaii
        $this->call([statecities\state12TableSeeder::class]);
        //ID - Idaho
        $this->call([statecities\state13TableSeeder::class]);
        //IL - Illinois
        $this->call([statecities\state14TableSeeder::class]);
        //IN - Indiana
        $this->call([statecities\state15TableSeeder::class]);
        //IA - Iowa
        $this->call([statecities\state16TableSeeder::class]);
        //KS - Kansas
        $this->call([statecities\state17TableSeeder::class]);
        //KY - Kentucky
        $this->call([statecities\state18TableSeeder::class]);
        //LA - Louisiana
        $this->call([statecities\state19TableSeeder::class]);
        //ME - Maine
        $this->call([statecities\state20TableSeeder::class]);
        //MD - Maryland
        $this->call([statecities\state21TableSeeder::class]);
        //MA - Massachusetts
        $this->call([statecities\state22TableSeeder::class]);
        //MI - Michigan
        $this->call([statecities\state23TableSeeder::class]);
        //MN - Minnesota
        $this->call([statecities\state24TableSeeder::class]);
        //MS - Mississippi
        $this->call([statecities\state25TableSeeder::class]);
        //MO - Missouri
        $this->call([statecities\state26TableSeeder::class]);
        //MT - Montana
        $this->call([statecities\state27TableSeeder::class]);
        //NE - Nebraska
        $this->call([statecities\state28TableSeeder::class]);
        //NV - Nevada
        $this->call([statecities\state29TableSeeder::class]);
        //NH - New Hampshire
        $this->call([statecities\state30TableSeeder::class]);
        //NJ - New Jersey
        $this->call([statecities\state31TableSeeder::class]);
        //NM - New Mexico
        $this->call([statecities\state32TableSeeder::class]);
        //NY - New York
        $this->call([statecities\state33TableSeeder::class]);
        //NC - North Carolina
        $this->call([statecities\state34TableSeeder::class]);
        //ND - North Dakota
         $this->call([statecities\state35TableSeeder::class]);
         //OH - Ohio
         $this->call([statecities\state36TableSeeder::class]);
         //OK - Oklahoma
         $this->call([statecities\state37TableSeeder::class]);
         //OR - Oregon
         $this->call([statecities\state38TableSeeder::class]);
         //PA - Pennsylvania
         $this->call([statecities\state39TableSeeder::class]);
         //RI - Rhode Island
         $this->call([statecities\state40TableSeeder::class]);
         //SC - South Carolina
         $this->call([statecities\state41TableSeeder::class]);
         //SD - South Dakota
         $this->call([statecities\state42TableSeeder::class]);
         //TN - Tennessee
         $this->call([statecities\state43TableSeeder::class]);
         //TX - Texas
         $this->call([statecities\state44TableSeeder::class]);
         //UT - Utah
         $this->call([statecities\state45TableSeeder::class]);
         //VT - Vermont
         $this->call([statecities\state46TableSeeder::class]);
         //VA - Virginia
         $this->call([statecities\state47TableSeeder::class]);
         //WA - Washington
         $this->call([statecities\state48TableSeeder::class]);
         //WV - West Virginia
         $this->call([statecities\state49TableSeeder::class]);
         //WI - Wisconsin
         $this->call([statecities\state50TableSeeder::class]);
         //WY - Wyoming
         $this->call([statecities\state51TableSeeder::class]);
    }
}
