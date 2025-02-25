<?php

declare(strict_types=1);

use Doctrine\Common\Cache\PhpFileCache;
use Ramsey\Uuid\Doctrine\UuidBinaryOrderedTimeType;
use Ramsey\Uuid\Doctrine\UuidBinaryType;
use Ramsey\Uuid\Doctrine\UuidType;
use Frontend\App\Resolver\EntityListenerResolver;
use Roave\PsrContainerDoctrine\EntityManagerFactory;
use Doctrine\Persistence\Mapping\Driver\MappingDriverChain;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

return [
    'dependencies' => [
        'factories' => [
            'doctrine.entity_manager.orm_default' => EntityManagerFactory::class,
        ],
        'aliases' => [
            EntityManager::class => 'doctrine.entity_manager.orm_default',
            EntityManagerInterface::class => 'doctrine.entity_manager.default',
            'doctrine.entitymanager.orm_default' => 'doctrine.entity_manager.orm_default'
        ]
    ],

    'doctrine' => [
        'configuration' => [
            'orm_default' => [
                'entity_listener_resolver' => EntityListenerResolver::class,
                'query_cache' => PhpFileCache::class,
                'metadata_cache' => PhpFileCache::class,
                'result_cache' => PhpFileCache::class
            ]
        ],
        'connection' => [
            'orm_default' => [
                'doctrine_mapping_types' => [
                    UuidBinaryType::NAME => 'binary',
                    UuidBinaryOrderedTimeType::NAME => 'binary',
                ]
            ]
        ],
        'driver' => [
            // default metadata driver, aggregates all other drivers into a single one.
            // Override `orm_default` only if you know what you're doing
            'orm_default' => [
                'class' => MappingDriverChain::class,
                'drivers' => [],
            ],
        ],
        'types' => [
            UuidType::NAME => UuidType::class,
            UuidBinaryType::NAME => UuidBinaryType::class,
            UuidBinaryOrderedTimeType::NAME => UuidBinaryOrderedTimeType::class,
        ],
        'cache' => [
            PhpFileCache::class => [
                'class' => PhpFileCache::class,
                'directory' => getcwd() . '/data/cache/doctrine'
            ]
        ],
        'fixtures' => getcwd() . '/data/doctrine/fixtures',
    ],
    'resultCacheLifetime' => 600
];
