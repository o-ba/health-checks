<?php

declare(strict_types=1);

namespace Bo\HealthChecks\Checks;

use Bo\HealthChecks\CheckResult;
use Bo\HealthChecks\ComponentType;
use CmsHealth\Definition\CheckResultStatus;
use TYPO3\CMS\Core\Information\Typo3Version;

class VersionCheck extends AbstractCheck
{
    public string $componentName = 'TYPO3';
    public string $measurementName = 'Version';

    public function getCheckResults(): array
    {
        return [
            new CheckResult(
                'dfd6cf2b-1b6e-4412-a0b8-f6f7797a60d1',
                ComponentType::System,
                CheckResultStatus::Info,
                (string)(new Typo3Version()),
            )
        ];
    }
}
