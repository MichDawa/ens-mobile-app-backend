<?php

$entityPaths = [
    __DIR__ . '/../../module/Sample/src/Infra/Entity',
];

$drivers = [
    'Application\\Infrastructure\\Entity' => 'ens_entity',
];

return [
    'doctrine' => [
        'connection' => [
            'orm_default' => [
                'driverClass' => \Doctrine\DBAL\Driver\PDO\MySQL\Driver::class,
            ],
        ],
        'entitymanager' => [
            'orm_default' => [
                'connection' => 'orm_default',
                'configuration' => 'orm_default'
            ],
        ],
        'driver' => [
            // overriding zfc-user-doctrine-orm's config
            'ens_entity' => [
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'paths' => $entityPaths
            ],
            'orm_default' => [
                'drivers' => $drivers
            ],
        ],
    ],
];
