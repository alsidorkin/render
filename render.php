<?php

declare(strict_types=1);

use Laminas\Mvc\Application;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\ServiceManager\ServiceManager;
use RenderModule\Controller\RenderSaveController;
use RenderModule\Service\RenderService;

require 'vendor/autoload.php';

$app = Application::init(require 'config/application.config.php');
$serviceManager = $app->getServiceManager();

$renderService = $serviceManager->get(RenderService::class);

$controller = new RenderSaveController($renderService);

$response = $controller->renderAndSaveAction();
