<?php

namespace Library\Infrastructure\Logging;

use Assert\Assertion;
use Psr\Container\ContainerInterface;
use Monolog\ErrorHandler;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Laminas\ServiceManager\Factory\FactoryInterface;

class LocalContainerLoggerFactory implements FactoryInterface {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) {
        $config = $container->get('Config');
        $configArray = $config->toArray();
        $logConfig = $configArray["bt-log"] ;//?? null;
        Assertion::notEmpty($logConfig, "Log Config not found.");

        $appLog = $logConfig["app-log"] ;//?? null;
        Assertion::notNull($appLog, "Can not find configuration for app-log");

        $name = $appLog["name"];
        $path = $appLog["path"];
        $logLevel = $appLog["level"];

        $log = new Logger($name);

        $stream = new StreamHandler($path, $logLevel);
        $formatter = new LineFormatter();
        $stream->setFormatter($formatter);

        $log->pushHandler($stream);

        $handler = new ErrorHandler($log);
        $handler->registerErrorHandler([], false);
        $handler->registerExceptionHandler();
        $handler->registerFatalHandler();
        
        return $log;
    }

}
