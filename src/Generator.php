<?php

declare(strict_types=1);

namespace Phonyland\Framework;

abstract class Generator
{
    public function __construct(
        protected Phony $phony
    ) {
    }
}
