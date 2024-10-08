<?php

namespace RenderModule\Factory;

use RenderModule\Service\RenderService;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

/**
 * Class RenderServiceFactory
 *
 * Фабрика для создания экземпляров RenderService.
 */

class RenderServiceFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $config = $container->get('config');

        $templateMap = $config['view_manager']['template_map'] ?? [];
        $templatePaths = $config['view_manager']['template_path_stack'] ?? [];

        return new RenderService($templateMap, $templatePaths);
    }
}
