<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AdvertisementPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //  Create roles
        $roleAdmin = Role::where('name', 'superadmin')->first();

        //  permission List as array
        $permissions = [
            [
                'group_name' => 'Advertisement',
                'permissions' => [
                    // Admin permission
                    'advertisement.index',
                    'advertisement.create',
                    'advertisement.store',
                    'advertisement.edit',
                    'advertisement.update',
                    'advertisement.delete',
                ],
            ],
        ];

        // Assign Permission
        for ($i = 0; $i < count($permissions); $i++) {
            $permissionGroup = $permissions[$i]['group_name'];

            for ($j = 0; $j < count($permissions[$i]['permissions']); $j++) {
                // Create Permission
                $permission = Permission::create(['name' => $permissions[$i]['permissions'][$j], 'group_name' => $permissionGroup, 'guard_name' => 'admin']);
                $roleAdmin->givePermissionTo($permission);
                //  $permission->assignRole($roleAdmin);
            }
        }
    }
}
