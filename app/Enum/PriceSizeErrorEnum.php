<?php

namespace App\Enum;

enum PriceSizeErrorEnum: string
{
    case PriceArray = 'priceForSize';
    case PriceInput = 'priceForSize.*';
    case SizeArray = 'custom_sizes';
    case SizeInput = 'custom_sizes.*';
    case CustomPricesArray = 'custom_prices';
    case CustomPricesInput = 'custom_prices.*';

    public static function hasError(string $error): bool
    {
        switch ($error) {
            case self::PriceArray->value:
            case self::PriceInput->value:
            case self::SizeArray->value:
            case self::SizeInput->value:
            case self::CustomPricesArray->value:
            case self::CustomPricesInput->value:
                return true;
            default:
                return false;
        }
    }

    public static function toArray(): array
    {
        return [
            self::PriceArray->value,
            self::PriceInput->value,
            self::SizeArray->value,
            self::SizeInput->value,
            self::CustomPricesArray->value,
            self::CustomPricesInput->value,
        ];
    }
}
