<?php

namespace App\Enums;

enum QuestStatus: string
{
    case PENDING = 'pending';
    case IN_PROGRESS = 'in_progress';
    case COMPLETED = 'completed';
    case FAILED = 'failed';

    public static function toArray(): array
    {
        return array_column(QuestStatus::cases(), 'value');
    }

    public function label(): string
    {
        return match ($this) {
            QuestStatus::PENDING => 'Pending',
            QuestStatus::IN_PROGRESS => 'In Progress',
            QuestStatus::COMPLETED => 'Completed',
            QuestStatus::FAILED => 'Failed'
        };
    }

    public function color(): string
    {
        return match ($this) {
            QuestStatus::PENDING => 'yellow',
            QuestStatus::IN_PROGRESS => 'blue',
            QuestStatus::COMPLETED => 'green',
            QuestStatus::FAILED => 'red'
        };
    }
}
