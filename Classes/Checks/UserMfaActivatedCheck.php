<?php

declare(strict_types=1);

namespace Bo\HealthChecks\Checks;

use Bo\HealthChecks\CheckResult;
use Bo\HealthChecks\ComponentType;
use CmsHealth\Definition\CheckResultStatus;
use TYPO3\CMS\Core\Authentication\BackendUserAuthentication;
use TYPO3\CMS\Core\Authentication\Mfa\MfaProviderRegistry;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class UserMfaActivatedCheck extends AbstractCheck
{
    public string $componentName = 'TYPO3';
    public string $measurementName = 'UserMfaActivated';

    public function getCheckResults(): array
    {
        return array_map(
            fn (array $user): CheckResult => $this->getUserMfaResult($user),
            // @todo Use DI
            GeneralUtility::makeInstance(ConnectionPool::class)->getConnectionForTable('be_users')->select(['uid', 'username'], 'be_users')->fetchAllAssociative()
        );
    }

    protected function getUserMfaResult(array $user): CheckResult
    {
        $backendUser = GeneralUtility::makeInstance(BackendUserAuthentication::class);
        $backendUser->enablecolumns = ['deleted' => true];
        $backendUser->setBeUserByUid($user['uid']);

        // @todo Use DI
        $mfaProviderRegistry = GeneralUtility::makeInstance(MfaProviderRegistry::class);

        if (
            !$mfaProviderRegistry->hasActiveProviders($backendUser)
            || $mfaProviderRegistry->hasLockedProviders($backendUser)
        ) {
            return new CheckResult(
                'dfd6cf2b-1b6e-4412-a0b8-f6f7797a60d' . md5((string)json_encode($user)),
                ComponentType::System,
                CheckResultStatus::Warn,
                $user['username'],
                'User ' . $user['username'] . ' has not activated MFA',
            );
        }

        return new CheckResult(
            'dfd6cf2b-1b6e-4412-a0b8-f6f7797a60d' . md5((string)json_encode($user)),
            ComponentType::System,
            CheckResultStatus::Pass,
            $user['username'],
        );
    }
}
