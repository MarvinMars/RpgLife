<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LevelTest extends TestCase
{
	use RefreshDatabase;

    public function test_level_increment(): void
    {
        $user = User::factory()->create();

	    $level = $user->level;

	    $userLevel = $user->addLevel();

		$this->assertGreaterThan($level, $userLevel);
    }

	public function test_xp_update(): void
	{
		$user = User::factory()->create();

		$xp = 50;

		$userXp = $user->addXP($xp);

		$this->assertEquals($xp, $userXp);
	}

	public function test_xp_max_level(): void
	{
		$user = User::factory()->create();

		$maxXp = User::MAX_XP;

		$xp = fake()->numberBetween($maxXp, $maxXp * 3);

		$minimumLevel = $user->calculateLevelFromXp($xp);

		$level = $user->level;

		$userXp = $user->addXP($xp);

		$xpAfterUpdate = $user->calculateXpAfterLevelUp($xp, $minimumLevel);

		$this->assertEquals($xpAfterUpdate, $userXp);

		$this->assertGreaterThan($level, $minimumLevel);
	}

	public function test_xp_and_level_protect_from_update(): void
	{
		$data = [
			'name' => 'Test',
			'email' => 'test@gmail.com',
			'password' => Hash::make('password'),
			'level' => 2,
			'xp' => 10
		];

		$user = User::create($data);

		$this->assertNotEquals($user->xp, $data['xp']);
		$this->assertNotEquals($user->level, $data['level']);

		$user->update($data);

		$user->refresh();

		$this->assertNotEquals($user->xp, $data['xp']);
		$this->assertNotEquals($user->level, $data['level']);
	}
}
