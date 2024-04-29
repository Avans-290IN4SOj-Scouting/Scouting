<?php

namespace App\Enum;

enum DeliveryStatus: string
{
    case Cancelled = 'cancelled';
    case PaymentRefunded = 'payment_refunded';
    case AwaitingPayment = 'awaiting_payment';
    case Processing = 'processing';
    case Delivered = 'delivered';
    case Finalized = 'finalized';

    public static function localised(): array
    {
        return [
            self::Cancelled->value => __('delivery_status.cancelled'),
            self::PaymentRefunded->value => __('delivery_status.payment_refunded'),
            self::AwaitingPayment->value => __('delivery_status.awaiting_payment'),
            self::Processing->value => __('delivery_status.processing'),
            self::Delivered->value => __('delivery_status.delivered'),
            self::Finalized->value => __('delivery_status.finalized'),
        ];
    }

    public static function delocalised(string $value): self
    {
        return match ($value) {
            __('delivery_status.cancelled') => self::Cancelled,
            __('delivery_status.payment_refunded') => self::PaymentRefunded,
            __('delivery_status.awaiting_payment') => self::AwaitingPayment,
            __('delivery_status.processing') => self::Processing,
            __('delivery_status.delivered') => self::Delivered,
            __('delivery_status.finalized') => self::Finalized,
        };
    }

    public static function localisedValue(string $value): string
    {
        return match ($value) {
            self::Cancelled->value => __('delivery_status.cancelled'),
            self::PaymentRefunded->value => __('delivery_status.payment_refunded'),
            self::AwaitingPayment->value => __('delivery_status.awaiting_payment'),
            self::Processing->value => __('delivery_status.processing'),
            self::Delivered->value => __('delivery_status.delivered'),
            self::Finalized->value => __('delivery_status.finalized'),
        };
    }
}
