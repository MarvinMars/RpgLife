<?php

namespace Tests\Feature\Characteristic;

use App\Models\Characteristic;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CharacteristicTest extends TestCase
{
	use RefreshDatabase;

	/**
	 * Check auth protection for create characteristic
	 */
	public function test_characteristic_auth_guard(): void
	{
		$response = $this
			->get('/characteristics');

		$response->assertRedirectToRoute('login');

		$data = [
			'name' => 'Fail characteristic name',
			'slug' => 'fail-test',
			'description' => 'Fail characteristic description'
		];

		$response = $this
			->post(route('characteristics.store'), $data);

		$response->assertRedirectToRoute('login');

		$characteristic = Characteristic::factory()->create();

		$response = $this
			->patch(route('characteristics.update', $characteristic), $data);

		$response->assertRedirectToRoute('login');

		$response = $this
			->delete(route('characteristics.destroy', $characteristic));

		$response->assertRedirectToRoute('login');

		$user2 = User::factory()->create();

		$response = $this
			->actingAs($user2)
			->get(route('characteristics.show', $characteristic));

		$response->assertStatus(403);

		$response = $this
			->actingAs($user2)
			->get(route('characteristics.edit', $characteristic));

		$response->assertStatus(403);

		$response = $this
			->actingAs($user2)
			->patch(route('characteristics.update', $characteristic), $data);

		$response->assertStatus(403);

		$response = $this
			->actingAs($user2)
			->delete(route('characteristics.destroy', $characteristic));

		$response->assertStatus(403);
	}

	/**
	 * characteristic create
	 */
	public function test_characteristic_create(): void
	{
		$user = User::factory()->create();

		$response = $this
			->actingAs($user)
			->post(route('characteristics.store'), [
				'name' => 'Test characteristic name',
				'slug' => 'test',
				'description' => 'Test characteristic description'
			]);

		$characteristic = $user->characteristics()->where('slug', 'test')->first();

		$response->assertRedirectToRoute('characteristics.show', $characteristic);

		$this->assertDatabaseHas('characteristics', [
			'slug' => 'test',
			'user_id' => $user->id
		]);
	}

	/**
	 * characteristic update
	 */
	public function test_characteristic_update(): void
	{
		$characteristic = Characteristic::factory()->create();

		$user = $characteristic->user;

		$data = [
			'name' => 'Test updated characteristic',
			'slug' => 'test-updated',
			'description' => 'Test characteristic updated description'
		];

		$response = $this
			->actingAs($user)
			->patch(route('characteristics.update', $characteristic), $data);

		$response->assertRedirectToRoute('characteristics.edit', $characteristic);

		$data['id'] = $characteristic->id;

		$this->assertDatabaseHas('characteristics', $data);
	}

	/**
	 * characteristic delete
	 */
	public function test_characteristic_delete(): void
	{
		$characteristic = Characteristic::factory()->create();

		$user = $characteristic->user;

		$response = $this
			->actingAs($user)
			->delete(route('characteristics.destroy', $characteristic));

		$response->assertRedirectToRoute('characteristics.index');

		$this->assertDatabaseMissing('characteristics', [
			'id' => $characteristic->id
		]);
	}

	/**
	 * characteristic pages displayed
	 */
	public function test_characteristic_pages_displayed(): void
	{
		$user = User::factory()->create();

		$response = $this
			->actingAs($user)
			->get(route('characteristics.index'));

		$response->assertStatus(200);

		$response = $this
			->actingAs($user)
			->get(route('characteristics.create'));

		$response->assertStatus(200);

		$characteristic = Characteristic::factory()->create();

		$user = $characteristic->user;

		$response = $this
			->actingAs($user)
			->get(route('characteristics.show', $characteristic));

		$response->assertStatus(200);

		$response = $this
			->actingAs($user)
			->get(route('characteristics.edit', $characteristic));

		$response->assertStatus(200);
	}
}
