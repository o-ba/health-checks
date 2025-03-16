<?php

declare(strict_types=1);

namespace Bo\HealthChecks;

use CmsHealth\Definition\CheckResultStatus;
use TYPO3\CMS\Core\Type\ContextualFeedbackSeverity;
use TYPO3\CMS\Reports\Status;

/**
 * A class representing a certain health status
 */
class CheckResult extends \CmsHealthProject\SerializableReferenceImplementation\CheckResult
{
    public static function createFromStatus(Status $status, string $componentId, ComponentType $componentType, ?string $observedUnit = null): self
    {
        return new self(
            self::getCheckResultStatus($status->getSeverity()),
            $componentId,
            $componentType->value,
            new \DateTimeImmutable('now'),
            $status->getValue(),
            $status->getMessage(),
            $observedUnit
        );
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
}
