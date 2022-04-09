<?php

declare(strict_types=1);

use Phonyland\Framework\Tests\Stubs\SampleOneGenerator;

it('has magic attributes', function (): void {
    [$🙃] = fakeGeneratorWithData(
        generatorClass: SampleOneGenerator::class,
        phonyInstance: 🙃(),
        alias: 'sampleOne',
        packageName: 'sample-one',
        dataFilePaths: [[1 => 'simple']],
        methodNames: ['simple'],
        noMethodCall: true,
    );

    expect($🙃->sampleOne->simpleAttribute)->toBe('simple data');
});

it('has magic attributes as aliases', function (): void {
    [$🙃] = fakeGeneratorWithData(
        generatorClass: SampleOneGenerator::class,
        phonyInstance: 🙃(),
        alias: 'sampleOne',
        packageName: 'sample-one',
        dataFilePaths: [[1 => 'nested', 2 => 'nested']],
        methodNames: ['nestedSimple'],
        noMethodCall: true,
    );

    expect($🙃->sampleOne->nestedAttributeAlias)->toBe('nested simple data');
});

it('has magic methods as attributes', function (): void {
    [$🙃] = fakeGeneratorWithData(
        generatorClass: SampleOneGenerator::class,
        phonyInstance: 🙃(),
        alias: 'sampleOne',
        packageName: 'sample-one',
        dataFilePaths: [[1 => 'simple']],
        methodNames: ['simple'],
        noMethodCall: true,
    );

    expect($🙃->sampleOne->simple)->toBe('simple data');
});

it('has magic method aliases', function (): void {
    [$🙃] = fakeGeneratorWithData(
        generatorClass: SampleOneGenerator::class,
        phonyInstance: 🙃(),
        alias: 'sampleOne',
        packageName: 'sample-one',
        dataFilePaths: [[1 => 'simple']],
        methodNames: ['simple'],
        noMethodCall: true,
    );

    expect($🙃->sampleOne->basicMethod())->toBe('simple data');
});
