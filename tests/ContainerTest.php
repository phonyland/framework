<?php

declare(strict_types=1);

use Phonyland\Framework\Container;

beforeEach(function () {
    $this->container = new Container();
});

it('exists')->assertTrue(class_exists(Container::class));

it('gets an instance', function () {
    // Arrange
    $this->container->add(Container::class, $this->container);

    // Act
    expect($this->container->get(Container::class))->toBe($this->container);
});

test('autowire', function () {
    expect($this->container->get(Container::class))->toBeInstanceOf(Container::class);
});

it('creates an instance and resolves parameters', function () {
    $this->container->add(Container::class, $this->container);
    $instance = $this->container->get(ClassWithDependency::class);

    expect($instance)->toBeInstanceOf(ClassWithDependency::class);
});

class ClassWithDependency
{
    public function __construct(Container $container)
    {
    }
}