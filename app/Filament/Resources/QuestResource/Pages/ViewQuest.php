<?php

namespace App\Filament\Resources\QuestResource\Pages;

use App\Filament\Resources\QuestResource;
use Filament\Actions;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists\Infolist;


class ViewQuest extends ViewRecord
{
    protected static string $resource = QuestResource::class;

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                TextEntry::make('name'),
                TextEntry::make('slug'),
                TextEntry::make('status'),
                TextEntry::make('xp'),
                TextEntry::make('parent.name'),
                TextEntry::make('user.name'),
                TextEntry::make('description'),
            ]);
    }
}
