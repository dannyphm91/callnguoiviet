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
            $table->string('promotion_banner_title')->nullable();
            $table->longText('promotion_banner_text')->nullable();
            $table->string('promotion_banner_img')->nullable();

            $table->string('featured_title')->nullable();
            $table->longText('featured_text')->nullable();
            $table->string('featured_img')->nullable();

            $table->string('urgent_title')->nullable();
            $table->longText('urgent_text')->nullable();
            $table->string('urgent_img')->nullable();

            $table->string('highlight_title')->nullable();
            $table->longText('highlight_text')->nullable();
            $table->string('highlight_img')->nullable();

            $table->string('top_title')->nullable();
            $table->longText('top_text')->nullable();
            $table->string('top_img')->nullable();

            $table->string('bump_up_title')->nullable();
            $table->longText('bump_up_text')->nullable();
            $table->string('bump_up_img')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cms', function (Blueprint $table) {
            $table->dropColumn([
                'promotion_banner_title', 'promotion_banner_text', 'promotion_banner_img',
                'featured_title', 'featured_text', 'featured_img',
                'urgent_title', 'urgent_text', 'urgent_img',
                'highlight_title', 'highlight_text', 'highlight_img',
                'top_title', 'top_text', 'top_img',
                'bump_up_title', 'bump_up_text', 'bump_up_img',
            ]);
        });
    }
};
