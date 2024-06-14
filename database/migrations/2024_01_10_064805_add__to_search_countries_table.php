<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('search_countries', function (Blueprint $table) {
            $table->string('image')->nullable();
            $table->string('slug')->nullable();
            $table->string('icon')->nullable();
        });
        Artisan::call('db:seed --class=NewSearchCountrySeeder --force');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('search_countries', function (Blueprint $table) {
            //
        });
    }
};
