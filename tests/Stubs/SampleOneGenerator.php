<?php

declare(strict_types=1);

namespace Phonyland\Framework\Tests\Stubs;

use Phonyland\Framework\Generator;

class SampleOneGenerator extends Generator
{
    public function simple(): string
    {
        return $this->fetch('sampleOne.simple');
    }

    public function nestedSimple(): string
    {
        return $this->fetch('sampleOne.nested.nested');
    }
}
