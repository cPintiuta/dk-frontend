<?php

namespace Frontend\User\Authentication;

use Doctrine\ORM\EntityManager;
use Psr\Container\ContainerInterface;
use Exception;

class AuthenticationAdapterFactory
{
    /**
     * @param ContainerInterface $container
     * @return AuthenticationAdapter
     * @throws Exception
     */
    public function __invoke(ContainerInterface $container): AuthenticationAdapter
    {
        // TODO Refactor this to use the specific entity repository, not the entity manager
        if (! $container->has(EntityManager::class)) {
            throw new Exception('EntityManager not found.');
        }

        /** @var array $config */
        $config = $container->get('config');
        if (! isset($config['doctrine']['authentication'])) {
            throw new Exception('Authentication config not found.');
        }
        return new AuthenticationAdapter(
            $container->get(EntityManager::class),
            $config['doctrine']['authentication']
        );
    }
}
