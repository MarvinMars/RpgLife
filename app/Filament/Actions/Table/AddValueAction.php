<?php

namespace App\Filament\Actions\Table;

use App\Enums\QuestCondition;
use App\Enums\QuestStatus;
use App\Facades\QuestService;
use App\Models\Quest;
use Filament\Forms\Components\TextInput;
use Filament\Support\Colors\Color;
use Filament\Support\Colors\ColorManager;
use Filament\Tables\Actions\Action;
use Illuminate\Database\Eloquent\Model;

class AddValueAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'addValue';
    }
    protected function setUp(): void
    {
        parent::setUp();

        $this->icon("heroicon-o-plus");
        $this->hiddenLabel();
        $this->outlined();
        $this->button();
        $this->successNotificationTitle('Value added successfully!');
        $this->form([
            TextInput::make('value')->type('decimal')
                                    ->required()
                                    ->default(1)
        ]);
        $this->visible(static function (Model $record): bool {
            return $record->condition === QuestCondition::Quantity
                   && $record->status === QuestStatus::PENDING;
        });

        $this->action(function (array $data, Quest $record): void {
            $record->values()->create(['value' => $data['value']]);
        });

    }
}