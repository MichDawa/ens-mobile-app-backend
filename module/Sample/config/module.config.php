<?php
// File: module/Sample/config/module.config.php

use Laminas\Router\Http\Segment;
use Sample\Controller\SampleController;
use Sample\Controller\SampleControllerFactory;

return [
    'service_manager' => [
        'factories' => [
            // sample factories
        ],
        'delegators' => [
            \App\Library\Infrastructure\Events\DoctrineEventSubscriber::class => [
                0 => \App\Library\Infrastructure\Logging\LoggerDelegatorFactory::class,
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            SampleController::class => SampleControllerFactory::class,
        ],
    ],
    'router' => [
        'routes' => [
            'sc-sample' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/sample[/:action]',
                    'defaults' => [
                        'controller' => SampleController::class,
                        'action'     => 'sample',
                    ],
                ],
            ],
        ],
    ],
];