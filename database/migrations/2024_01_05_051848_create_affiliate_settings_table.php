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
        Schema::create('affiliate_settings', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('affiliate_feature')->default(1)->comment('1 = on | 2 = off');
            $table->unsignedInteger('invite_points')->default(0);
            $table->tinyInteger('point_convert_permission')->default(0)->comment('1 = direct convertion | 2 = admin Approval convertion');
            $table->timestamps();
        });

        // Add dummy data
        DB::table('affiliate_settings')->insert(
            [
                'id' => 1,
                'affiliate_feature' => 1,
                'invite_points' => 5,
                'point_convert_permission' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],

        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('affiliate_settings');
    }
};
