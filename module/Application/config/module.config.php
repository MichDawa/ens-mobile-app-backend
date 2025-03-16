<?php

namespace Application;

use Laminas\Router\Http\Literal;
use Laminas\ServiceManager\Factory\InvokableFactory;


return [
    'router' => [
        'routes' => [
            'home' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'application' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/application[/:action]',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\IndexController::class => InvokableFactory::class,
        ],
    ],
    'service_manager' => [
        'factories' => [
            // application factories
        ],
        'delegators' => [
            // delegators
        ],
    ],
    'bt-log' => [
        'app-log' => [
            'name'  => 'app-log',
            'path'  => __DIR__ . '/../../data/logs/application.log',
            'level' => \Monolog\Level::Debug,
        ],
        'sql-log' => [
            'name'  => 'sql-log',
            'path'  => __DIR__ . '/../../data/logs/sql.log',
            'level' => \Monolog\Level::Debug,
        ],
    ],
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => [
            'layout/layout'             => __DIR__ . '/../view/layout/layout.phtml',
            'layout/emaillayout'        => __DIR__ . '/../view/layout/email.phtml',
            'layout/emailnotification'  => __DIR__ . '/../view/layout/emailnotification.phtml',
            'application/index/index'   => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'                 => __DIR__ . '/../view/error/404.phtml',
            'error/index'               => __DIR__ . '/../view/error/index.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];


