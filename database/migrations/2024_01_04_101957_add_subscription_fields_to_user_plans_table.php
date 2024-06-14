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
        Schema::table('user_plans', function (Blueprint $table) {
            if (DB::getDriverName() !== 'sqlite') {
                DB::statement("ALTER TABLE user_plans MODIFY COLUMN subscription_type ENUM('one_time','recurring','free','declined','lifetime') DEFAULT 'one_time' NOT NULL");
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_plans', function (Blueprint $table) {
            $table->dropColumn(['ends_at']);
        });
    }
};
