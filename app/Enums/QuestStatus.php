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
            QuestStatus::PENDING => '#faf5ab',
            QuestStatus::IN_PROGRESS => '#32abd9',
            QuestStatus::COMPLETED => '#5fbb4e',
            QuestStatus::FAILED => '#ec4141'
        };
    }
}
