<?php

namespace Library\Infrastructure\Logging;

use Psr\Container\ContainerInterface;
use Monolog\Formatter\JsonFormatter;
use Monolog\Processor\WebProcessor;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Assert\Assertion;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\ErrorHandler;

class AppLoggerFactory implements FactoryInterface {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) {
        $config = $container->get('Config');
        $logConfig = $config["bt-log"] ;//?? null;
        Assertion::notEmpty($logConfig, "Log Config not found.");

        $appLog = $logConfig["app-log"] ;//?? null;
        Assertion::notNull($appLog, "Can not find configuration for app-log");

        $name = $appLog["name"];
        $path = $appLog["path"];
        $logLevel = $appLog["level"];

        $log = new Logger($name);
        $formatter = new JsonFormatter();
        $stream = new StreamHandler($path, $logLevel);
        $stream->setFormatter($formatter);
        $log->pushHandler($stream);

        //processors
        $log->pushProcessor(new WebProcessor());

        $handler = new ErrorHandler($log);
        $handler->registerErrorHandler([], false);
        $handler->registerExceptionHandler();
        $handler->registerFatalHandler();
        
        return $log;
    }

}
