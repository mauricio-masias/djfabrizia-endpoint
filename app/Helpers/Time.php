<?php

namespace App\Helpers;

use DateTime;
use DateTimeZone;

class Time
{
    public static function current_time($type, $gmt = 1): string | int
    {
        // Don't use non-GMT timestamp, unless you know the difference and really need to.
        if ('timestamp' === $type || 'U' === $type) {
            return $gmt ? time() : time() + (int) (get_option('gmt_offset') * HOUR_IN_SECONDS);
        }

        if ('mysql' === $type) {
            $type = 'Y-m-d H:i:s';
        }

        $timezone = new DateTimeZone('UTC');
        $datetime = new DateTime('now', $timezone);

        return $datetime->format($type);
    }
}
