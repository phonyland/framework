<?php

declare(strict_types=1);

namespace Phonyland\Framework;

use Stringable;

class Pipe implements Stringable
{
    private function __construct(public mixed $value)
    {
    }

    public static function from(mixed $value): self
    {
        return new self($value);
    }

    public function __toString(): string
    {
        return (string) $this->value;
    }

    public function __invoke(callable $param): static
    {
        $this->value = $param($this->value);

        return $this;
    }
}
