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
        Schema::table('cms', function (Blueprint $table) {
            $table->dropColumn([
                'about_background',
                'home_main_banner',
                'home_counter_background',
                'home_mobile_app_banner',
                'home_title',
                'home_description',
                'download_app',
                'newsletter_content',
                'membership_content',
                'create_account',
                'post_ads',
                'start_earning',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cms', function (Blueprint $table) {
            $table->string('about_background')->nullable();
            $table->string('home_main_banner')->nullable();
            $table->string('home_counter_background')->nullable();
            $table->string('home_mobile_app_banner')->nullable();
            $table->string('home_title')->nullable();
            $table->string('home_description')->nullable();
            $table->string('download_app')->nullable();
            $table->string('newsletter_content')->nullable();
            $table->string('membership_content')->nullable();
            $table->string('create_account')->nullable();
            $table->string('post_ads')->nullable();
            $table->string('start_earning')->nullable();
        });
    }
};
