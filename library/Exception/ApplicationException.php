<?php

namespace Library\Exception;

class ApplicationException extends \Exception {

    const DEFAULT_ERROR_CODE = 100;

    public function __construct($message) {
        parent::__construct($message, self::DEFAULT_ERROR_CODE);
    }

}
