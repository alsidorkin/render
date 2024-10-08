<?php

namespace RenderModule;

use Laminas\Router\Http\Literal;
use Laminas\ServiceManager\Factory\InvokableFactory;

return [
    'controllers' => [
        'factories' => [
            \RenderModule\Controller\MyController::class => InvokableFactory::class,
            \RenderModule\Controller\RenderSaveController::class =>
                \RenderModule\Factory\RenderSaveControllerFactory::class,

        ],
    ],
    'service_manager' => [
        'factories' => [
            \RenderModule\Service\RenderService::class => \RenderModule\Factory\RenderServiceFactory::class,
            \RenderModule\Controller\RenderSaveController::class =>
                \RenderModule\Factory\RenderSaveControllerFactory::class,
        ],
    ],
    'router' => [
        'routes' => [
            'my-module' => [
                'type' => 'Literal',
                'options' => [
                    'route'    => '/my-module',
                    'defaults' => [
                        'controller' => \RenderModule\Controller\MyController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'render-save' => [
                'type' => 'Literal',
                'options' => [
                    'route'    => '/render-save',
                    'defaults' => [
                        'controller' => \RenderModule\Controller\RenderSaveController::class,
                        'action'     => 'renderAndSave',
                    ],
                ],
            ],
        ],
    ],
    'view_manager' => [
        'template_map' => [
            'error' => __DIR__ . '/../view/error/error.phtml',
            'my-module/my/index' => __DIR__ . '/../view/my-module/my/index.phtml',
            'render-module/render-save' => __DIR__ .
                '/../view/render-module/render-save/render-and-save.phtml',
            'layout/layout' => __DIR__ . '/../view/layout/layout/layout.phtml',

        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];
