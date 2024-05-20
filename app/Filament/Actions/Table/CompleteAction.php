<?php

namespace App\Filament\Actions\Table;

use App\Enums\QuestCondition;
use App\Enums\QuestStatus;
use App\Facades\QuestService;
use App\Models\Quest;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\ActionSize;
use Filament\Tables\Actions\Action;
use Illuminate\Database\Eloquent\Model;

class CompleteAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'complete';
    }
    protected function setUp(): void
    {
        parent::setUp();

        $this->icon("heroicon-o-check");
        $this->hiddenLabel();
        $this->outlined();
        $this->button();
        $this->successNotificationTitle('Quest completed');
        $this->visible(static fn (Model $record): bool => QuestService::canComplete($record));
        $this->action(fn (Model $record): string => QuestService::completeQuest($record));
    }
}