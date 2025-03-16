<?php

declare(strict_types=1);

namespace Bo\HealthChecks\Tca;

use Bo\HealthChecks\HealthCheckRegistry;
use TYPO3\CMS\Core\Schema\Struct\SelectItem;

class CheckItems
{
    public function __construct(
        private readonly HealthCheckRegistry $healthCheckRegistry
    ) {
    }

    public function getItems(&$params): void
    {
        foreach ($this->healthCheckRegistry->getHealthChecks() as $check) {
            $params['items'][] = new SelectItem(
                'select',
                $check->getName(),
                $check->getName(),
            );
        }
    }
}
