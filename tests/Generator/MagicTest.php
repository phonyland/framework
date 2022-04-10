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
        mockMethodCalls: false,
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
        mockMethodCalls: false,
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
        mockMethodCalls: false,
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
        mockMethodCalls: false,
    );

    expect($🙃->sampleOne->basicMethod())->toBe('simple data');
});

it('can not access undefined magic attribute', function() {
    // @phpstan-ignore-next-line
    (new SampleOneGenerator('sampleOne', 🙃()))->nonExistingAttribute;
})->throws(RuntimeException::class);

it('can not set any magic attribute', function () {
    $generator = new SampleOneGenerator('sampleOne', 🙃());
    // @phpstan-ignore-next-line
    $generator->simpleAttribute = 'not-allowed';
})->throws(RuntimeException::class);
