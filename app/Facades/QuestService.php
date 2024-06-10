<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static bool isNeedTimeTrack(\App\Models\Quest $quest)
 * @method static void updateTimeTrack(\App\Models\Quest $quest)
 * @method static bool startTimeProgress(\App\Models\Quest $quest)
 * @method static void endTimeProgress(\App\Models\TimeProgress $progress)
 * @method static int getTimeDiff(\Illuminate\Support\Carbon $start, \Illuminate\Support\Carbon $end)
 * @method static bool checkQuestQuantityCondition(\App\Models\Quest $quest)
 * @method static bool checkQuestTimeCondition(\App\Models\Quest $quest)
 * @method static bool canComplete(\App\Models\Quest $quest)
 * @method static bool canReward(\App\Models\Quest $quest)
 * @method static bool rewardUser(\App\Models\Quest $quest)
 * @method static bool startQuest(\Illuminate\Database\Eloquent\Model|\App\Models\Quest $quest)
 * @method static bool pauseQuest(\Illuminate\Database\Eloquent\Model|\App\Models\Quest $quest)
 * @method static bool completeQuest(\App\Models\Quest $quest)
 *
 * @see \App\Services\QuestService
 */
class QuestService extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'questservice';
    }
}
