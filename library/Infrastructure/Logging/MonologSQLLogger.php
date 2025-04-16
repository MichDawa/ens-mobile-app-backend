<?php

namespace Library\Infrastructure\Logging;

use Doctrine\DBAL\Logging\SQLLogger;
use Monolog\Logger;

class MonologSQLLogger implements SQLLogger {
    private $logger;
    
    /**
     * @var float
     */
    protected $startTime;

    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
    }

    /**
     * Logs the SQL query and its parameters.
     *
     * @param string     $sql    The SQL query.
     * @param array|null $params The parameters for the SQL query.
     * @param array|null $types  The parameter types.
     */
    public function startQuery($sql, array $params = null, array $types = null)
    {
        $this->logger->debug($sql);

        if ($params) {
            $this->logger->debug(json_encode($params));
        }

        if ($types) {
            $this->logger->debug(json_encode($types));
        }

        $this->startTime = microtime(true);
    }

    /**
     * Logs the time taken by the SQL query.
     */
    public function stopQuery()
    {
        $ms = round((microtime(true) - $this->startTime) * 1000);
        $this->logger->debug("Query took {$ms}ms.");
    }
}
