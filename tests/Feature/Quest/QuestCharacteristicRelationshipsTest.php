<?php

namespace Tests\Feature\Quest;

use App\Models\Characteristic;
use App\Models\Quest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class QuestCharacteristicRelationshipsTest extends TestCase
{
    use RefreshDatabase;

    public function test_characteristic_attach_to_quest_after_creation(): void
    {
        $user = User::factory()->create();
        $charFirst = Characteristic::factory()->create();
        $charSecond = Characteristic::factory()->create();

       $this->actingAs($user)
            ->post(route('quests.store'), [
                'name' => 'Test Quest name',
                'slug' => 'test',
                'description' => 'Test Quest description',
                'characteristics' => [$charFirst->id, $charSecond->id],
            ]);

        $quest = $user->quests()->where('slug', 'test')->first();

        $this->assertDatabaseHas('quest_characteristic', [
            'characteristic_id' => $charFirst->id,
            'quest_id' => $quest->id,
        ]);

        $this->assertDatabaseHas('quest_characteristic', [
            'characteristic_id' => $charSecond->id,
            'quest_id' => $quest->id,
        ]);
    }

    public function test_characteristic_attach_to_quest_after_update(): void
    {
        $user = User::factory()->create();
        $charFirst = Characteristic::factory()->create();
        $charSecond = Characteristic::factory()->create();
        $quest = Quest::factory()->create();

        $this->actingAs($user)
             ->patch(route('quests.update'), [
                 'name' => 'Test Quest name',
                 'characteristics' => [$charFirst->id, $charSecond->id],
             ]);

        $this->assertDatabaseHas('quest_characteristic', [
            'characteristic_id' => $charFirst->id,
            'quest_id' => $quest->id,
        ]);

        $this->assertDatabaseHas('quest_characteristic', [
            'characteristic_id' => $charSecond->id,
            'quest_id' => $quest->id,
        ]);
    }

    public function test_characteristic_detach_from_quest_after_update(): void
    {
        $user = User::factory()->create();
        $charFirst = Characteristic::factory()->create();
        $charSecond = Characteristic::factory()->create();
        $quest = Quest::factory()->create();
        $quest->characteristics()->attach([$charFirst->id, $charSecond->id]);

        $this->actingAs($user)
            ->patch(route('quests.update'), [
                'name' => 'Test Quest name',
                'characteristics' => [],
            ]);

        $this->assertDatabaseMissing('quest_characteristic', [
            'characteristic_id' => $charFirst->id,
            'quest_id' => $quest->id,
        ]);

        $this->assertDatabaseMissing('quest_characteristic', [
            'characteristic_id' => $charSecond->id,
            'quest_id' => $quest->id,
        ]);
    }
}
