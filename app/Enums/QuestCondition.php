<?php

namespace App\Enums;

enum QuestCondition: string
{
    case Time = 'time';
    case Quantity = 'quantity';

    case Simple = 'simple';

    public static function toArray(): array
    {
        return array_column(QuestCondition::cases(), 'value');
    }

    public static function options(): array
    {
        return [
            QuestCondition::Time->value => QuestCondition::Time->name,
            QuestCondition::Quantity->value => QuestCondition::Quantity->name,
            QuestCondition::Simple->value => QuestCondition::Simple->name,
        ];
    }
}
