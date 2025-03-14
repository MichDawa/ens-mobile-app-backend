<?php

namespace App\Library\Infrastructure\Logging;

use Psr\Container\ContainerInterface;
use Monolog\Formatter\JsonFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\WebProcessor;
use Monolog\ErrorHandler;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Assert\Assertion;

class AppLoggerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $config = $container->get('Config');
        Assertion::keyExists($config, 'bt-log', 'Log configuration not found');
        
        $logConfig = $config['bt-log']['app-log'];
        Assertion::notNull($logConfig, 'App log configuration missing');

        $logger = new Logger($logConfig['name']);
        $handler = new StreamHandler($logConfig['path'], $logConfig['level']);
        $handler->setFormatter(new JsonFormatter());
        $logger->pushHandler($handler);
        
        // Add processors
        $logger->pushProcessor(new WebProcessor());
        
        // Register error handling
        $errorHandler = new ErrorHandler($logger);
        $errorHandler->registerErrorHandler([], false);
        $errorHandler->registerExceptionHandler();
        $errorHandler->registerFatalHandler();

        return $logger;
    }
}