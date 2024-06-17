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
        Schema::table('characteristic_quest', function (Blueprint $table) {
            $table->dropForeign(['characteristic_id']);
            $table->dropForeign(['quest_id']);

            $table->unsignedBigInteger('characteristic_id')->nullable()->change();
            $table->unsignedBigInteger('quest_id')->nullable()->change();

            $table->foreign('characteristic_id')->references('id')->on('characteristics')->cascadeOnDelete();
            $table->foreign('quest_id')->references('id')->on('quests')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('characteristic_quest', function (Blueprint $table) {
            $table->dropForeign(['characteristic_id']);
            $table->dropForeign(['quest_id']);

            $table->unsignedBigInteger('characteristic_id')->nullable(false)->change();
            $table->unsignedBigInteger('quest_id')->nullable(false)->change();

            $table->foreign('characteristic_id')->references('id')->on('characteristics');
            $table->foreign('quest_id')->references('id')->on('quests');
        });
    }
};
