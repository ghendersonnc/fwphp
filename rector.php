<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Exception\Configuration\InvalidConfigurationException;
use Rector\TypeDeclaration\Rector\ClassLike\AddVoidReturnTypeWhereNoReturnRector;

try {
    return RectorConfig::configure()
        ->withPaths([
            __DIR__ . '/fw',
            __DIR__ . '/public',
        ])
        ->withPhpSets()
        ->withTypeCoverageLevel(0)
        ->withDeadCodeLevel(0)
        ->withCodeQualityLevel(0)
        ->withRules([
            AddVoidReturnTypeWhereNoReturnRector::class
        ]);
} catch (InvalidConfigurationException $e) {
    echo $e->getMessage();
}
