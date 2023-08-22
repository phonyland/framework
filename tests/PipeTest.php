<?php

declare(strict_types=1);

use Phonyland\Framework\Pipe;

it('can pipe through values', function (): void {
    $pipe = Pipe::from(2);

    $callCount = random_int(2, 10);

    for ($i = 1; $i <= $callCount; $i++) {
        $pipe(fn ($value) => $value * 2);
    }

    expect($pipe->value)->toBe(2 ** ($callCount + 1));
});

it('is stringable', function (): void {
    $pipe = Pipe::from(5);

    expect($pipe)->toBeInstanceOf(Stringable::class);
});
