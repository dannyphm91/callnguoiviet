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
            $table->string('ads_safety_msg')->nullable()->default('Never prepay for deliveries. Physically inspect goods and sellers before payment. Templatecookie connects buyers and sellers, not responsible for transactions.');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cms', function (Blueprint $table) {
            //
        });
    }
};
