<?php

declare(strict_types=1);

namespace Phonyland\Framework;

abstract class Generator
{
    /**
     * Holds the list of data packages for the generator.
     *
     * @var array<string, string>
     */
    protected array $dataPackages = [];

    public function __construct(
        protected Phony $phony
    ) {
    }
}
