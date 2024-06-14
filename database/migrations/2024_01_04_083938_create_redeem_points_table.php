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
        Schema::create('redeem_points', function (Blueprint $table) {
            $table->id();
            $table->integer('points')->default(0);
            $table->double('redeem_balance', 8, 2)->default(0);
            $table->timestamps();
        });

        // Add dummy data
        DB::table('redeem_points')->insert([
            [
                'id' => 1,
                'points' => 1200,
                'redeem_balance' => 1.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'points' => 3000,
                'redeem_balance' => 1.20,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'points' => 5000,
                'redeem_balance' => 2.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 4,
                'points' => 8000,
                'redeem_balance' => 2.50,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 5,
                'points' => 10000,
                'redeem_balance' => 5.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('redeem_points');
    }
};
