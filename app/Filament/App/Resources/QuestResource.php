<?php

namespace App\Filament\App\Resources;

use App\Enums\QuestCondition;
use App\Filament\Actions\Table\AddValueAction;
use App\Filament\Actions\Table\CompleteAction;
use App\Filament\Actions\Table\PauseAction;
use App\Filament\Actions\Table\StartAction;
use App\Filament\App\Resources\QuestResource\Pages;
use App\Models\Characteristic;
use App\Models\Quest;
use App\Tables\Columns\ProgressBar;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class QuestResource extends Resource
{
    protected static ?string $model = Quest::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Base')
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->live(debounce: 1000)
                            ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state)))
                            ->columnSpan(2),
                        TextInput::make('xp')->default(0)->type('number')->columnSpan(1),
                        Select::make('characteristics')
                            ->multiple()
                            ->relationship(titleAttribute: 'name')
                            ->options(Characteristic::all()->pluck('name', 'id'))->columnSpanFull(),
                    ])
                    ->columns(3),
                Section::make('Content')
                    ->schema([
                        FileUpload::make('image'),
                        Textarea::make('description')->rows(10),
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
                            ]),
                    ])
                    ->collapsed(),
                Section::make('Etc')
                    ->schema([
                        TextInput::make('slug')->unique(ignoreRecord: true)->columnSpan(2),
                        Select::make('parent_id')
                            ->relationship(name: 'parent', titleAttribute: 'name', ignoreRecord: true)
                            ->searchable()
                            ->getOptionLabelUsing(fn ($value): ?string => Quest::find($value)?->name)
                            ->label('Parent')
                            ->columnSpan(1),

                        Repeater::make('reminders')
                            ->relationship()
                            ->simple(
                                DateTimePicker::make('datetime')->native(false)->seconds(false)->required()
                            )
                            ->defaultItems(0)
                            ->columnSpan('full'),
                    ])
                    ->columns(3)
                    ->collapsed(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->searchable()
                                        ->sortable()
                                        ->description(fn (Quest $record): string => $record->description ?? ''),
                ImageColumn::make('image')->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('xp')->sortable(),
                TextColumn::make('characteristics.name')
                    ->badge()
                    ->separator(','),
                ProgressBar::make('value')
                    ->toggleable()
                    ->label('Progress')
                    ->disabled(fn (Quest $quest) => $quest->condition === QuestCondition::Simple)
                    ->maxValue(fn (Quest $quest) => $quest->value)
                    ->value(fn (Quest $quest) => match ($quest->condition) {
                        QuestCondition::Time => $quest->progresses->sum('total_elapsed_time'),
                        QuestCondition::Quantity => $quest->values->sum('value')
                    }),
                TextColumn::make('status')->sortable()->badge(),
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
                    ViewAction::make()->slideOver(),
                    EditAction::make()->slideOver(),
                    DeleteAction::make()->slideOver(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageQuests::route('/'),
        ];
    }
}
