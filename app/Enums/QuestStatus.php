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
}
