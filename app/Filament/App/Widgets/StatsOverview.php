<?php

namespace App\Filament\App\Widgets;

use App\Enums\QuestStatus;
use App\Models\Quest;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Database\Eloquent\Builder;

class StatsOverview extends BaseWidget
{
    use InteractsWithPageFilters;
    protected static ?int $sort = 2;

    protected int | string | array $columnSpan = 1;

    protected function getColumns(): int
    {
        return 2;
    }

    protected function getStats(): array
    {
        $data = [];
        $questStatuses = QuestStatus::cases();
        $startDate = $this->filters['startDate'] ?? null;
        $endDate = $this->filters['endDate'] ?? null;

        foreach ($questStatuses as $questStatus) {
            $count = Quest::query()->where('status', $questStatus->value)
                ->when($startDate, fn (Builder $query) => $query->whereDate('created_at', '>=', $startDate))
                ->when($endDate, fn (Builder $query) => $query->whereDate('created_at', '<=', $endDate))
                ->count();
            $data[] = Stat::make($questStatus->getLabel(), $count)
                          ->color($questStatus->getColor())
                          ->icon($questStatus->getIcon());
        }
        return $data;
    }
}
