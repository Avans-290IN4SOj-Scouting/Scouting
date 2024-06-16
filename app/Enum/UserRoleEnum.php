<?php

namespace App\Enum;

enum UserRoleEnum: string
{
    case Admin = 'admin';
    case User = 'user';
    case Bevers = 'team_bevers';
    case Gidsen = 'team_gidsen';
    case Kabouters = 'team_kabouters';
    case Scouts = 'team_scouts';
    case Waterwerk = 'team_waterwerk';
    case Welpen = 'team_welpen';
    case Leiders = 'team_leiders';

    public static function localised(): array
    {
        return [
            self::Admin->value => __('user_roles.admin'),
            self::User->value => __('user_roles.user'),
            self::Bevers->value => __('user_roles.team_bevers'),
            self::Gidsen->value => __('user_roles.team_gidsen'),
            self::Kabouters->value => __('user_roles.team_kabouters'),
            self::Scouts->value => __('user_roles.team_scouts'),
            self::Waterwerk->value => __('user_roles.team_waterwerk'),
            self::Welpen->value => __('user_roles.team_welpen'),
            self::Leiders->value => __('user_roles.team_leiders'),
        ];
    }

    public static function delocalised(string $value): self
    {
        return match ($value) {
            __('user_roles.admin') => self::Admin,
            __('user_roles.user') => self::User,
            __('user_roles.team_bevers') => self::Bevers,
            __('user_roles.team_gidsen') => self::Gidsen,
            __('user_roles.team_kabouters') => self::Kabouters,
            __('user_roles.team_scouts') => self::Scouts,
            __('user_roles.team_waterwerk') => self::Waterwerk,
            __('user_roles.team_welpen') => self::Welpen,
            __('user_roles.team_leiders') => self::Leiders,
        };
    }

    public static function localisedValue(string $value): string
    {
        return match ($value) {
            self::Admin->value => __('user_roles.admin'),
            self::User->value => __('user_roles.user'),
            self::Bevers->value => __('user_roles.team_bevers'),
            self::Gidsen->value => __('user_roles.team_gidsen'),
            self::Kabouters->value => __('user_roles.team_kabouters'),
            self::Scouts->value => __('user_roles.team_scouts'),
            self::Waterwerk->value => __('user_roles.team_waterwerk'),
            self::Welpen->value => __('user_roles.team_welpen'),
            self::Leiders->value => __('user_roles.team_leiders'),
        };
    }
}
