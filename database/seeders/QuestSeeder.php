<?php

namespace Database\Seeders;

use App\Models\Characteristic;
use App\Models\Quest;
use Illuminate\Database\Seeder;

class QuestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $characteristics = Characteristic::all();
        foreach ($characteristics as $characteristic) {
            Quest::factory(50)->hasAttached($characteristic)->create(['user_id' => 1]);
        }
    }
}
