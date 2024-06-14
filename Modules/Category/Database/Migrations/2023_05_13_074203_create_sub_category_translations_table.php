<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;
use Modules\Category\Entities\SubCategory;

class CreateSubCategoryTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_category_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(SubCategory::class)->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('locale');
            $table->timestamps();
        });

        Artisan::call('db:seed --class=SubCategoryTranslationSeeder --force');

        Schema::table('sub_categories', function (Blueprint $table) {
            $table->dropColumn('name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sub_category_translations');
        Schema::table('sub_categories', function (Blueprint $table) {
            $table->string('name');
        });
    }
}
