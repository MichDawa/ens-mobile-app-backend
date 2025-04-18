<?php

namespace Sample\Service;

use Sample\Service\SampleService;
use Sample\Infra\Repository\SampleRepository;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

class SampleServiceFactory implements FactoryInterface {
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) {
        return new SampleService(
            $container->get(SampleRepository::class),
        );
    }
}   