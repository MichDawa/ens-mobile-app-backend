<?php

namespace Library\Utils;

use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;

class BaseService implements LoggerAwareInterface {

    protected $logger;

    /**
     * Sets a logger instance on the object.
     *
     * @param LoggerInterface $logger
     *
     * @return void
     */
    public function setLogger(LoggerInterface $logger): void {
        $this->logger = $logger;
    }

    /**
     * @return LoggerInterface
     */
    public function getLogger() {
        return $this->logger;
    }
}
