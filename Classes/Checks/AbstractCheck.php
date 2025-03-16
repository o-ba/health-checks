<?php

declare(strict_types=1);

namespace Bo\HealthChecks\Checks;

use CmsHealthProject\SerializableReferenceImplementation\Check;

abstract class AbstractCheck extends Check
{
    protected string $componentName;
    protected string $measurementName;

    public function __construct()
    {
        parent::__construct(implode(':', [$this->componentName, $this->measurementName]));
    }
}
