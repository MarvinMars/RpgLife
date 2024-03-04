<?php

namespace Tests\Feature;

use App\Models\Quest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class QuestTest extends TestCase
{

	/**
	 * Check auth protection for create quest
	 */
	public function test_quest_auth_guard(): void
	{
		$response = $this
			->get('/quests');

		$response->assertStatus(401);

		$data = [
			'name' => 'Fail Quest name',
			'slug' => 'fail-test',
			'description' => 'Fail Quest description'
		];

		$response = $this
			->post('/quests', $data);

		$response->assertStatus(401);

		$user = User::factory()->create();

		$quest = Quest::factory()->create($user);

		$response = $this
			->patch('/quests/' . $quest->id, $data);

		$response->assertStatus(401);

		$response = $this
			->delete('/quests/'. $quest->id);

		$response->assertStatus(401);

		$user2 = User::factory()->create();

		$response = $this
			->actingAs($user2)
			->patch('/quests/' . $quest->id, $data);

		$response->assertStatus(401);

		$response = $this
			->actingAs($user2)
			->delete('/quests/'. $quest->id);

		$response->assertStatus(401);
	}

    /**
     * Quest create
     */
    public function test_quest_create(): void
    {
	    $user = User::factory()->create();

	    $response = $this
		    ->actingAs($user)
		    ->post('/quests', [
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
		$user = User::factory()->create();

		$quest = Quest::factory()->create($user);

		$data = [
			'name' => 'Test updated Quest',
			'slug' => 'test-updated',
			'description' => 'Test Quest updated description'
		];

		$response = $this
			->actingAs($user)
			->patch('/quests/' . $quest->id, $data);

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
		$user = User::factory()->create();
		$quest = Quest::factory()->create($user);

		$response = $this
			->actingAs($user)
			->delete('/quests/'. $quest->id);

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
			->get('/quests');

		$response->assertStatus(200);

		$response = $this
			->actingAs($user)
			->get('/quests/create');

		$response->assertStatus(200);

		$quest = Quest::factory()->create($user);

		$response = $this
			->actingAs($user)
			->get('/quests/' . $quest->id);

		$response->assertStatus(200);

		$response = $this
			->actingAs($user)
			->get('/quests/'. $quest->id . '/edit');

		$response->assertStatus(200);
	}
}
