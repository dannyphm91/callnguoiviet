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
        Schema::table('cms_contents', function (Blueprint $table) {
            $table->string('title')->nullable()->after('text');

            $table->string('title_featured')->nullable()->after('title');
            $table->longText('text_featured')->nullable()->after('title_featured');

            $table->string('title_urgent')->nullable()->after('text_featured');
            $table->longText('text_urgent')->nullable()->after('title_urgent');

            $table->string('title_highlight')->nullable()->after('text_urgent');
            $table->longText('text_highlight')->nullable()->after('title_highlight');

            $table->string('title_top')->nullable()->after('text_highlight');
            $table->longText('text_top')->nullable()->after('title_top');

            $table->string('title_bump_up')->nullable()->after('text_top');
            $table->longText('text_bump_up')->nullable()->after('title_bump_up');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cms_contents', function (Blueprint $table) {
            $table->dropColumn([
                'title',
                'title_featured', 'text_featured',
                'title_urgent', 'text_urgent',
                'title_highlight', 'text_highlight',
                'title_top', 'text_top',
                'title_bump_up', 'text_bump_up',
            ]);
        });
    }
};
