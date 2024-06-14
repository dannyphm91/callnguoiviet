<?php

use Database\Seeders\AdvertisementSeeder;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Artisan;

class StoreAdvertisementContentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->storeAdvertisementContent();
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

    public function storeAdvertisementContent()
    {
        Artisan::call('db:seed', [
            '--class' => AdvertisementSeeder::class,
        ]);
    }
}
