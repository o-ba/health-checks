<?php

declare(strict_types=1);

namespace Bo\HealthChecks;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Reactions\Model\ReactionInstruction;

class HealthCheckReactionInstruction extends ReactionInstruction
{
    public static function createFromReaction(ReactionInstruction $reactionInstruction): HealthCheckReactionInstruction
    {
        return new self ($reactionInstruction->record);
    }

    public function getVersion(): string
    {
        return (string)($this->record['version'] ?? '');
    }

    public function getServiceId(): string
    {
        return (string)($this->record['service_id'] ?? '');
    }

    public function getDescription(): string
    {
        return (string)($this->record['description'] ?? '');
    }

    public function getRequestedChecks(): array
    {
        return GeneralUtility::trimExplode(',', $this->record['checks'] ?? '', true);
    }
}
