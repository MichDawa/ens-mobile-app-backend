<?php

return [
    'service_manager' => [
        'factories' => [
            // repositories
            \Sample\Infra\Repository\SampleRepository::class =>\Library\Infrastructure\Repository\RepositoryFactory::class,

            // services
            \Library\Utils\ParameterParser::class => \Laminas\ServiceManager\Factory\InvokableFactory::class,
            \Sample\Service\SampleService::class => \Sample\Service\SampleServiceFactory::class,
        ],
        'delegators' => [
            \Sample\Service\SampleService::class => [
                0 => \Library\Infrastructure\Logging\LoggerDelegatorFactory::class,
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            \Sample\Controller\SampleController::class => \Sample\Controller\SampleControllerFactory::class,
        ],
    ],
    'router' => [
        'routes' => [
            'sc-sample' => [
                'type'    => Laminas\Router\Http\Segment::class,
                'options' => [
                    'route' => '/sample[/:action]',
                    'defaults'  => [
                        'controller' => \Sample\Controller\SampleController::class,
                    ],
                ],
            ], 
        ],
    ],
    'api-tools-versioning' => [
        'uri' => [
            0 => 'sc-sample',
        ],
    ],
    'api-tools-rpc' => [
        \Sample\Controller\SampleController::class => [
            'service_name' => 'Sample',
            'http_methods' => [
                0 => 'GET',
                1 => 'POST',
            ],
            'route_name' => 'sc-sample',
        ],
    ],
    'api-tools-content-negotiation' => [
        'controllers' => [
            \Sample\Controller\SampleController::class => 'Json',
        ],
        'content_type_whitelist' => [
            \Sample\Controller\SampleController::class => [
                0 => 'application/json',
            ],
        ],
    ],
];