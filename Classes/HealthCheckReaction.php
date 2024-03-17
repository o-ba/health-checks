<?php

declare(strict_types=1);

namespace Bo\HealthChecks;

use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamFactoryInterface;
use TYPO3\CMS\Reactions\Model\ReactionInstruction;
use TYPO3\CMS\Reactions\Reaction\ReactionInterface;

/**
 * A reaction that creates a health check report
 */
class HealthCheckReaction implements ReactionInterface
{
    public function __construct(
        private HealthCheckRegistry $healthCheckRegistry,
        private ResponseFactoryInterface $responseFactory,
        private StreamFactoryInterface $streamFactory,
    ) {}

    public static function getType(): string
    {
        return 'health-check';
    }

    public static function getDescription(): string
    {
        return 'Create a health check report';
    }

    public static function getIconIdentifier(): string
    {
        return 'module-reports';
    }

    public function react(ServerRequestInterface $request, array $payload, ReactionInstruction $reaction): ResponseInterface
    {
        $healthCheckReaction = HealthCheckReactionInstruction::createFromReaction($reaction);

        $healthCheck = HealthCheck::createFromReaction(
            $healthCheckReaction,
            $this->healthCheckRegistry->getHealthChecksForReaction($healthCheckReaction)
        );

        return $this->responseFactory
            ->createResponse()
            ->withHeader('Content-Type', 'application/json')
            ->withBody(
                $this->streamFactory->createStream((string)json_encode($healthCheck))
            );
    }
}
