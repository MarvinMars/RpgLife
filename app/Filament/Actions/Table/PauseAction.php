<?php

namespace App\Filament\Actions\Table;

use App\Enums\QuestCondition;
use App\Enums\QuestStatus;
use App\Facades\QuestService;
use Filament\Tables\Actions\Action;
use Illuminate\Database\Eloquent\Model;

class PauseAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'pause';
    }
    protected function setUp(): void
    {
        parent::setUp();

        $this->icon("heroicon-o-pause");
        $this->hiddenLabel();
        $this->outlined();
        $this->button();
        $this->successNotificationTitle('Quest paused');
        $this->visible(static function (Model $record): bool {
            return $record->condition === QuestCondition::Time
                   && $record->status === QuestStatus::IN_PROGRESS;
        });

        $this->action(fn (Model $record): string => QuestService::pauseQuest($record));
    }
}