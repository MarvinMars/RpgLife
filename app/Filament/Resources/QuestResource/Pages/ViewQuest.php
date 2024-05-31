<?php

namespace App\Filament\Resources\QuestResource\Pages;

use App\Filament\Resources\QuestResource;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;

class ViewQuest extends ViewRecord
{
    protected static string $resource = QuestResource::class;

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                ImageEntry::make('image'),
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
