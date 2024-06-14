<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSubscriptionFieldsToPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('plans', function (Blueprint $table) {
            $table->float('price')->nullable()->default(0)->change();
            $table->integer('featured_duration')->default(0)->after('featured_limit');
            $table->integer('urgent_limit')->default(0)->after('featured_duration');
            $table->integer('urgent_duration')->default(0)->after('urgent_limit');
            $table->integer('highlight_limit')->default(0)->after('urgent_duration');
            $table->integer('highlight_duration')->default(0)->after('highlight_limit');
            $table->integer('top_limit')->default(0)->after('highlight_duration');
            $table->integer('top_duration')->default(0)->after('top_limit');
            $table->integer('bump_up_limit')->default(0)->after('top_duration');
            $table->integer('bump_up_duration')->default(0)->after('bump_up_limit');
            $table->boolean('premium_member')->default(false)->after('badge');
            $table->enum('plan_payment_type', ['recurring', 'one_time', 'free', 'lifetime'])->default('one_time');
            $table->string('stripe_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('plans', function (Blueprint $table) {
            $table->dropColumn([
                'featured_duration',
                'urgent_limit', 'urgent_duration',
                'highlight_limit', 'highlight_duration',
                'top_limit', 'top_duration',
                'bump_up_limit', 'bump_up_duration',
                'premium_member',
                'plan_payment_type',
                'stripe_id',
            ]);
        });
    }
}
