<?php

return [
    'service_manager' => [
        'factories' => [
            Library\Infrastructure\Logging\MonologSQLLogger::class => Library\Infrastructure\Logging\MonologSQLLoggerFactory::class,
            Library\Infrastructure\Logging\LogNames::APP_LOG => Library\Infrastructure\Logging\AppLoggerFactory::class,
        ],
    ],
    'bt-log' => [
        "app-log" => [
            'name' => "app-log",
            'path' => __DIR__ . '/../../data/logs/application.log',
            'level' => \Monolog\Level::Debug,
        ],
        "sql-log" => [
            'name' => "sql-log",
            'path' => __DIR__ . '/../../data/logs/sql.log',
            'level' => \Monolog\Level::Debug,
        ]
    ]
];