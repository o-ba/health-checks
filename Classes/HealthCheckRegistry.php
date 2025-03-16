<?php

declare(strict_types=1);

namespace Bo\HealthChecks;

use CmsHealth\Definition\CheckInterface;
use CmsHealth\Definition\HealthCheckInterface;
use CmsHealthProject\SerializableReferenceImplementation\Check;

/**
 * Registry class for health checks
 */
class HealthCheckRegistry
{
    protected array $healthChecks = [];

    public function __construct(iterable $healthChecks)
    {
        foreach ($healthChecks as $healthCheck) {
            if ($healthCheck instanceof CheckInterface) {
                $this->healthChecks[$healthCheck->getName()] = $healthCheck;
            }
        }
    }

    /**
     * Get all registered health checks
     *
     * @return Check[]
     */
    public function getHealthChecks(): array
    {
        return $this->healthChecks;
    }

    /**
     * Get all registered health checks
     *
     * @return Check[]
     */
    public function getHealthChecksForReaction(HealthCheckReactionInstruction $reaction): array
    {
        $checksForReaction = $reaction->getRequestedChecks();

        if ($reaction->getRequestedChecks() === []) {
            return $this->healthChecks;
        }

        return array_filter(
            $this->healthChecks,
            static fn (Check $check): bool => in_array($check->getName(), $checksForReaction, true)
        );
    }
}
