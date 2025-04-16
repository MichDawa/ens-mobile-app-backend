<?php

namespace Library\Utils;

class AppDate {

    const ISO8601_DATE = "Y-m-d";
    const ISO8601_TIME = "H:i:s";
    const ISO8601_DATETIME = "Y-m-d H:i:s";
    const DISPLAY_DATETIME = "m/d/Y g:i a";
    const DISPLAY_DATE = "m/d/Y";
    const JAVASCRIPT_JSON = "Y-m-d" . "\T" . "H:i:s.u\Z";
    const DISPLAY_TIMEONLY = "g:i a";
    const DISPLAY_DATETIME_COMPLETE = "D, M j, Y g:i a";
    const DISPLAY_DATE_COMPLETE = "D, M j, Y";
    const DISPLAY_DATETIME_SHORT = "M j, Y g:i a";
    const DISPLAY_DATE_SHORT = "M j, Y";
    const ISO8601_DATE_AND_TIME_SHORT = "Y-m-d g:ia";
    const DISPLAY_DATE_MONTH_SHORT = "j-M";
    const BIR_DISPLAY_DATETIME = "m/d/Y g:i:s a";
    const PI_DISPLAY_DATETIME = "F d, Y (D) g:i A";
    const PI_DISPLAY_DATETIME_COMPLETE = "l, F d, Y \\a\\t g:i A";
    const FILE_DATE = "mdY";
    
    public static function toJsonDateTime(\DateTime $date): string {
        return $date->format(self::ISO8601_DATETIME);
    }
}
