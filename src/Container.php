<?php

declare(strict_types=1);

namespace Phonyland\Framework;

/**
 * @internal
 */
final class Container
{
    /**
     * @var array<string, mixed>
     */
    private array $instances = [];

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
     * Gets a dependency from the container.
     *
     * @param class-string $id
     *
     * @return mixed
     */
    public function get(string $id): mixed
    {
        if (! array_key_exists($id, $this->instances)) {
            $this->instances[$id] = $this->build($id);
        }

        return $this->instances[$id];
    }
}
