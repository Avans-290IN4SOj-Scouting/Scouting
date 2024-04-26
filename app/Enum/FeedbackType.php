<?php

namespace App\Enum;

enum DeliveryStatus: string
{
    case Review = 'review';
    case Question = 'question';
    case Suggestion = 'suggestion';

    public static function localised(): array
    {
        return [
            self::Review->value => __('feedback/feedback.review'),
            self::Question->value => __('feedback/feedback.question'),
            self::Suggestion->value => __('feedback/feedback.suggestion'),
        ];
    }

    public static function delocalised(string $value): self
    {
        return match ($value) {
            __('feedback/feedback.review') => self::Review,
            __('feedback/feedback.question') => self::Question,
            __('feedback/feedback.suggestion') => self::Suggestion,

        };
    }

    public static function localisedValue(string $value): string
    {
        return match ($value) {
            self::Review->value => __('feedback/feedback.review'),
            self::Question->value => __('feedback/feedback.question'),
            self::Suggestion->value => __('feedback/feedback.suggestion'),
        };
    }
}
