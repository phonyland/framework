<?php

declare(strict_types=1);

use Phonyland\Framework\Locale;
use Phonyland\Framework\Phony;

function 🙃(
    string $defaultLocale = Locale::English,
    ?int $seed = null
): Phony {
    return new Phony($defaultLocale, $seed);
}
}

if (! function_exists('dd')) {
    function dd(): void
    {
        call_user_func_array('dump', func_get_args());
        die();
    }
}

if (! function_exists('d')) {
    function d(): void
    {
        call_user_func_array('dump', func_get_args());
    }
}
