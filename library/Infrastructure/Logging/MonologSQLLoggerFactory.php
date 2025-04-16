<?php

namespace Library\Infrastructure\Logging;

use Psr\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Assert\Assertion;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Library\Infrastructure\Logging\MonologSQLLogger;

class MonologSQLLoggerFactory implements FactoryInterface {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) {
        $config = $container->get('Config');
        $configArray = $config->toArray();
        $logConfig = $configArray["bt-log"] ;//?? null;
        Assertion::notEmpty($logConfig, "Log Config not found.");

        $appLog = $logConfig["sql-log"] ;//?? null;
        Assertion::notNull($appLog, "Can not find configuration for sql-log");

        $name = $appLog["name"];
        $path = $appLog["path"];
        $logLevel = $appLog["level"];

        $log = new Logger($name);
        $stream = new StreamHandler($path, $logLevel);
        $log->pushHandler($stream);

        $log = new Logger("sql-logger");
        $sqlLogger = new MonologSQLLogger($log);
        return $sqlLogger;
    }

}
