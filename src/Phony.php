<?php

declare(strict_types=1);

namespace Phonyland\Framework;

use Phonyland\GeneratorManager\Container;
use RuntimeException;

/**
 * Class Phony.
 *
 * @property-read \Phonyland\NumberGenerator\NumberGenerator     $number
 * @property-read \Phonyland\SequenceGenerator\SequenceGenerator $sequence
 * @property-read \Phonyland\CoinGenerator\CoinGenerator         $coin
 */
class Phony
{
    public Container $container;

    public function __construct(
        public string $defaultLocale = Locale::English,
        protected ?int $seed = null
    ) {
        $this->container = new Container($this);

        // Set seed and feed the Mersenne Twister Random Number Generator
        $this->seed = $seed ?? mt_rand(0, mt_getrandmax());
        mt_srand($this->seed);
    }

    /**
     * @throws \Exception
     */
    public function __get(string $name): Generator
    {
        return $this->container->get($name);
    }

    public function __set(string $name, string $value): void
    {
        throw new RuntimeException('Not allowed to set any generators');
    }

    public function __isset(string $name): bool
    {
        return $this->container->has($name);
    }
}
