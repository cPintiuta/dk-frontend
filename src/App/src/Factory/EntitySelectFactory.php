<?php

namespace Frontend\App\Factory;

use Doctrine\ORM\EntityManager;
use Dot\DataFixtures\Exception\NotFoundException;
use Laminas\Form\ElementFactory;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

class EntitySelectFactory
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws NotFoundException
     */
    public function __invoke(ContainerInterface $container, string $requestedName, ?array $options = null)
    {
        if(! $container->has(EntityManager::class)){

            throw new NotFoundException(
                sprintf('%s does not exist in the container',
                    EntityManager::class)
            );
        }

        $entityManager = $container->get(EntityManager::class);

        $options['entity_manager'] = $entityManager;

        return (new ElementFactory())($container, $requestedName, $options);
    }
}
