<?php

namespace App\Filament\App\Resources\QuestResource\Pages;

use App\Enums\QuestCondition;
use App\Enums\QuestStatus;
use App\Filament\App\Resources\QuestResource;
use Carbon\Carbon;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Database\Eloquent\Builder;

class ManageQuests extends ManageRecords
{
    protected static string $resource = QuestResource::class;

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('All'),
            'pending' => Tab::make('Pending')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', QuestStatus::PENDING)),
            'in_progress' => Tab::make('In progress')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', QuestStatus::IN_PROGRESS)),
            'completed' => Tab::make('Completed')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', QuestStatus::COMPLETED)),
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->slideOver()
                ->beforeFormFilled(function ($data) {
                    if (($data['condition'] ?? false) && $data['condition'] === QuestCondition::Time->value) {
                        $data['value'] = Carbon::parse($data['value'])->diffInSeconds(Carbon::parse('00:00:00'));
                    }

                    return $data;
                })
                ->mutateFormDataUsing(function (array $data): array {
                    $data['user_id'] = auth()->id();

                    if (($data['condition'] ?? false) && $data['condition'] === QuestCondition::Time->value) {
                        $data['value'] = Carbon::parse($data['value'])->diffInSeconds(Carbon::parse('00:00:00'));
                    }

                    return $data;
                }),
        ];
    }
}
