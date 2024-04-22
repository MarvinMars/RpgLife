<?php

namespace App\Observers;

use App\Models\Quest;

class QuestObserver
{
    /**
     * Handle the Quest "updated" event.
     */
    public function updated(Quest $quest): void
    {
        if ($quest->canReward()) {
            $quest->reward();
        }
    }
}
