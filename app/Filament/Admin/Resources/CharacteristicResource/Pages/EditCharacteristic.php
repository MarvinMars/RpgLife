<?php

namespace App\Filament\Admin\Resources\CharacteristicResource\Pages;

use App\Filament\Admin\Resources\CharacteristicResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCharacteristic extends EditRecord
{
    protected static string $resource = CharacteristicResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
