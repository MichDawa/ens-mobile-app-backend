<?php

namespace Library\Infrastructure\Logging;

use Assert\Assertion;
use Psr\Container\ContainerInterface;
use Monolog\ErrorHandler;
use Monolog\Formatter\GoogleCloudLoggingFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\IntrospectionProcessor;
use Monolog\Processor\WebProcessor;
use Laminas\ServiceManager\Factory\FactoryInterface;

class ContainerLoggerFactory implements FactoryInterface {

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

        $stream = new StreamHandler($path, $logLevel);
        $formatter = new GoogleCloudLoggingFormatter();
        $stream->setFormatter($formatter);

        $log->pushHandler($stream);

        //processors
        $webProcessor = new WebProcessor();
        $webProcessor->addExtraField("query parameters", "QUERY_STRING");
        $log->pushProcessor($webProcessor);
        $log->pushProcessor(new IntrospectionProcessor());
        $log->pushProcessor(new UserAndPostDataProcessor());

        $handler = new ErrorHandler($log);
        $handler->registerErrorHandler([], false);
        $handler->registerExceptionHandler();
        $handler->registerFatalHandler();
        
        return $log;
    }

}
