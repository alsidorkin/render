<?php

declare(strict_types=1);

namespace RenderModule;

/**
 * Class Module
 *
 * Основной класс модуля.
 */
class Module
{
    public function getConfig(): array
    {
        /** @var array $config */
        $config = include __DIR__ . '/../config/module.config.php';
        return $config;
    }
}
