<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn(['free_ad_limit', 'free_featured_ad_limit', 'subscription_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->integer('free_ad_limit')->default(5)->after('body_script');
            $table->integer('free_featured_ad_limit')->default(3)->after('body_script');
            $table->enum('subscription_type', ['one_time', 'recurring'])->default('one_time')->after('maximum_ad_image_limit');
        });
    }
};
