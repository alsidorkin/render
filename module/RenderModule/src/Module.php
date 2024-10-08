<?php

declare(strict_types=1);

namespace RenderModule;

/**
 * Class Module
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
