<?php

use Database\Seeders\CustomerVerificationPermissionSeeder;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class SeedCustomerVerificationSeederTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Counting super admin role table rows
        $role_count = DB::table('roles')->count();
        if ($role_count == 0) {
            $this->callPermissionSeeder();
        }

        $this->createOrderPermission();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }

    public function callPermissionSeeder()
    {
        Artisan::call('db:seed', [
            '--class' => RolePermissionSeeder::class,
        ]);
    }

    public function createOrderPermission()
    {
        Artisan::call('db:seed', [
            '--class' => CustomerVerificationPermissionSeeder::class,
        ]);
    }
}
