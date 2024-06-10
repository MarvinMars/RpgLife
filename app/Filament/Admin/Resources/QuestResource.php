<?php

namespace App\Filament\Admin\Resources;

use App\Enums\QuestCondition;
use App\Enums\QuestStatus;
use App\Filament\Actions\Table\AddValueAction;
use App\Filament\Actions\Table\CompleteAction;
use App\Filament\Actions\Table\PauseAction;
use App\Filament\Actions\Table\StartAction;
use App\Filament\Resources\QuestResource\Pages;
use App\Models\Characteristic;
use App\Models\Quest;
use App\Tables\Columns\ProgressBar;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class QuestResource extends Resource
{
    protected static ?string $model = Quest::class;

    public Quest $quest;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->live(debounce: 1000)
                    ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state)))
                    ->columnSpan(2),
                TextInput::make('slug')->unique(ignoreRecord: true)->columnSpan(2),
                TextInput::make('xp')->default(0)->type('number')->columnSpan(1),
                Toggle::make('is_public')->inline(false)->columnSpan(1),
                Textarea::make('description')->rows(10)->columnSpan('full'),
                Select::make('parent_id')
                    ->relationship(name: 'parent', titleAttribute: 'name', ignoreRecord: true)
                    ->options(Quest::all()->pluck('name', 'id'))
                    ->label('Parent')
                    ->columnSpan(2),
                Select::make('characteristics')
                    ->multiple()
                    ->relationship(titleAttribute: 'name')
                    ->options(Characteristic::all()->pluck('name', 'id'))->columnSpan(2),
                Fieldset::make('Complete condition')
                        ->schema([
                            Select::make('condition')
                                  ->label('Type')
                                  ->options(QuestCondition::options())
                                  ->default(QuestCondition::Simple->value)
                                  ->enum(QuestCondition::class)
                                  ->live()
                                  ->columnSpan(1),
                            TimePicker::make('value')
                                      ->label('Time for complete')
                                      ->visible(function (Get $get) {
                                          return $get('condition') === QuestCondition::Time->value;
                                      })
                                      ->columnSpan(1),
                            TextInput::make('value')
                                     ->label('Count for complete')
                                     ->default(0)
                                     ->type('number')
                                     ->visible(function (Get $get) {
                                         return $get('condition') === QuestCondition::Quantity->value;
                                     })
                                     ->columnSpan(1),
                        ])->columns(2),
                FileUpload::make('image')->columnSpan('full'),
                Repeater::make('reminders')
                    ->relationship()
                    ->simple(
                        DateTimePicker::make('datetime')->native(false)->seconds(false)->required()
                    )
                    ->defaultItems(0)
                    ->columnSpan('full'),
            ])->columns(6);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name'),
                ImageColumn::make('image'),
                TextColumn::make('xp'),
                ProgressBar::make('value')
                           ->label('Progress')
                           ->disabled(fn (Quest $quest) => $quest->condition === QuestCondition::Simple)
                           ->maxValue(fn (Quest $quest) => $quest->value )
                           ->value(fn (Quest $quest) => match ($quest->condition) {
                               QuestCondition::Time => $quest->progresses->sum('total_elapsed_time'),
                               QuestCondition::Quantity => $quest->values->sum('value')
                            }),
                IconColumn::make('is_public')->boolean()->alignCenter(),
                TextColumn::make('status')->badge(),
            ])
            ->filters([
                //
            ])
            ->actions([
                AddValueAction::make(),
                CompleteAction::make(),
                StartAction::make(),
                PauseAction::make(),
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),
                    DeleteAction::make(),
                ])
            ])->actionsPosition()
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => \App\Filament\Admin\Resources\QuestResource\Pages\ListQuests::route('/'),
            'create' => \App\Filament\Admin\Resources\QuestResource\Pages\CreateQuest::route('/create'),
            'view' => \App\Filament\Admin\Resources\QuestResource\Pages\ViewQuest::route('/{record}'),
            'edit' => \App\Filament\Admin\Resources\QuestResource\Pages\EditQuest::route('/{record}/edit'),
        ];
    }
}
