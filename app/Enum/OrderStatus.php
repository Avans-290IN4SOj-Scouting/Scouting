<?php

namespace App\Enum;

enum OrderStatus: string
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
            self::Cancelled->value => __('order_status.cancelled'),
            self::PaymentRefunded->value => __('order_status.payment_refunded'),
            self::AwaitingPayment->value => __('order_status.awaiting_payment'),
            self::Processing->value => __('order_status.processing'),
            self::Delivered->value => __('order_status.delivered'),
            self::Finalized->value => __('order_status.finalized'),
        ];
    }

    public static function delocalised(string $value): self
    {
        return match ($value) {
            __('order_status.cancelled') => self::Cancelled,
            __('order_status.payment_refunded') => self::PaymentRefunded,
            __('order_status.awaiting_payment') => self::AwaitingPayment,
            __('order_status.processing') => self::Processing,
            __('order_status.delivered') => self::Delivered,
            __('order_status.finalized') => self::Finalized,
        };
    }

    public static function localisedValue(string $value): string
    {
        return match ($value) {
            self::Cancelled->value => __('order_status.cancelled'),
            self::PaymentRefunded->value => __('order_status.payment_refunded'),
            self::AwaitingPayment->value => __('order_status.awaiting_payment'),
            self::Processing->value => __('order_status.processing'),
            self::Delivered->value => __('order_status.delivered'),
            self::Finalized->value => __('order_status.finalized'),
        };
    }
}
