<?php

declare(strict_types=1);

namespace Bo\HealthChecks\Checks;

use Bo\HealthChecks\CheckResult;
use Bo\HealthChecks\ComponentType;
use CmsHealth\Definition\CheckResultStatus;

class PluginAvailableCheck extends AbstractCheck
{
    public string $componentName = 'Plugin';
    public string $measurementName = 'Available';

    public function getCheckResults(): array
    {
        return [
            new CheckResult(
                CheckResultStatus::Fail,
                'dfd6cf2b-1b6e-4412-a0b8-f6f7797a60d3',
                ComponentType::Component->value,
                new \DateTimeImmutable('now'),
                '0',
                null,
                'The plugin is not available',
            )
        ];
    }
}
