<?php

declare(strict_types=1);

use Phonyland\Framework\Phony;
use Phonyland\Framework\Locale;
use Phonyland\Framework\Generator;

function 🙃(
    string $defaultLocale = Locale::English,
    int $seed = null
): Phony {
    return new Phony($defaultLocale, $seed);
}

/**
 * @param  array<string>  $dataFilePaths
 * @param  array<string>  $methodNames
 *
 * @return array{0: Phony, 1: Generator}
 */
function fakeGeneratorWithData(
    string $generatorClass,
    Phony $phonyInstance,
    string $alias,
    string $packageName,
    array $dataFilePaths,
    array $methodNames,
    bool $mockMethodCalls = true,
    bool $mockBuildDataPath = true,
): array {
    /** @var \Mockery\MockInterface|Generator $generator */
    $generator = Mockery::mock($generatorClass, [$alias, $packageName, $phonyInstance])
        ->shouldAllowMockingProtectedMethods()
        ->makePartial();

    if ($mockMethodCalls === true) {
        foreach ($methodNames as $methodName) {
            $generator->shouldReceive($methodName)
                ->once()
                ->passthru();
        }
    }

    if ($mockBuildDataPath === true) {
        /** @var array<string> $dataFilePath */
        foreach ($dataFilePaths as $dataFilePath) {
            $generator
                ->shouldReceive('buildDataPath')
                ->once()
                ->with($dataFilePath)
                ->andReturn(getcwd().'/tests/Stubs/data/'.implode('/', $dataFilePath).'.php');
        }
    }

    $generator->setDataPackages(['en' => "phonyland-data-fake/{$packageName}"]);

    $phonyInstance->container->set($alias, $generator);

    return [$phonyInstance, $generator];
}

if (!function_exists('dd')) {
    function dd(): void
    {
        call_user_func_array('dump', func_get_args());
        exit();
    }
}

if (!function_exists('d')) {
    function d(): void
    {
        call_user_func_array('dump', func_get_args());
    }
}
