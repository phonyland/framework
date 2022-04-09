<?php

declare(strict_types=1);

namespace Phonyland\Framework\Tests\Stubs;

use Phonyland\Framework\Generator;

class SampleOneGenerator extends Generator
{
    protected array $attributes = [
        'simpleAttribute'       => 'sampleOne.simple',
        'nestedSimpleAttribute' => 'sampleOne.nested.nested',
    ];

    protected array $attributeAliases = [
        'nestedAttributeAlias' => 'nestedSimpleAttribute',
    ];

    protected array $methodsAsAttributes = [
        'simple'       => [],
        'nestedSimple' => [],
    ];
    public function simple(): string
    {
        return $this->fetch('sampleOne.simple');
    }

    public function nestedSimple(): string
    {
        return $this->fetch('sampleOne.nested.nested');
    }
}
