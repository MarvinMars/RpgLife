<?php

namespace App\Filament\Admin\Resources;

use App\Models\Characteristic;
use App\Models\Quest;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
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
                Textarea::make('description')->rows(10)->required()->columnSpan('full'),
                Select::make('parent_id')
                    ->relationship(name: 'parent', titleAttribute: 'name', ignoreRecord: true)
                    ->options(Quest::all()->pluck('name', 'id'))
                    ->label('Parent')
                    ->columnSpan(2),
                Select::make('characteristics')
                    ->multiple()
                    ->relationship(titleAttribute: 'name')
                    ->options(Characteristic::all()->pluck('name', 'id'))->columnSpan(2),
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
                TextColumn::make('xp'),
                TextColumn::make('parent.name')->badge(),
                TextColumn::make('children_count')->counts('children'),
                IconColumn::make('is_public')->boolean(),
                TextColumn::make('user.name')->badge(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\ReplicateAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
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
