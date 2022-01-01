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
