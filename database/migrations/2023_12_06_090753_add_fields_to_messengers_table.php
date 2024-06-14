<?php

use App\Models\MessengerUser;
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
        Schema::table('messengers', function (Blueprint $table) {
            $table->foreignIdFor(MessengerUser::class)->nullable()->constrained()->cascadeOnDelete();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('messengers', function (Blueprint $table) {
            $table->dropForeign(['messenger_user_id']);
            $table->dropColumn('messenger_user_id');
            $table->dropSoftDeletes();
        });
    }
};
