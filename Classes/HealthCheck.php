<?php

declare(strict_types=1);

namespace Bo\HealthChecks;

use CmsHealthProject\SerializableReferenceImplementation\CheckCollection;

class HealthCheck extends \CmsHealthProject\SerializableReferenceImplementation\HealthCheck
{
    public static function createFromReaction(
        HealthCheckReactionInstruction $reactionInstruction,
        CheckCollection $healthChecks,
    ): self {
        return new self(
            $reactionInstruction->getVersion(),
            $reactionInstruction->getServiceId(),
            $reactionInstruction->getDescription(),
            new \DateTimeImmutable('now'),
            $healthChecks,
        );
    }
}
