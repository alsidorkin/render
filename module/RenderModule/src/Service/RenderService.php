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
 *
 * Сервис для рендеринга шаблонов.
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
        /** @var ResolverInterface|null $resolver */
        $resolver = $this->renderer->resolver();

        if ($resolver instanceof \Laminas\View\Resolver\AggregateResolver) {
            foreach ($resolver->getIterator() as $templateResolver) {
                if ($templateResolver instanceof \Laminas\View\Resolver\TemplateMapResolver) {
                    // Получаем карту шаблонов из TemplateMapResolver
                    $templateMap = $templateResolver->getMap();
                    foreach ($templateMap as $template => $templatePath) {
                        try {
                            $viewModel = new ViewModel();
                            $viewModel->setTemplate($template);
                            $html = $this->renderer->render($viewModel);



                            $filePath = __DIR__ . "/../../../test/Render/{$template}.html";
                            $directoryPath = dirname($filePath);
                            if (! is_dir($directoryPath)) {
                                mkdir($directoryPath, 0777, true);
                            }

                            file_put_contents($filePath, $html);
                            $results[$template] = $filePath;
                        } catch (\Exception $e) {
                            $results[$template] = "Error: " . $e->getMessage();
                        }
                    }
                    break;
                }
            }
        }

        return $results;
    }
}
