<?php

declare(strict_types=1);

namespace Bo\HealthChecks\Checks;

use CmsHealth\Definition\CheckInterface;

abstract class AbstractCheck implements CheckInterface, \JsonSerializable
{
    protected string $componentName;
    protected string $measurementName;

    public function getIdentifier(): string
    {
        return implode(':', [$this->componentName, $this->measurementName]);
    }

    abstract public function getCheckResults(): array;

    public function jsonSerialize(): array
    {
        return $this->getCheckResults();
    }
}
