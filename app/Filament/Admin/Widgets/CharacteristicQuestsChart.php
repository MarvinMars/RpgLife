<?php

namespace App\Filament\Admin\Widgets;

use App\Enums\QuestStatus;
use App\Models\Characteristic;
use Filament\Widgets\ChartWidget;

class CharacteristicQuestsChart extends ChartWidget
{
    protected static ?string $heading = 'Quests';

    protected static ?string $pollingInterval = null;

    protected int|string|array $columnSpan = 'full';

    protected function getData(): array
    {
        $datasets = [];
        $characteristics = Characteristic::all();
        $statuses = QuestStatus::cases();

        foreach ($statuses as $status) {
            $dataset = [
                'label' => $status->getLabel().' quests',
                'data' => [],
                'borderColor' => $status->getColor(),
                'fill' => false,
                'borderWidth' => 5,
            ];

            foreach ($characteristics as $characteristic) {
                $completed = $characteristic->quests->where('status', $status)->count();
                $total = $characteristic->quests->count();
                $dataset['data'][] = $total > 0 ? $completed / $total * 100 : 0;
            }

            $datasets[] = $dataset;
        }

        return [
            'datasets' => $datasets,
            'labels' => $characteristics->pluck('name')->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'radar';
    }
}
