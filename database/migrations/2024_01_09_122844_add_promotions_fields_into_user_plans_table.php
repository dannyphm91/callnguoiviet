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
        Schema::table('user_plans', function (Blueprint $table) {
            $table->integer('urgent_limit')->default(0)->after('featured_limit');
            $table->integer('highlight_limit')->default(0)->after('urgent_limit');
            $table->integer('top_limit')->default(0)->after('highlight_limit');
            $table->integer('bump_up_limit')->default(0)->after('top_limit');
            $table->boolean('premium_member')->default(false)->after('bump_up_limit');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_plans', function (Blueprint $table) {
            $table->dropColumn([
                'urgent_limit',
                'highlight_limit',
                'top_limit',
                'bump_up_limit',
                'premium_member',
            ]);
        });
    }
};
