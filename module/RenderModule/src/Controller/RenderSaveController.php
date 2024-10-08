<?php

namespace RenderModule\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use RenderModule\Service\RenderService;

/**
 * Class RenderSaveController
 */
class RenderSaveController extends AbstractActionController
{
    protected $event;

    protected $events;
    protected $plugins;
    protected $request;
    protected $response;
    private RenderService $renderService;

    public function __construct(RenderService $renderService)
    {
        $this->renderService = $renderService;
    }

    public function renderAndSaveAction(): ViewModel
    {
        try {
            $renderedFiles = $this->renderService->renderAllTemplates();
            return new ViewModel([
                'message' => "Templates rendered and saved to: " . implode(', ', $renderedFiles),
            ]);
        } catch (\Exception $e) {
            return new ViewModel([
                'message' => "Error: " . $e->getMessage(),
            ]);
        }
    }
}
