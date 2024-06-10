<?php

namespace App\Filament\Admin\Resources\QuestResource\Pages;

use App\Filament\Admin\Resources\QuestResource;
use App\Enums\QuestCondition;
use Carbon\Carbon;
use Filament\Resources\Pages\CreateRecord;

class CreateQuest extends CreateRecord
{
    protected static string $resource = QuestResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();

        if($data['condition'] === QuestCondition::Time->value){
            $data['value'] = Carbon::parse($data['value'])->diffInSeconds(Carbon::parse('00:00:00'));
        }

        return $data;
    }
}
