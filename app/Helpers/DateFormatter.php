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
            1 => 'januari',
            2 => 'februari',
            3 => 'maart',
            4 => 'april',
            5 => 'mei',
            6 => 'juni',
            7 => 'juli',
            8 => 'augustus',
            9 => 'september',
            10 => 'oktober',
            11 => 'november',
            12 => 'december',
        ][$month];
    }
}
