<?php

declare(strict_types=1);

use Phonyland\Framework\Tests\Stubs\SampleOneGenerator;

it('has magic attributes', function (): void {
    [$🙃] = fakeGeneratorWithData(
        generatorClass: SampleOneGenerator::class,
        phonyInstance: 🙃(),
        alias: 'sampleOne',
        packageName: 'sample-one',
        dataFilePaths: [['simple']],
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
        dataFilePaths: [['nested', 'nested']],
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
        dataFilePaths: [['simple']],
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
        dataFilePaths: [['simple']],
        methodNames: ['simple'],
        mockMethodCalls: false,
    );

    expect($🙃->sampleOne->basicMethod())->toBe('simple data');
});

it('can not access undefined magic attributes', function() {
    // @phpstan-ignore-next-line
    (new SampleOneGenerator('sampleOne', 'phonyland/sample-one-generator', 🙃()))->nonExistingAttribute;
})->throws(RuntimeException::class);

it('can not set any magic attribute', function () {
    $generator = new SampleOneGenerator('sampleOne', 'phonyland/sample-one-generator', 🙃());
    // @phpstan-ignore-next-line
    $generator->simpleAttribute = 'not-allowed';
})->throws(RuntimeException::class);

it('can check the existence of a magic attribute', function () {
    $generator = new SampleOneGenerator('sampleOne', 'phonyland/sample-one-generator', 🙃());

    expect(isset($generator->simpleAttribute))->toBeTrue();
    expect(isset($generator->nonExistingAttribute))->toBeFalse();
});

it('can not access undefined magic methods', function() {
    // @phpstan-ignore-next-line
    (new SampleOneGenerator('sampleOne', 'phonyland/sample-one-generator', 🙃()))->nonExistingMethod();
})->throws(RuntimeException::class);
