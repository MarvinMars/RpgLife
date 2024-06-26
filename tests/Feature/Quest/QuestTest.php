<?php

namespace Tests\Feature\Quest;

use App\Enums\QuestStatus;
use App\Models\Quest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class QuestTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Check auth protection for create quest
     */
    public function test_quest_auth_guard(): void
    {
        $response = $this
            ->get('/quests');

        $response->assertRedirectToRoute('login');

        $data = [
            'name' => 'Fail Quest name',
            'slug' => 'fail-test',
            'description' => 'Fail Quest description',
        ];

        $response = $this
            ->post(route('quests.store'), $data);

        $response->assertRedirectToRoute('login');

        $quest = Quest::factory()->create();

        $response = $this
            ->patch(route('quests.update', $quest), $data);

        $response->assertRedirectToRoute('login');

        $response = $this
            ->delete(route('quests.destroy', $quest));

        $response->assertRedirectToRoute('login');

        $user2 = User::factory()->create();

        $response = $this
            ->actingAs($user2)
            ->get(route('quests.show', $quest));

        $response->assertStatus(403);

        $response = $this
            ->actingAs($user2)
            ->get(route('quests.edit', $quest));

        $response->assertStatus(403);

        $response = $this
            ->actingAs($user2)
            ->patch(route('quests.update', $quest), $data);

        $response->assertStatus(403);

        $response = $this
            ->actingAs($user2)
            ->delete(route('quests.destroy', $quest));

        $response->assertStatus(403);
    }

    /**
     * Quest create
     */
    public function test_quest_create(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->post(route('quests.store'), [
                'name' => 'Test Quest name',
                'slug' => 'test',
                'description' => 'Test Quest description',
            ]);

        $quest = $user->quests()->where('slug', 'test')->first();

        $response->assertRedirectToRoute('quests.show', $quest);

        $this->assertDatabaseHas('quests', [
            'slug' => 'test',
            'user_id' => $user->id,
        ]);
    }

    /**
     * Quest update
     */
    public function test_quest_update(): void
    {
        $quest = Quest::factory()->create();

        $user = $quest->user;

        $data = [
            'name' => 'Test updated Quest',
            'slug' => 'test-updated',
            'description' => 'Test Quest updated description',
        ];

        $response = $this
            ->actingAs($user)
            ->patch(route('quests.update', $quest), $data);

        $response->assertRedirectToRoute('quests.edit', $quest);

        $data['id'] = $quest->id;

        $this->assertDatabaseHas('quests', $data);
    }

    /**
     * Quest update
     */
    public function test_quest_update_status(): void
    {
        foreach (QuestStatus::cases() as $shape) {
            $quest = Quest::factory()->create();

            $user = $quest->user;

            $response = $this
                ->actingAs($user)
                ->patch(route('quests.update.status', $quest), ['status' => $shape->value]);

            $response->assertOk();

            $this->assertDatabaseHas('quests', [
                'id' => $quest->id,
                'status' => $shape->value,
            ]);
        }
    }

    /**
     * Quest delete
     */
    public function test_quest_delete(): void
    {
        $quest = Quest::factory()->create();

        $user = $quest->user;

        $response = $this
            ->actingAs($user)
            ->delete(route('quests.destroy', $quest));

        $response->assertRedirectToRoute('quests.index');

        $this->assertDatabaseMissing('quests', [
            'id' => $quest->id,
        ]);
    }

    /**
     * Quest pages displayed
     */
    public function test_quest_pages_displayed(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->get(route('quests.index'));

        $response->assertStatus(200);

        $response = $this
            ->actingAs($user)
            ->get(route('quests.create'));

        $response->assertStatus(200);

        $quest = Quest::factory()->create();

        $user = $quest->user;

        $response = $this
            ->actingAs($user)
            ->get(route('quests.show', $quest));

        $response->assertStatus(200);

        $response = $this
            ->actingAs($user)
            ->get(route('quests.edit', $quest));

        $response->assertStatus(200);
    }

    public function test_user_can_create_child_quest()
    {
        $parentQuest = Quest::factory()->create();

        $data = [
            'name' => 'Child Quest',
            'slug' => 'child',
            'description' => 'Description of Child Quest',
            'xp' => 80,
            'parent_id' => $parentQuest->id,
        ];

        $response = $this
            ->actingAs($parentQuest->user)
            ->post(route('quests.store'), $data);

        $response->assertStatus(302);
        $this->assertDatabaseHas('quests', $data);
    }

    public function test_user_can_update_child_quest()
    {
        $parentQuest = Quest::factory()->create();

        $childQuest = Quest::factory()->create([
            'user_id' => $parentQuest->user->id,
            'parent_id' => $parentQuest->id,
        ]);

        $data = [
            'id' => $childQuest->id,
            'slug' => $childQuest->slug,
            'name' => 'Child Quest Updated',
            'description' => 'Description of Child Quest Updated',
            'xp' => 80,
        ];

        $response = $this
            ->actingAs($parentQuest->user)
            ->patch(route('quests.update', $childQuest), $data);

        $response->assertStatus(302);
        $this->assertDatabaseHas('quests', $data);
    }

    public function test_user_can_delete_child_quest()
    {
        $parentQuest = Quest::factory()->create();

        $childQuest = Quest::factory()->create([
            'user_id' => $parentQuest->user->id,
            'parent_id' => $parentQuest->id,
        ]);

        $response = $this
            ->actingAs($childQuest->user)
            ->delete(route('quests.destroy', $childQuest));

        $response->assertStatus(302);

        $this->assertDatabaseMissing('quests', [
            'id' => $childQuest->id,
        ]);
    }

    public function test_user_can_delete_with_children_quest()
    {
        $parentQuest = Quest::factory()->create();

        $childQuest = Quest::factory()
            ->create(['parent_id' => $parentQuest->id]);

        $response = $this
            ->actingAs($parentQuest->user)
            ->delete(route('quests.destroy', $parentQuest));

        $response->assertStatus(302);

        $this->assertDatabaseMissing('quests', [
            'id' => $parentQuest->id,
        ]);

        $this->assertDatabaseMissing('quests', [
            'id' => $childQuest->id,
        ]);
    }
}
