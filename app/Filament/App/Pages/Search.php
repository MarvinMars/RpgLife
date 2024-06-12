<?php

namespace App\Filament\App\Pages;

use App\Filament\App\Resources\QuestResource\Widgets\QuestsOverview;
use Filament\Pages\Page;

class Search extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-magnifying-glass';

    protected static string $view = 'filament.app.pages.search';

    protected function getHeaderWidgets(): array
    {
        return [
            QuestsOverview::class
        ];
    }
}
