<?php

namespace App\Filament\Admin\Widgets;

use App\Enums\QuestStatus;
use App\Models\Characteristic;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class CharacteristicsOverview extends BaseWidget
{
    protected static ?string $pollingInterval = null;

    protected function getStats(): array
    {
        $characteristics = Characteristic::all();
        $stats = [];

        foreach ($characteristics as $characteristic) {
            $stats[] = Stat::make(
                $characteristic->name,
                $characteristic->quests()->where('status', QuestStatus::PENDING)->count()
                .' / '.
                $characteristic->quests()->where('status', QuestStatus::COMPLETED)->count()
            )
                ->description('Total: '.$characteristic->quests()->count())
                ->chart($this->getChartData($characteristic->quests))
                ->color($characteristic->color)
                ->icon($characteristic->icon);
        }

        return $stats;
    }

    protected function getChartData($quests): array
    {
        $startDate = Carbon::now()->subMonth();
        $endDate = now();
        $weeklyCounts = [];
        while ($startDate->lte($endDate)) {
            $weekStartDate = $startDate->copy()->startOfWeek();
            $weekEndDate = $startDate->copy()->endOfWeek();
            $completedCount = $quests->whereBetween('completed_at', [$weekStartDate, $weekEndDate])
                ->count();
            $weeklyCounts[$weekStartDate->format('Y-m-d')] = $completedCount;
            $startDate->addWeek();
        }

        return $weeklyCounts;
    }
}
