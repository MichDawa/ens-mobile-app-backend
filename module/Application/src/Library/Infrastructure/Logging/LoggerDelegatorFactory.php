<?php

namespace App\Library\Infrastructure\Logging;

use App\Library\Utils\Loggers;
use Psr\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Laminas\ServiceManager\Exception\ServiceNotCreatedException;
use Laminas\ServiceManager\Exception\ServiceNotFoundException;
use Laminas\ServiceManager\Factory\DelegatorFactoryInterface;

class LoggerDelegatorFactory implements DelegatorFactoryInterface {

    /**
     * A factory that creates delegates of a given service
     *
     * @param ContainerInterface $container
     * @param string $name
     * @param callable $callback
     * @param null|array $options
     * @return object
     * @throws ServiceNotFoundException if unable to resolve the service.
     * @throws ServiceNotCreatedException if an exception is raised when
     *     creating a service.
     * @throws ContainerException if any other error occurs
     */
    public function __invoke(ContainerInterface $container, $name, callable $callback, array $options = null) {
        $service = call_user_func($callback);
        $logger = $container->get(Loggers::AppLogger);
        $service->setLogger($logger);
        return $service;
    }
}
