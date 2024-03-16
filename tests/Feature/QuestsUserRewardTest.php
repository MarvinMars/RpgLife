<?php

namespace Tests\Feature;

use App\Enums\QuestStatus;
use App\Models\Quest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class QuestsUserRewardTest extends TestCase
{
	use RefreshDatabase;

    public function test_user_finish_quest(): void
    {
        $quest = Quest::factory()->create();

		$user = $quest->user;

	    $reward = $quest->xp;

		$expectedLevel = $user->calculateLevelFromXp($reward);

	    $expectedXp = $user->calculateXpAfterLevelUp($reward, $expectedLevel);

		$quest->update([
			'status' => QuestStatus::COMPLETED
		]);

		$quest->refresh();

		$this->assertEquals(QuestStatus::COMPLETED, $quest->status);

	    $this->assertTrue((boolval($quest->is_rewarded)));

		$user->refresh();

		if($expectedLevel > 0) {
			$this->assertEquals($user->level, $expectedLevel + 1);
		}

	    $this->assertEquals($user->xp, $expectedXp);
    }
}
