<?php

require_once __DIR__ . '/../../module/Application/src/Library/Infrastructure/Logging/LogNames.php';

return [
    'service_manager' => [
        'factories' => [
            \App\Library\Infrastructure\Logging\MonologSQLLogger::class => \App\Library\Infrastructure\Logging\MonologSQLLoggerFactory::class,
            \App\Library\Infrastructure\Logging\LogNames::APP_LOG => \App\Library\Infrastructure\Logging\AppLoggerFactory::class,
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