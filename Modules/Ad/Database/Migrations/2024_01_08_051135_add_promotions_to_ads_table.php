<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPromotionsToAdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ads', function (Blueprint $table) {
            $table->dateTime('featured_at')->nullable()->after('featured');
            $table->dateTime('featured_till')->nullable()->after('featured_at');
            $table->boolean('urgent')->default(false)->after('featured_till');
            $table->dateTime('urgent_at')->nullable()->after('urgent');
            $table->dateTime('urgent_till')->nullable()->after('urgent_at');
            $table->boolean('highlight')->default(false)->after('urgent_till');
            $table->dateTime('highlight_at')->nullable()->after('highlight');
            $table->dateTime('highlight_till')->nullable()->after('highlight_at');
            $table->boolean('top')->default(false)->after('highlight_till');
            $table->dateTime('top_at')->nullable()->after('top');
            $table->dateTime('top_till')->nullable()->after('top_at');
            $table->boolean('bump_up')->default(false)->after('top_till');
            $table->dateTime('bump_up_at')->nullable()->after('bump_up');
            $table->dateTime('bump_up_till')->nullable()->after('bump_up_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ads', function (Blueprint $table) {
            $table->dropColumn([
                'featured_at', 'featured_till',
                'urgent', 'urgent_at', 'urgent_till',
                'highlight', 'highlight_at', 'highlight_till',
                'top', 'top_at', 'top_till',
                'bump_up', 'bump_up_at', 'bump_up_till',
            ]);
        });
    }
}
