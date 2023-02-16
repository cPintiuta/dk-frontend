<?php

declare(strict_types=1);

namespace Frontend\Plugin\Factory;

use Dot\FlashMessenger\FlashMessengerInterface;
use Frontend\Plugin\FormsPlugin;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

/**
 * Class FormsPluginFactory
 * @package Frontend\Plugin\Factory
 */
class FormsPluginFactory
{
    /**
     * @param ContainerInterface $container
     * @return FormsPlugin
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container): FormsPlugin
    {
        return new FormsPlugin(
            $container->get('FormElementManager'),
            $container,
            $container->get(FlashMessengerInterface::class)
        );
    }
}
