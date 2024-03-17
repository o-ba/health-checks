<?php

declare(strict_types=1);

namespace Bo\HealthChecks\Checks;

use Bo\HealthChecks\CheckResult;
use Bo\HealthChecks\ComponentType;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Reports\Report\Status\ConfigurationStatus;

class EmptyReferenceIndexCheck extends AbstractCheck
{
    protected string $componentName = 'TYPO3';
    protected string $measurementName = 'EmptyReferenceIndex';

    public function getCheckResults(): array
    {
        $emptyReferenceIndex = GeneralUtility::makeInstance(ConfigurationStatus::class)->getStatus()['emptyReferenceIndex'];

        return [
            CheckResult::createFromStatus(
                $emptyReferenceIndex,
                'dfd6cf2b-1b6e-4412-a0b8-f6f7797a60d2',
                ComponentType::System,
            )
        ];
    }
}
