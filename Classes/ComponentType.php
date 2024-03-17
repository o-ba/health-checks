<?php

declare(strict_types=1);

namespace Bo\HealthChecks;

enum ComponentType: string
{
    case System = 'system';
    case Component = 'component';
    case DataStorage = 'datastorage';
}
