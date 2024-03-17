<?php

declare(strict_types=1);

namespace Bo\HealthChecks;


use CmsHealth\Definition\CheckInterface;
use CmsHealth\Definition\HealthCheckInterface;
use CmsHealth\Definition\HealthCheckStatus;

class HealthCheck implements HealthCheckInterface, \JsonSerializable
{
    /**
     * @param CheckInterface[] $checks
     */
    public function __construct(
        private readonly HealthCheckStatus $status,
        private readonly string $version,
        private readonly string $serviceId,
        private readonly string $description,
        private readonly array $checks,
    ) {}

    public static function createFromReaction(
        HealthCheckReactionInstruction $reactionInstruction,
        array $healthChecks,
    ): self {
        return new self(
            self::resolveHealthCheckStatus($healthChecks),
            $reactionInstruction->getVersion(),
            $reactionInstruction->getServiceId(),
            $reactionInstruction->getDescription(),
            $healthChecks
        );
    }

    public function getStatus(): HealthCheckStatus
    {
        return $this->status;
    }

    public function getVersion(): string
    {
        return $this->version;
    }

    public function getServiceId(): string
    {
        return $this->serviceId;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return array<string, CheckInterface>
     */
    public function getChecks(): array
    {
        return $this->checks;
    }

    public function jsonSerialize(): array
    {
        return [
            'status' => $this->status->value,
            'version' => $this->version,
            'serviceId' => $this->serviceId,
            'description' => $this->description,
            'checks' => $this->checks,
        ];
    }

    protected static function resolveHealthCheckStatus(array $healthChecks): HealthCheckStatus
    {
        $status = HealthCheckStatus::Pass;

        /** @var CheckInterface $healthCheck */
        foreach ($healthChecks as $healthCheck) {
            foreach ($healthCheck->getCheckResults() as $result) {
                if ($result->getStatus()->value === HealthCheckStatus::Pass->value) {
                    continue;
                }

                if ($status === HealthCheckStatus::Pass) {
                    $status = HealthCheckStatus::tryFrom($result->getStatus()->value) ?? $status;
                }
            }
        }

        return $status;
    }
}
