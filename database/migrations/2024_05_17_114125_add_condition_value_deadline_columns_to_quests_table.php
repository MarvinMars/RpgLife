<?php

use App\Enums\QuestCondition;
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
        Schema::table('quests', function (Blueprint $table) {
            $table->string('condition')->default(QuestCondition::Simple->value)->after('status');
            $table->integer('value')->nullable()->after('xp');
            $table->dateTime('deadline')->nullable()->after('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('quests', function (Blueprint $table) {
            $table->dropColumn(['condition', 'value', 'deadline']);
        });
    }
};
