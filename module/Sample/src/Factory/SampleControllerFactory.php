<?php

namespace Sample\Factory;

use Sample\Controller\SampleController;
use Sample\Service\ParameterParser;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

class SampleControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) {
        $parameterParser = $container->get(ParameterParser::class);
        return new SampleController(
            $parameterParser
        );
    }
}