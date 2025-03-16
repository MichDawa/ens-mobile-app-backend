<?php
// File: module/Sample/config/module.config.php

use Laminas\Router\Http\Segment;

return [
    'service_manager' => [
        'factories' => [
            // sample factories
            \Sample\Service\ParameterParser::class => \Laminas\ServiceManager\Factory\InvokableFactory::class,
        ],
        'delegators' => [
            // delegators
        ],
    ],
    'controllers' => [
        'factories' => [
            \Sample\Controller\SampleController::class => \Sample\Factory\SampleControllerFactory::class,
        ],
    ],
    'router' => [
        'routes' => [
            'sc-sample' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/sample[/:action]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ],
                    'defaults'  => [
                        'controller' => \Sample\Controller\SampleController::class,
                        'action' => 'index',
                    ],
                ],
            ],
        ],
    ],
    'view_manager' => [
        'strategies' => ['ViewJsonStrategy'],
    ],
];