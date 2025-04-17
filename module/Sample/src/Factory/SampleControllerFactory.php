<?php

namespace Sample\Factory;

use Sample\Controller\SampleController;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;
use Library\Infrastructure\Logging\LogNames;
use Sample\Service\SampleService;

class SampleControllerFactory implements FactoryInterface {
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) {
        /**
         * @var \Monolog\Logger $logger
         * */
        $logger = $container->get(LogNames::APP_LOG);
        return new SampleController(
            $logger,
            $container->get(SampleService::class),
        );
    }
}   