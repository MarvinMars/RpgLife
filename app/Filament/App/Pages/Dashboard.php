<?php

namespace App\Filament\App\Pages;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;

class Dashboard extends BaseDashboard
{
    use HasFiltersForm;

    protected static ?string $title = 'Character Dashboard';

    protected static ?string $navigationLabel = 'Character Dashboard';

    protected ?string $heading = 'Character Dashboard';

    public function filtersForm(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                       ->schema([
                           DatePicker::make('startDate'),
                           DatePicker::make('endDate'),
                       ])
                       ->columns(2),
            ]);
    }
}