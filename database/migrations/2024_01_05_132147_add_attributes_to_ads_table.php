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
        Schema::table('ads', function (Blueprint $table) {
            $table->text('comment')->nullable();
            $table->boolean('resubmission')->default(false);
            $table->timestamp('resubmission_time')->nullable();
            $table->timestamp('customer_edit_time')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ads', function (Blueprint $table) {
            $table->dropColumn(['comment', 'resubmission', 'resubmission_time', 'customer_edit_time']);
        });
    }
};
