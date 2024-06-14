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
        Schema::table('transactions', function (Blueprint $table) {
            if (DB::getDriverName() !== 'sqlite') {
                DB::statement("ALTER TABLE transactions MODIFY COLUMN payment_provider ENUM('flutterwave', 'mollie', 'midtrans', 'paypal', 'paystack', 'razorpay', 'sslcommerz', 'stripe', 'instamojo', 'offline', 'wallet_balance') DEFAULT 'offline' NOT NULL");
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            //
        });
    }
};
