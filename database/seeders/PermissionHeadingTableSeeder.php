<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PermissionHeading;

class PermissionHeadingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PermissionHeading::truncate();

        $permissions = [
            ['heading' => 'users', 'status' => 1],
            ['heading' => 'user-roles', 'status' => 1],
            ['heading' => 'vehicles', 'status' => 1],
            ['heading' => 'pet-registry', 'status' => 1],
            ['heading' => 'violations', 'status' => 1],
            ['heading' => 'tickets', 'status' => 1],
            ['heading' => 'voting', 'status' => 1],
            ['heading' => 'acc', 'status' => 1],
            ['heading' => 'events', 'status' => 1],
            ['heading' => 'lost-and-found', 'status' => 1],
            ['heading' => 'committee', 'status' => 1],
            ['heading' => 'amenities', 'status' => 1],
            ['heading' => 'manage-reports', 'status' => 1],
            ['heading' => 'reservations', 'status' => 1],
        ];
  
        foreach ($permissions as $key => $permission) {
            PermissionHeading::create($permission);
        }
    }
}
