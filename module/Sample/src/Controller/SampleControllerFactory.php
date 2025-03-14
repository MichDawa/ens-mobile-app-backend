<?php

namespace Sample\Controller;

use Psr\Container\ContainerInterface;
use Monolog\Logger;
use Sample\Controller\SampleController;
use App\Library\Infrastructure\Logging\LogNames;

class SampleControllerFactory {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null): SampleController {
        /**
         * @var Logger
         */
        $logger = $container->get(LogNames::APP_LOG);
        return new SampleController($logger);
    }
}