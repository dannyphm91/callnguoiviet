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
            $table->string('about_video_url')->nullable()->default('https://www.youtube.com/embed/NR0w4K96Dl8?si=hk6ZAjsc_UiEp3oc');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cms', function (Blueprint $table) {
            $table->dropColumn('about_video_url');
        });
    }
};
