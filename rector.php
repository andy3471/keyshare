<?php

declare(strict_types=1);

use Rector\CodeQuality\Rector\If_\ExplicitBoolCompareRector;
use Rector\CodingStyle\Rector\Encapsed\EncapsedStringsToSprintfRector;
use Rector\Config\RectorConfig;
use Rector\Set\ValueObject\SetList;
use Rector\Strict\Rector\If_\BooleanInIfConditionRuleFixerRector;
use RectorLaravel\Rector\Class_\AddExtendsAnnotationToModelFactoriesRector;
use RectorLaravel\Rector\ClassMethod\AddGenericReturnTypeToRelationsRector;
use RectorLaravel\Rector\FuncCall\FactoryFuncCallToStaticCallRector;
use RectorLaravel\Rector\FuncCall\NowFuncWithStartOfDayMethodCallToTodayFuncRector;
use RectorLaravel\Rector\MethodCall\EloquentOrderByToLatestOrOldestRector;
use RectorLaravel\Rector\MethodCall\RedirectBackToBackHelperRector;
use RectorLaravel\Rector\MethodCall\RedirectRouteToToRouteHelperRector;
use RectorLaravel\Rector\MethodCall\ValidationRuleArrayStringValueToArrayRector;
use RectorLaravel\Set\LaravelLevelSetList;
use RectorLaravel\Set\LaravelSetList;

return RectorConfig::configure()
    ->withPaths([
        __DIR__.'/app',
        __DIR__.'/bootstrap',
        __DIR__.'/config',
        __DIR__.'/public',
        __DIR__.'/resources',
        __DIR__.'/routes',
        __DIR__.'/tests',
    ])
    ->withSets([
        SetList::CODE_QUALITY,
        SetList::CODING_STYLE,
        SetList::STRICT_BOOLEANS,
        SetList::DEAD_CODE,
        SetList::TYPE_DECLARATION,
        SetList::EARLY_RETURN,
        SetList::CARBON,
        SetList::INSTANCEOF,
        LaravelLevelSetList::UP_TO_LARAVEL_110,
        LaravelSetList::LARAVEL_CODE_QUALITY,
        LaravelSetList::LARAVEL_COLLECTION,
        LaravelSetList::LARAVEL_IF_HELPERS,
        LaravelSetList::LARAVEL_LEGACY_FACTORIES_TO_CLASSES,

    ])
    ->withRules([
        EloquentOrderByToLatestOrOldestRector::class,
        RedirectRouteToToRouteHelperRector::class,
        ValidationRuleArrayStringValueToArrayRector::class,
        RedirectBackToBackHelperRector::class,
        NowFuncWithStartOfDayMethodCallToTodayFuncRector::class,
        FactoryFuncCallToStaticCallRector::class,
        AddExtendsAnnotationToModelFactoriesRector::class,
        AddGenericReturnTypeToRelationsRector::class,
    ])
    ->withSkip([
        EncapsedStringsToSprintfRector::class,
        ExplicitBoolCompareRector::class,
        BooleanInIfConditionRuleFixerRector::class,
    ]);
