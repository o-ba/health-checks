<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Health checks',
    'description' => 'Provides health checks API',
    'category' => 'be',
    'author' => 'Oliver Bartsch',
    'author_email' => 'bo@ceddev.de',
    'state' => 'alpha',
    'version' => '0.0.1',
    'constraints' => [
        'depends' => [
            'typo3' => '12.4.0-13.99.99',
        ],
        'conflicts' => [],
        'suggests' => []
    ],
    'autoload' => [
        'psr-4' => [
            'Bo\\HealthChecks\\' => 'Classes/',
        ]
    ]
];
