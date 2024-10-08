<?php

namespace RenderModule\Service;

use JetBrains\PhpStorm\NoReturn;
use Laminas\View\Renderer\PhpRenderer;
use Laminas\View\Resolver\ResolverInterface;
use Laminas\View\Resolver\TemplateMapResolver;
use Laminas\View\Resolver\TemplatePathStack;
use Laminas\View\Model\ViewModel;

/**
 * Class RenderService
 */
class RenderService
{
    protected PhpRenderer $renderer;

    public function __construct(array $templateMap, array $templatePaths)
    {
        $this->renderer = new PhpRenderer();

        $mapResolver = new TemplateMapResolver($templateMap);
        $pathStackResolver = new TemplatePathStack([
            'script_paths' => $templatePaths,
        ]);

        $resolver = new \Laminas\View\Resolver\AggregateResolver();
        $resolver->attach($mapResolver);
        $resolver->attach($pathStackResolver);

        $this->renderer->setResolver($resolver);
    }

    public function renderAllTemplates(): array
    {
        $results = [];

        $templateMap = $this->getTemplateMap();
        if ($templateMap) {
            foreach ($templateMap as $template => $templatePath) {
                $results[$template] = $this->renderAndSaveTemplate($template);
            }
        }

        return $results;
    }

    /**
     * @return array|null
     */
    private function getTemplateMap(): ?array
    {
        /** @var ResolverInterface|null $resolver */
        $resolver = $this->renderer->resolver();

        if ($resolver instanceof \Laminas\View\Resolver\AggregateResolver) {
            foreach ($resolver->getIterator() as $templateResolver) {
                if ($templateResolver instanceof \Laminas\View\Resolver\TemplateMapResolver) {
                    return $templateResolver->getMap();
                }
            }
        }

        return null;
    }

    /**
     * @param string $template
     * @return string
     */
    private function renderAndSaveTemplate(string $template): string
    {
        try {
            $html = $this->renderTemplate($template);
            $filePath = $this->saveTemplateToFile($template, $html);
            return $filePath;
        } catch (\Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }

    /**
     * @param string $template
     * @return string
     */
    private function renderTemplate(string $template): string
    {
        $viewModel = new ViewModel();
        $viewModel->setTemplate($template);
        return $this->renderer->render($viewModel);
    }

    /**
     * @param string $template
     * @param string $html
     * @return string
     */
    private function saveTemplateToFile(string $template, string $html): string
    {
        $filePath = __DIR__ . "/../../../test/Render/{$template}.html";
        $directoryPath = dirname($filePath);

        if (! is_dir($directoryPath)) {
            mkdir($directoryPath, 0777, true);
        }

        file_put_contents($filePath, $html);

        return $filePath;
    }
}
