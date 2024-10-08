<?php

namespace RenderModule\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

/**
 * Class MyController
 *
 * Контроллер для обработки запросов в модуле My.
 */
class MyController extends AbstractActionController
{
    public function indexAction(): ViewModel
    {
        $viewModel = new ViewModel();
        $viewModel->setTemplate('my-module/my/index'); // Укажите путь к вашему шаблону
        return $viewModel;
    }
}
