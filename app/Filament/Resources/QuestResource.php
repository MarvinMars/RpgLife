<?php

namespace App\Filament\Resources;

use App\Filament\Resources\QuestResource\Pages;
use App\Models\Characteristic;
use App\Models\Quest;
use App\Models\User;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class QuestResource extends Resource
{
    protected static ?string $model = Quest::class;

    public Quest $quest;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->live(debounce: 1000)
                    ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state)))
                    ->columnSpan(3),
                TextInput::make('slug')->columnSpan(2),
                TextInput::make('xp')->default(0)->type('number')->columnSpan(1),
                MarkdownEditor::make('description')->columnSpan('full'),
                Select::make('parent_id')
                    ->relationship(name: 'parent', titleAttribute: 'name', ignoreRecord: true)
                    ->options(Quest::all()->pluck('name', 'id'))
                    ->label('Parent')
                    ->columnSpan(2),
                Select::make('user_id')
                    ->options(User::all()->pluck('name', 'id'))
                    ->label('User')
                    ->default(auth()->id())
                    ->columnSpan(2),
                Select::make('characteristics')
                    ->multiple()
                    ->relationship(titleAttribute: 'name')
                    ->options(Characteristic::all()->pluck('name', 'id'))->columnSpan(2),
            ])->columns(6);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('slug'),
                TextColumn::make('xp'),
                TextColumn::make('parent.name')->badge(),
                TextColumn::make('children_count')->counts('children'),
                TextColumn::make('created_at')->dateTime(),
                TextColumn::make('updated_at')->dateTime(),
                TextColumn::make('user.name')->badge(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListQuests::route('/'),
            'create' => Pages\CreateQuest::route('/create'),
            'view' => Pages\ViewQuest::route('/{record}'),
            'edit' => Pages\EditQuest::route('/{record}/edit'),
        ];
    }
}
