<?php

declare(strict_types=1);

namespace Bo\HealthChecks;

use CmsHealth\Definition\CheckInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $container, ContainerBuilder $containerBuilder) {
    $containerBuilder->registerForAutoconfiguration(CheckInterface::class)->addTag('health.check');
};
