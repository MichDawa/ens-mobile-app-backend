<?php
namespace App\Library\Infrastructure\Logging;

use Psr\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Assert\Assertion;

class MonologSQLLoggerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $config = $container->get('Config');
        Assertion::keyExists($config, 'bt-log', 'Log configuration not found');
        
        $logConfig = $config['bt-log']['sql-log'];
        Assertion::notNull($logConfig, 'SQL log configuration missing');

        $logger = new Logger($logConfig['name']);
        $handler = new StreamHandler($logConfig['path'], $logConfig['level']);
        $logger->pushHandler($handler);

        return new MonologSQLLogger($logger);
    }
}