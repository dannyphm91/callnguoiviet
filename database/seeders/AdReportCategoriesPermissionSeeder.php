<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AdReportCategoriesPermissionSeeder extends Seeder
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
                'group_name' => 'ad_report_category',
                'permissions' => [
                    // Admin permission
                    'ad_report_category.create',
                    'ad_report_category.view',
                    'ad_report_category.edit',
                    'ad_report_category.delete',
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
