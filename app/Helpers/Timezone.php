<?php

namespace App\Helpers;

class Timezone {
    
    public static function getDatetime(\DateTime $date = null, string $format = null)
    {
        if (!$date) $date = now();
        $clientTZ = config('app.timezone_client') ?? config('app.timezone');

        if ($format) {
            return $date->setTimezone($clientTZ)->format($format);
        } else {
            return $date->setTimezone($clientTZ);
        }
    }

}