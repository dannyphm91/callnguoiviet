<?php

use App\Models\AdReportCategory;
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
        Schema::create('report_ads', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('report_from_id');
            $table->unsignedBigInteger('report_to_id');
            $table->foreignIdFor(AdReportCategory::class)->constrained()->onDelete('cascade');
            $table->text('report_description');

            $table->foreign('report_from_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('report_to_id')->references('id')->on('ads')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_ads');
    }
};
