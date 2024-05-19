<?php

namespace App\Observers;

use App\Facades\QuestService;
use App\Models\Quest;

class QuestObserver
{
    /**
     * Handle the Quest "updated" event.
     */
    public function updated(Quest $quest): void
    {
        if (QuestService::canReward($quest)) {
            QuestService::rewardUser($quest);
        }
    }
}
