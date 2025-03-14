<?php
namespace App\Library\Infrastructure\Logging;

use Doctrine\DBAL\Logging\SQLLogger;
use Psr\Log\LoggerInterface;

class MonologSQLLogger implements SQLLogger
{
    protected $logger;
    protected $currentQuery = [];
    protected $queryStartTime;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function startQuery($sql, ?array $params = null, ?array $types = null)
    {
        $this->queryStartTime = microtime(true);
        $this->currentQuery = [
            'sql' => $sql,
            'params' => $params,
            'types' => $types,
        ];
    }

    public function stopQuery()
    {
        $executionTime = microtime(true) - $this->queryStartTime;
        $this->currentQuery['execution_time'] = $executionTime;
        
        $this->logger->debug('SQL Query', [
            'query' => $this->currentQuery,
            'execution_time' => round($executionTime, 4)
        ]);
        
        $this->currentQuery = [];
    }
}