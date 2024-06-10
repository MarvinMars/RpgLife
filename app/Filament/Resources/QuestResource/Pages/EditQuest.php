<?php

namespace App\Filament\Resources\QuestResource\Pages;

use App\Enums\QuestCondition;
use App\Filament\Resources\QuestResource;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditQuest extends EditRecord
{
    protected static string $resource = QuestResource::class;

    protected function mutateFormDataBeforeFill(array $data): array
    {
        if($data['condition'] === QuestCondition::Time->value){
            $data['value'] = Carbon::parse('00:00:00')->addSeconds($data['value']);
        }

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if($data['condition'] === QuestCondition::Time->value){
            $data['value'] = Carbon::parse($data['value'])->diffInSeconds(Carbon::parse('00:00:00'));
        }

        return $data;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
