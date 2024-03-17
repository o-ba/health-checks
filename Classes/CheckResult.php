<?php

declare(strict_types=1);

namespace Bo\HealthChecks;

use CmsHealth\Definition\CheckResultInterface;
use CmsHealth\Definition\CheckResultStatus;
use TYPO3\CMS\Core\Type\ContextualFeedbackSeverity;
use TYPO3\CMS\Reports\Status;

/**
 * A class representing a certain health status
 */
class CheckResult implements CheckResultInterface, \JsonSerializable
{
    public function __construct(
        private readonly string $componentId,
        private readonly ComponentType $componentType,
        private readonly CheckResultStatus $status,
        private readonly string $observedValue,
        private readonly string $output = '',
        private readonly ?string $observedUnit = null,
        private ?\DateTime $time = null,
    ) {
        $this->time = $this->time ?? new \DateTime('now');
    }

    public static function createFromStatus(Status $status, string $componentId, ComponentType $componentType, ?string $observedUnit = null): self
    {
        return new self(
            $componentId,
            $componentType,
            self::getCheckResultStatus($status->getSeverity()),
            $status->getValue(),
            $status->getMessage(),
            $observedUnit
        );
    }

    public function getComponentId(): string
    {
        return $this->componentId;
    }

    public function getComponentType(): string
    {
        return $this->componentType->value;
    }

    public function getStatus(): CheckResultStatus
    {
        return $this->status;
    }

    public function getObservedValue(): string
    {
        return $this->observedValue;
    }

    public function getObservedUnit(): string|null
    {
        return $this->observedUnit;
    }

    public function getOutput(): string
    {
        return $this->output;
    }

    public function getTime(): \DateTime
    {
        return $this->time;
    }

    protected static function getCheckResultStatus(ContextualFeedbackSeverity $contextualFeedbackSeverity): CheckResultStatus
    {
        return match ($contextualFeedbackSeverity) {
            ContextualFeedbackSeverity::NOTICE, ContextualFeedbackSeverity::INFO => CheckResultStatus::Info,
            ContextualFeedbackSeverity::OK => CheckResultStatus::Pass,
            ContextualFeedbackSeverity::WARNING => CheckResultStatus::Warn,
            ContextualFeedbackSeverity::ERROR => CheckResultStatus::Fail,
        };
    }

    public function jsonSerialize(): array
    {
        $result = [
            'componentId' => $this->componentId,
            'componentType' => $this->componentType,
            'observedValue' => $this->observedValue,
            'status' => $this->status,
            'time' => $this->time->format('c'),
            'output' => $this->output,
        ];

        if ($this->observedUnit !== null) {
            $result['observedUnit'] = $this->observedUnit;
        }

        return $result;
    }
}
