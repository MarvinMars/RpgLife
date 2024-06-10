<?php

namespace App\Filament\Pages;

use App\Http\Resources\QuestResource;
use App\Models\Quest;
use Filament\Pages\Page;

class Board extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.board';

    protected function getViewData(): array
    {
        return QuestResource::collection(Quest::all())->toArray(request());
    }
}
