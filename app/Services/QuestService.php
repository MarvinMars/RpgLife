<?php

namespace App\Services;

use App\Enums\QuestCondition;
use App\Enums\QuestStatus;
use App\Models\Quest;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class QuestService
{
    public function isNeedTimeTrack(Quest $quest): bool
    {
        return $quest->condition === QuestCondition::Time
               && ( $quest->status === QuestStatus::PENDING || $quest->status === QuestStatus::IN_PROGRESS);
    }

    public function startTimeProgress(Quest $quest): bool
    {
        return !!$quest->progresses()->create([
            'started_at' => now(),
        ]);
    }

    public function endTimeProgress(Quest $quest): bool
    {
        $progress = $quest->progresses()->whereNull('ended_at')->get()->last();

        $progress->ended_at = now();
        $progress->total_elapsed_time += $progress->started_at->diffInSeconds($progress->ended_at);

        return $progress->save();
    }

    public function checkQuestQuantityCondition(Quest $quest): bool
    {
        $total = $quest->values()->sum('value');

        return $total >= $quest->value;
    }

    public function checkQuestTimeCondition(Quest $quest): bool
    {
        $total =  $quest->progresses()->sum('total_elapsed_time');

        return $total >= $quest->value;
    }

    public function canComplete(Quest $quest): bool
    {
        $statusCheck = $quest->status === QuestStatus::PENDING || $quest->status === QuestStatus::IN_PROGRESS;

        $conditionCheck = match ($quest->condition){
            QuestCondition::Quantity => $this->checkQuestQuantityCondition($quest),
            QuestCondition::Time => $this->checkQuestTimeCondition($quest),
            QuestCondition::Simple => true,
            'default' => false
        };

        return $statusCheck && $conditionCheck;
    }

    public function canReward(Quest $quest): bool
    {
        return $quest->status === QuestStatus::COMPLETED && ! $quest->is_rewarded;
    }

    public function rewardUser(Quest $quest): bool
    {
        $quest->user->addXP($quest->xp);
        $quest->is_rewarded = true;

        return $quest->save();
    }

    public function startQuest(Model|Quest $quest): bool
    {
        $isUpdated = $quest->update(['status' => QuestStatus::IN_PROGRESS]);

        $isTrackStart = $this->startTimeProgress($quest);

        return $isUpdated && $isTrackStart;
    }

    public function pauseQuest(Model|Quest $quest): bool
    {
        $isUpdated = $quest->update(['status' => QuestStatus::PENDING]);
        $isTrackEnd = $this->endTimeProgress($quest);
        return $isUpdated && $isTrackEnd;
    }

    public function completeQuest(Quest $quest): bool
    {
        return $quest->update([
            'status' => QuestStatus::COMPLETED,
            'completed_at' => now()
        ]);
    }
}