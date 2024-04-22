<?php

namespace App\Enum;

enum DeliveryStatus: string
{
    case Pending = 'pending';
    case Completed = 'completed';
    case Cancelled = 'cancelled';
   
    public static function localised(): array
    {
        return [
            self::Pending->value => __('delivery_status.pending'),
            self::Completed->value => __('delivery_status.completed'),
            self::Cancelled->value => __('delivery_status.cancelled'),
        ];
    }

    public static function delocalised(string $value): self
    {
        return match ($value) {
            __('delivery_status.pending') => self::Pending,
            __('delivery_status.completed') => self::Completed,
            __('delivery_status.cancelled') => self::Cancelled,
          
        };
    }

    public static function localisedValue(string $value): string
    {
        return match ($value) {
            self::Pending->value => __('delivery_status.pending'),
            self::Completed->value => __('delivery_status.completed'),
            self::Cancelled->value => __('delivery_status.cancelled'),
        };
    }
}
