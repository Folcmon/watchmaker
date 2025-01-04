<?php

namespace App\Enum;

enum DocumentTypeEnum: string
{
    case INVOICE = 'Faktura';
    case RECEIPT = 'Paragon';
    case OFFER = 'Oferta';
    case ORDER = 'Zamówienie';
    case PROFORMA = 'Proforma';
    case OTHER = 'Inny';

    case PROTOCOL_OF_ACCEPTING_THE_ITEM_FOR_SERVICE = 'Protokół przyjęcia przedmiotu do serwisu';
    case PROTOCOL_OF_ISSUING_THE_ITEM_AFTER_SERVICE = 'Protokół wydania przedmiotu po serwisie';

    public static function getChoices(): array
    {
        return [
            'Faktura' => self::INVOICE->value,
            'Paragon' => self::RECEIPT->value,
            'Oferta' => self::OFFER->value,
            'Zamówienie' => self::ORDER->value,
            'Proforma' => self::PROFORMA->value,
            'Inny' => self::OTHER->value,
            'Protokół przyjęcia przedmiotu do serwisu' => self::PROTOCOL_OF_ACCEPTING_THE_ITEM_FOR_SERVICE->value,
            'Protokół wydania przedmiotu po serwisie' => self::PROTOCOL_OF_ISSUING_THE_ITEM_AFTER_SERVICE->value,
        ];
    }

    public static function getTranslatedValue(string $type): string
    {
        return match ($type) {
            self::INVOICE => 'Faktura',
            self::RECEIPT => 'Paragon',
            self::OFFER => 'Oferta',
            self::ORDER => 'Zamówienie',
            self::PROFORMA => 'Proforma',
            self::OTHER => 'Inny',
            self::PROTOCOL_OF_ACCEPTING_THE_ITEM_FOR_SERVICE => 'Protokół przyjęcia przedmiotu do serwisu',
            self::PROTOCOL_OF_ISSUING_THE_ITEM_AFTER_SERVICE => 'Protokół wydania przedmiotu po serwisie',
            default => 'Nieznany typ',
        };
    }
}
