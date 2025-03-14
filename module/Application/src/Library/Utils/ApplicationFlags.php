<?php

namespace App\Library\Utils;

class ApplicationFlags {

    const NO = 0;
    const YES = 1;

    public static function toString($flag) {
        return ($flag === self::YES ? "TRUE" : "FALSE");
    }

    public static function toStringYesOrNo(int $flag) {
        return ($flag === self::YES ? "YES" : "NO");
    }

}
