<?php

declare(strict_types=1);

use PhpCsFixer\Finder;

$finder = Finder::create()
                ->in(__DIR__.DIRECTORY_SEPARATOR.'tests')
                ->in(__DIR__.DIRECTORY_SEPARATOR.'src')
                ->ignoreDotFiles(true)
                ->ignoreVCS(true);

return Phonyland\styles($finder);
