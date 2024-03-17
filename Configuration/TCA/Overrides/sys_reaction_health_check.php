<?php

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTcaSelectItem(
    'sys_reaction',
    'reaction_type',
    [
        'label' => \Bo\HealthChecks\HealthCheckReaction::getDescription(),
        'value' => \Bo\HealthChecks\HealthCheckReaction::getType(),
        'icon' => \Bo\HealthChecks\HealthCheckReaction::getIconIdentifier(),
    ]
);

$GLOBALS['TCA']['sys_reaction']['ctrl']['typeicon_classes'][\Bo\HealthChecks\HealthCheckReaction::getType()] =
    \Bo\HealthChecks\HealthCheckReaction::getIconIdentifier();

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns(
    'sys_reaction',
    [
        'version' => [
            'label' => 'LLL:EXT:health_checks/Resources/Private/Language/locallang_db.xlf:sys_reaction.health_checks.version',
            'config' => [
                'type' => 'input',
                'required' => true,
                'size' => 30,
                'eval' => 'trim',
            ],
        ],
        'service_id' => [
            'label' => 'LLL:EXT:health_checks/Resources/Private/Language/locallang_db.xlf:sys_reaction.health_checks.service_id',
            'config' => [
                // @todo Make this a custom form type to select a page
                'type' => 'input',
                'required' => true,
                'size' => 30,
                'eval' => 'trim',
            ],
        ],
        'checks' => [
            'label' => 'LLL:EXT:health_checks/Resources/Private/Language/locallang_db.xlf:sys_reaction.health_checks.checks',
            'description' => 'LLL:EXT:health_checks/Resources/Private/Language/locallang_db.xlf:sys_reaction.health_checks.checks.description',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectMultipleSideBySide',
                'itemsProcFunc' => \Bo\HealthChecks\Tca\CheckItems::class . '->getItems',
                'minitems' => 0,
                'maxitems' => 10,
                'autoSizeMax' => 10,
                'default' => '',
            ],
        ],
    ]
);


$GLOBALS['TCA']['sys_reaction']['palettes']['healthCheck'] = [
    'label' => 'LLL:EXT:health_checks/Resources/Private/Language/locallang_db.xlf:sys_reaction.paletttes.healthCheck',
    'showitem' => 'version, service_id, --linebreak--, checks',
];


$GLOBALS['TCA']['sys_reaction']['types'][\Bo\HealthChecks\HealthCheckReaction::getType()] = [
    'showitem' => '
        --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
        --palette--;;config,
        --palette--;;healthCheck,
        --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access,
        --palette--;;access',
    'columnsOverrides' => [
        'description' => [
            'config' => [
                'required' => true,
            ]
        ]
    ]
];
