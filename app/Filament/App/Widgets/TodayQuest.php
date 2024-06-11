<?php

namespace App\Filament\App\Widgets;

use App\Enums\QuestCondition;
use App\Enums\QuestStatus;
use App\Filament\Actions\Table\AddValueAction;
use App\Filament\Actions\Table\CompleteAction;
use App\Filament\Actions\Table\PauseAction;
use App\Filament\Actions\Table\StartAction;
use App\Filament\App\Resources\QuestResource;
use App\Models\Characteristic;
use App\Models\Quest;
use App\Tables\Columns\ProgressBar;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class TodayQuest extends BaseWidget
{
    use InteractsWithPageFilters;

    protected static ?int $sort = 3;

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        $startDate = $this->filters['startDate'] ?? null;
        $endDate = $this->filters['endDate'] ?? null;

        return $table
            ->query(QuestResource::getEloquentQuery()
                ->whereIn('status', [
                    QuestStatus::PENDING->value,
                    QuestStatus::IN_PROGRESS->value,
                ])
                ->when($startDate, fn (Builder $query) => $query->whereDate('created_at', '>=', $startDate))
                ->when($endDate, fn (Builder $query) => $query->whereDate('created_at', '<=', $endDate))
            )
            ->columns([
                TextColumn::make('name')
                    ->description(fn (Quest $record): string => $record->description ?? ''),
                ImageColumn::make('image')->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('xp'),
                TextColumn::make('characteristics')
                    ->badge()
                    ->formatStateUsing(fn ($state): string => $state->name)
                    ->color(fn (Characteristic $characteristic) => $characteristic->color),
                ProgressBar::make('value')
                    ->toggleable()
                    ->label('Progress')
                    ->disabled(fn (Quest $quest) => $quest->condition === QuestCondition::Simple)
                    ->maxValue(fn (Quest $quest) => $quest->value)
                    ->value(fn (Quest $quest) => match ($quest->condition) {
                        QuestCondition::Time => $quest->progresses->sum('total_elapsed_time'),
                        QuestCondition::Quantity => $quest->values->sum('value')
                    }),
            ])
            ->actions([
                AddValueAction::make(),
                CompleteAction::make(),
                StartAction::make(),
                PauseAction::make(),
            ]);
    }
}
