<?php

declare(strict_types=1);

namespace Phonyland\Framework;

use Phonyland\GeneratorManager\Container;
use RuntimeException;

class Phony
{
    private Container $container;

    public function __construct()
    {
        $this->container = new Container();
    }

    /**
     * @throws \Exception
     */
    public function __get(string $name): mixed
    {
        return $this->container->get($name);
    }

    public function __set(string $name, string $value): void
    {
        throw new RuntimeException('Not allowed');
    }

    public function __isset(string $name): bool
    {
        return $this->container->has($name);
    }
}
