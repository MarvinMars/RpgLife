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
            $table->foreignId('characteristic_id')->constrained()->cascadeOnDelete()->change();
            $table->foreignId('quest_id')->constrained()->cascadeOnDelete()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('characteristic_quest', function (Blueprint $table) {
            $table->foreignId('characteristic_id')->constrained()->change();
            $table->foreignId('quest_id')->constrained()->change();
        });
    }
};
