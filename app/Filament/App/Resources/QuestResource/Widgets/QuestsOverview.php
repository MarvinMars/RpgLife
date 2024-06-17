<?php

namespace App\Filament\App\Resources\QuestResource\Widgets;

use App\Enums\QuestCondition;
use App\Enums\QuestStatus;
use App\Filament\App\Resources\QuestResource;
use App\Models\Characteristic;
use App\Models\Quest;
use App\Tables\Columns\ProgressBar;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Actions\ReplicateAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class QuestsOverview extends BaseWidget
{
    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(QuestResource::getEloquentQuery()->withoutGlobalScope('customer')
                                                     ->where('is_public', true)
                                                     ->where('user_id', '!=', auth()->id())
            )
            ->filters([
                SelectFilter::make('characteristics')
                            ->multiple()
                            ->relationship('characteristics', 'name')
                            ->options(Characteristic::all()->pluck('name', 'id'))
                            ->preload(),
                SelectFilter::make('condition')
                            ->options(QuestCondition::options())
            ], layout: FiltersLayout::Modal)
            ->columns([
                TextColumn::make('name')
                          ->description(fn (Quest $record): string => $record->description ?? ''),
                ImageColumn::make('image')->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('xp'),
                TextColumn::make('characteristics')
                          ->badge()
                          ->formatStateUsing(fn ($state): string => $state->name)
                          ->color(fn (Characteristic $characteristic) => $characteristic->color),
            ])->actions([
                ViewAction::make()->slideOver(),
                ReplicateAction::make()->form(fn (Form $form) => QuestResource::form($form))->slideOver()
                ->beforeReplicaSaved(function (Model $replica): void {
                    $replica->user_id = auth()->id();
                    $replica->slug = Str::uuid() . '-' .  $replica->slug;
                    $replica->status = QuestStatus::PENDING;
                    $replica->is_public = false;
                })
            ]);
    }
}
