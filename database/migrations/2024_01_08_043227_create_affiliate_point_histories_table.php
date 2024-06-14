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
        Schema::create('affiliate_point_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->unsignedInteger('order_id')->unique();
            $table->unsignedBigInteger('points');
            $table->double('pricing', 8, 2)->default(0);
            $table->tinyInteger('status')->default(0)->comment('0=pending | 1=completed');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('affiliate_point_histories');
    }
};
