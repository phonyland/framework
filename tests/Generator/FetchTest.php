<?php

declare(strict_types=1);

use Phonyland\Framework\Tests\Stubs\SampleOneGenerator;

it('can fetch simple data files', function (): void {
    [$🙃] = fakeGeneratorWithData(
        generatorClass: SampleOneGenerator::class,
        phonyInstance: 🙃(),
        alias: 'sampleOne',
        packageName: 'sample-one',
        dataFilePaths: [[1 => 'simple']],
        methodNames: ['simple']
    );

    expect($🙃->sampleOne->simple())->toBe('simple data');
});

it('can fetch nested data files', function (): void {
    [$🙃] = fakeGeneratorWithData(
        generatorClass: SampleOneGenerator::class,
        phonyInstance: 🙃(),
        alias: 'sampleOne',
        packageName: 'sample-one',
        dataFilePaths: [[1 => 'nested', 2 => 'nested']],
        methodNames: ['nestedSimple']
    );

    expect($🙃->sampleOne->nestedSimple())->toBe('nested simple data');
});
