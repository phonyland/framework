<?php

declare(strict_types=1);

namespace Phonyland\Framework\Exceptions;

use Exception;
use RuntimeException;

/**
 * @internal
 */
final class ShouldNotHappen extends RuntimeException
{
    /**
     * Creates a new Exception instance.
     */
    public function __construct(Exception $exception)
    {
        parent::__construct(sprintf(<<<'MESSAGE'
                
                This should not happen. Please create a new issue here: https://github.com/phonyland/framework/issues/new
                
                - Issue: %s
                - PHP version: %s
                - Operating system: %s
                MESSAGE
            , $exception->getMessage(), PHP_VERSION, PHP_OS), 1, $exception);
    }

    /**
     * Creates a new instance of should not happen without a specific exception.
     */
    public static function fromMessage(string $message): self
    {
        return new self(new Exception($message));
    }
}
