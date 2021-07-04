<?php

namespace Frontend\App;

use Fig\Http\Message\RequestMethodInterface;
use Frontend\App\Controller\LanguageController;
use Laminas\Diactoros\Response\JsonResponse;
use Mezzio\Application;
use Psr\Container\ContainerInterface;

use function var_dump;

/**
 * Class RoutesDelegator
 * @package Frontend\App
 */
class RoutesDelegator
{
    /**
     * @param ContainerInterface $container
     * @param $serviceName
     * @param callable $callback
     * @return Application
     */
    public function __invoke(ContainerInterface $container, $serviceName, callable $callback)
    {
        /** @var Application $app */
        $app = $callback();

        $app->route(
            '/language/{action}',
            LanguageController::class,
            [RequestMethodInterface::METHOD_POST],
            'language'
        );

        return $app;
    }
}
