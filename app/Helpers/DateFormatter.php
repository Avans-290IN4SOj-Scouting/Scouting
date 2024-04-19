<?php

namespace App\Helpers;

use DateTime;

class DateFormatter
{
    public static function format(DateTime $date)
    {
        $day = $date->format('d');
        $monthText = self::monthToText($date->format('n'));
        $year = $date->format('Y');

        return "$day $monthText $year";
    }

    private static function monthToText($month)
    {
        return [
            1 => __('months.january'),
            2 => __('months.february'),
            3 => __('months.march'),
            4 => __('months.april'),
            5 => __('months.may'),
            6 => __('months.june'),
            7 => __('months.july'),
            8 => __('months.august'),
            9 => __('months.september'),
            10 => __('months.october'),
            11 => __('months.november'),
            12 => __('months.december'),
        ][$month];
    }
}
