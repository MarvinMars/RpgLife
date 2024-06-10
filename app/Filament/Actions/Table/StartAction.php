<?php

namespace App\Filament\Actions\Table;

use App\Enums\QuestCondition;
use App\Enums\QuestStatus;
use App\Facades\QuestService;
use Filament\Tables\Actions\Action;
use Illuminate\Database\Eloquent\Model;

class StartAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'start';
    }
    protected function setUp(): void
    {
        parent::setUp();

        $this->icon("heroicon-o-play");
        $this->hiddenLabel();
        $this->outlined();
        $this->button();
        $this->successNotificationTitle('Quest in progress');
        $this->visible(static function (Model $record): bool {
            return $record->condition === QuestCondition::Time
                   && $record->status === QuestStatus::PENDING;
        });

        $this->action(fn (Model $record): string => QuestService::startQuest($record));
    }
}