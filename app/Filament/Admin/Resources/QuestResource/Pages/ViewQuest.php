<?php

namespace App\Filament\Admin\Resources\QuestResource\Pages;

use App\Filament\Admin\Resources\QuestResource;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\Split;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Enums\IconPosition;

class ViewQuest extends ViewRecord
{
    protected static string $resource = QuestResource::class;

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Split::make([
                    Section::make([
                        TextEntry::make('name')
                            ->hiddenLabel()
                            ->weight(FontWeight::Bold)
                            ->columnSpan(3),
                        TextEntry::make('status')->hiddenLabel()
                            ->badge()
                            ->columnSpan(1)
                            ->alignEnd(),
                        ImageEntry::make('image')->hiddenLabel()
                            ->alignCenter(),
                        TextEntry::make('description')
                            ->columnSpan(4)
                            ->hiddenLabel()
                            ->prose(),
                        TextEntry::make('created_at')
                            ->hiddenLabel()
                            ->color('primary')
                            ->dateTime(),
                    ])
                        ->columns(4),
                    Section::make([
                        TextEntry::make('xp')->inlineLabel()
                            ->color('success')
                            ->iconColor('success')
                            ->icon('heroicon-m-chevron-double-up')
                            ->weight(FontWeight::Bold)
                            ->iconPosition(IconPosition::After),
                        TextEntry::make('parent.name')->default('---'),
                    ])->grow(false),
                ])->from('md')
                    ->columnSpanFull(),
            ]);
    }
}
