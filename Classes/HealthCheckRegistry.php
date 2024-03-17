<?php

declare(strict_types=1);

namespace Bo\HealthChecks;

use CmsHealth\Definition\CheckInterface;

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
                $this->healthChecks[$healthCheck->getIdentifier()] = $healthCheck;
            }
        }
    }

    /**
     * Get all registered health checks
     *
     * @return CheckInterface[]
     */
    public function getHealthChecks(): array
    {
        return $this->healthChecks;
    }

    /**
     * Get all registered health checks
     *
     * @return CheckInterface[]
     */
    public function getHealthChecksForReaction(HealthCheckReactionInstruction $reaction): array
    {
        $checksForReaction = $reaction->getRequestedChecks();

        if ($reaction->getRequestedChecks() === []) {
            return $this->healthChecks;
        }

        return array_filter(
            $this->healthChecks,
            static fn (CheckInterface $check): bool => in_array($check->getIdentifier(), $checksForReaction, true)
        );
    }
}
