<?php

declare(strict_types=1);

namespace Phonyland\Framework;

use Phonyland\Framework\Exceptions\ShouldNotHappen;
use ReflectionClass;
use ReflectionNamedType;
use ReflectionParameter;

/**
 * @internal
 *
 * @see https://github.com/pestphp/pest/blob/master/src/Support/Container.php
 */
final class Container
{
    private static Container $instance;

    /**
     * @var array<string, mixed>
     */
    private array $instances = [];

    /**
     * Gets a new or already existing container.
     */
    public static function getInstance(): self
    {
        if (! isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Gets a dependency from the container.
     *
     * @param  string  $id
     *
     * @return object
     *
     * @throws \ReflectionException
     */
    public function get(string $id): object
    {
        if (array_key_exists($id, $this->instances)) {
            return $this->instances[$id];
        }

        $this->instances[$id] = $this->build($id);

        return $this->instances[$id];
    }

    /**
     * Adds the given instance to the container.
     *
     * @param  string  $id
     * @param  mixed   $instance
     */
    public function add(string $id, mixed $instance): void
    {
        $this->instances[$id] = $instance;
    }

    /**
     * Get the class name of the given parameter's type, if possible.
     *
     * @see https://github.com/laravel/framework/blob/v6.18.25/src/Illuminate/Support/Reflector.php
     */
    public static function getParameterClassName(ReflectionParameter $parameter): ?string
    {
        $type = $parameter->getType();

        if (! $type instanceof ReflectionNamedType || $type->isBuiltin()) {
            return null;
        }

        $name = $type->getName();

        if (($class = $parameter->getDeclaringClass()) instanceof ReflectionClass) {
            if ($name === 'self') {
                return $class->getName();
            }

            if ($name === 'parent' && ($parent = $class->getParentClass()) instanceof ReflectionClass) {
                return $parent->getName();
            }
        }

        return $name;
    }

    /**
     * Tries to build the given instance.
     *
     * @throws \ReflectionException
     */
    private function build(string $id): object
    {
        $reflectionClass = new ReflectionClass($id);

        if ($reflectionClass->isInstantiable()) {
            $constructor = $reflectionClass->getConstructor();

            if ($constructor !== null) {
                $params = array_map(
                    function (ReflectionParameter $param) use ($id) {
                        $candidate = self::getParameterClassName($param);

                        if ($candidate === null) {
                            $type = $param->getType();
                            /* @phpstan-ignore-next-line */
                            if ($type !== null && $type->isBuiltin()) {
                                $candidate = $param->getName();
                            } else {
                                throw ShouldNotHappen::fromMessage(sprintf('The type of `$%s` in `%s` cannot be determined.', $id, $param->getName()));
                            }
                        }

                        return $this->get($candidate);
                    },
                    $constructor->getParameters()
                );

                return $reflectionClass->newInstanceArgs($params);
            }

            return $reflectionClass->newInstance();
        }

        throw ShouldNotHappen::fromMessage(sprintf('A dependency with the name `%s` cannot be resolved.', $id));
    }
}
