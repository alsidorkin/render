<?php

namespace RenderModule\Factory;

use RenderModule\Controller\RenderSaveController;
use RenderModule\Service\RenderService;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

/**
 * Class RenderSaveControllerFactory
 *
 * Фабрика для создания экземпляров RenderSaveController.
 */
class RenderSaveControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $renderService = $container->get(RenderService::class);

        return new RenderSaveController($renderService);
    }
}
