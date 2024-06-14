<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->boolean('per_ads_active')->default(1);
            $table->float('per_ads_price')->nullable()->default(100);
            $table->float('highlight_ads_price')->nullable()->default(50);
            $table->float('highlight_ads_duration')->nullable()->default(0);
            $table->float('featured_ads_price')->nullable()->default(50);
            $table->float('featured_ads_duration')->nullable()->default(0);
            $table->float('top_ads_price')->nullable()->default(50);
            $table->float('top_ads_duration')->nullable()->default(0);
            $table->float('bump_ads_price')->nullable()->default(50);
            $table->float('bump_ads_duration')->nullable()->default(0);
            $table->float('urgent_ads_price')->nullable()->default(50);
            $table->float('urgent_ads_duration')->nullable()->default(0);
        });

        DB::table('plans')->insert([
            ['id' => '100', 'label' => 'Pay per ads', 'ad_limit' => 0, 'featured_limit' => 0, 'badge' => '1'],
        ]);

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            //
        });
    }
};
