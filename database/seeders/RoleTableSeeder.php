<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::truncate();

        $roles = [
            ['role_type' => 'admin', 'permission_id' => 1],
            ['role_type' => 'moderator', 'permission_id' => 2],
            ['role_type' => 'home-owner', 'permission_id' => 3],
            ['role_type' => 'contractor', 'permission_id' => 4],
            ['role_type' => 'renter', 'permission_id' => 5]
        ];
  
        foreach ($roles as $key => $role) {
            Role::create($role);
        }
    }
}
