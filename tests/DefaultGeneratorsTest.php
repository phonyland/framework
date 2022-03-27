<?php

declare(strict_types=1);

it('has the number generator')
    ->expect(🙃()->number->boolean())
    ->toBeEmpty()
    ->not();
