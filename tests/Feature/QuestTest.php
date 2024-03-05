<?php

namespace Tests\Feature;

use App\Models\Quest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
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
			'description' => 'Fail Quest description'
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
			    'description' => 'Test Quest description'
		    ]);

	    $response->assertStatus(200);

	    $this->assertTrue($response['created']);

	    $this->assertDatabaseHas('quests', [
		    'slug' => 'test',
		    'user_id' => $user->id
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
			'description' => 'Test Quest updated description'
		];

		$response = $this
			->actingAs($user)
			->patch(route('quests.update', $quest), $data);

		$response->assertStatus(200);

		$this->assertTrue($response['updated']);

		$data['id'] = $quest->id;

		$this->assertDatabaseHas('quests', $data);
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

		$response->assertStatus(200);

		$this->assertTrue($response['deleted']);

		$this->assertDatabaseMissing('quests', [
			'id' => $quest->id
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
}
