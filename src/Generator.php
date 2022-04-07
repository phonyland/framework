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
    private array $dataPackages = [];

    public function __construct(
        public string $alias,
        protected Phony $phony,
    ) {
    }

    // region Data Packages

    /**
     * Set one or many data packages for the generator.
     *
     * @param  array|null  $dataPackages
     *
     * @return void
     */
    public function setDataPackages(?array $dataPackages = null): void
    {
        if ($dataPackages === [] || $dataPackages === null) {
            return;
        }

        foreach ($dataPackages as $locale => $dataPackage) {
            // This will overwrite previous data package if it exists
            $this->dataPackages[$locale] = $dataPackage;
        }
    }

    public function hasDataPackageForDefaultLocale(): bool
    {
        return isset($this->dataPackages[$this->phony->defaultLocale]);
    }

    // endregion

    // endregion
}
