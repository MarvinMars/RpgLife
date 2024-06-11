<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum QuestStatus: string implements HasColor, HasLabel
{
    case PENDING = 'pending';
    case IN_PROGRESS = 'in_progress';
    case COMPLETED = 'completed';
    case FAILED = 'failed';

    public static function toArray(): array
    {
        return array_column(QuestStatus::cases(), 'value');
    }

    public function getLabel(): string
    {
        return match ($this) {
            QuestStatus::PENDING => 'Pending',
            QuestStatus::IN_PROGRESS => 'In Progress',
            QuestStatus::COMPLETED => 'Completed',
            QuestStatus::FAILED => 'Failed'
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            QuestStatus::PENDING => 'gray',
            QuestStatus::IN_PROGRESS => 'info',
            QuestStatus::COMPLETED => 'success',
            QuestStatus::FAILED => 'danger'
        };
    }

    public function getClassColor(): string
    {
        return match ($this) {
            QuestStatus::PENDING => 'gray',
            QuestStatus::IN_PROGRESS => 'info',
            QuestStatus::COMPLETED => 'success',
            QuestStatus::FAILED => 'danger'
        };
    }

    public function getIcon(): string
    {
        return match ($this) {
            QuestStatus::PENDING => 'heroicon-o-pause',
            QuestStatus::IN_PROGRESS => 'heroicon-o-play',
            QuestStatus::COMPLETED => 'heroicon-o-check',
            QuestStatus::FAILED => 'heroicon-o-x-mark',
            'default' => ''
        };
    }
}
