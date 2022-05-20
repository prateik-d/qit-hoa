<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::truncate();

        $permissions = [
            ['permission_heading_id' => 1, 'type' => 'add-users', 'status' => 1],
            ['permission_heading_id' => 1, 'type' => 'edit-users', 'status' => 1],
            ['permission_heading_id' => 1, 'type' => 'delete-users', 'status' => 1],
            ['permission_heading_id' => 2, 'type' => 'add-user-roles', 'status' => 1],
            ['permission_heading_id' => 2, 'type' => 'edit-user-roles', 'status' => 1],
            ['permission_heading_id' => 2, 'type' => 'delete-user-roles', 'status' => 1],
            ['permission_heading_id' => 3, 'type' => 'add-vehicles', 'status' => 1],
            ['permission_heading_id' => 3, 'type' => 'edit-vehicles', 'status' => 1],
            ['permission_heading_id' => 3, 'type' => 'delete-vehicles', 'status' => 1],
            ['permission_heading_id' => 3, 'type' => 'issue-toll-logs', 'status' => 1],
            ['permission_heading_id' => 4, 'type' => 'add-pets', 'status' => 1],
            ['permission_heading_id' => 4, 'type' => 'edit-pets', 'status' => 1],
            ['permission_heading_id' => 4, 'type' => 'delete-pets', 'status' => 1],
            ['permission_heading_id' => 5, 'type' => 'add-violations', 'status' => 1],
            ['permission_heading_id' => 5, 'type' => 'edit-violations', 'status' => 1],
            ['permission_heading_id' => 5, 'type' => 'delete-violations', 'status' => 1],
            ['permission_heading_id' => 6, 'type' => 'add-tickets', 'status' => 1],
            ['permission_heading_id' => 6, 'type' => 'edit-tickets', 'status' => 1],
            ['permission_heading_id' => 6, 'type' => 'delete-tickets', 'status' => 1],
            ['permission_heading_id' => 7, 'type' => 'add-voting', 'status' => 1],
            ['permission_heading_id' => 7, 'type' => 'edit-voting', 'status' => 1],
            ['permission_heading_id' => 7, 'type' => 'delete-voting', 'status' => 1],
            ['permission_heading_id' => 8, 'type' => 'add-acc-requests', 'status' => 1],
            ['permission_heading_id' => 8, 'type' => 'edit-acc-requests', 'status' => 1],
            ['permission_heading_id' => 8, 'type' => 'delete-acc-requests', 'status' => 1],
            ['permission_heading_id' => 9, 'type' => 'add-events', 'status' => 1],
            ['permission_heading_id' => 9, 'type' => 'edit-events', 'status' => 1],
            ['permission_heading_id' => 9, 'type' => 'delete-events', 'status' => 1],
            ['permission_heading_id' => 10, 'type' => 'add-lost-and-found', 'status' => 1],
            ['permission_heading_id' => 10, 'type' => 'edit-lost-and-found', 'status' => 1],
            ['permission_heading_id' => 10, 'type' => 'delete-lost-and-found', 'status' => 1],
            ['permission_heading_id' => 11, 'type' => 'add-committee', 'status' => 1],
            ['permission_heading_id' => 11, 'type' => 'edit-committee', 'status' => 1],
            ['permission_heading_id' => 11, 'type' => 'delete-committee', 'status' => 1],
            ['permission_heading_id' => 12, 'type' => 'add-amenities', 'status' => 1],
            ['permission_heading_id' => 12, 'type' => 'edit-amenities', 'status' => 1],
            ['permission_heading_id' => 12, 'type' => 'delete-amenities', 'status' => 1],
            ['permission_heading_id' => 13, 'type' => 'add-reports', 'status' => 1],
            ['permission_heading_id' => 13, 'type' => 'edit-reports', 'status' => 1],
            ['permission_heading_id' => 13, 'type' => 'delete-reports', 'status' => 1],
            ['permission_heading_id' => 14, 'type' => 'add-reservations', 'status' => 1],
            ['permission_heading_id' => 14, 'type' => 'edit-reservations', 'status' => 1],
            ['permission_heading_id' => 14, 'type' => 'delete-reservations', 'status' => 1],
        ];
  
        foreach ($permissions as $key => $permission) {
            Permission::create($permission);
        }
    }
}
