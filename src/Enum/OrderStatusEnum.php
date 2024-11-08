<?php

namespace App\Enum;

enum OrderStatusEnum: string
{
    case NEW = 'Nowe';
    case IN_PROGRESS = 'W trakcie';
    case FINISHED = 'Zakończone';
    case CANCELED = 'Anulowane';

    // case ARCHIVED = 'archived';

    public static function getChoices(): array
    {
        return [
            'Nowe' => self::NEW->value,
            'W trakcie' => self::IN_PROGRESS->value,
            'Zakończone' => self::FINISHED->value,
            'Anulowane' => self::CANCELED->value,
            // 'Zarchiwizowane' => self::ARCHIVED,
        ];
    }

    public static function getTranslatedValue(string $status): string
    {
        return match ($status) {
            self::NEW => 'Nowe',
            self::IN_PROGRESS => 'W trakcie',
            self::FINISHED => 'Zakończone',
            self::CANCELED => 'Anulowane',
            //    self::ARCHIVED => 'Zarchiwizowane',
            default => 'Nieznany status',
        };
    }
}
