<?php

namespace Database\Seeders;

use App\Models\Characteristic;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::factory()->create([
            'email' => 'admin@admin.com',
            'password' => Hash::make('password'),
        ]);

        $quests = Storage::disk('public')->json('test-quests.json');

        foreach ($quests['categories'] as $data) {

            $characteristic = Characteristic::create([
                'name' => $data['category'],
                'slug' => Str::slug($data['category']),
                'user_id' => $user->id,
            ]);
            foreach ($data['quests'] as $questData) {
                $children = $questData['children'];
                $quest = $user->quests()->create(collect($questData)->except('children')->toArray());
                $quest->characteristics()->attach($characteristic->id);
                foreach ($children as $child) {
                    $child['user_id'] = $user->id;
                    $childQuest = $quest->children()->create($child);
                    $childQuest->characteristics()->attach($characteristic->id);
                }
            }
        }

    }
}
