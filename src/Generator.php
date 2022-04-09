<?php

declare(strict_types=1);

namespace Phonyland\Framework;

use Phonyland\Framework\Exceptions\ShouldNotHappen;

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

    public function getDataPackages(): array
    {
        return $this->dataPackages;
    }

    public function hasDataPackageForDefaultLocale(): bool
    {
        return isset($this->dataPackages[$this->phony->defaultLocale]);
    }

    // endregion

    // region Fetching

    protected function buildDataPath(array $dataPathParts): string
    {
        return getcwd() .
            '/vendor/' .
            $this->dataPackages[$this->phony->defaultLocale] .
            '/data/' .
            implode('/', $dataPathParts) .
            '.php';
    }

    protected function fetch(string $path): mixed
    {
        [$dataPath, $inlinePath] = explode('::', $path) + [1 => null];
        $dataPathParts = explode('.', $dataPath);
        $alias = $dataPathParts[0];
        unset($dataPathParts[0]);

        if (! $this->hasDataPackageForDefaultLocale()) {
            throw ShouldNotHappen::fromMessage("The generator $this->alias does not have any data file for the {$this->phony->defaultLocale} locale.");
        }

        $filePath = $this->buildDataPath($dataPathParts);

        if (! file_exists($filePath)) {
            throw ShouldNotHappen::fromMessage("Data file does not exist at path $filePath");
        }

        $data = require $filePath;

        return is_array($data)
            ? $data[array_rand($data)]
            : $data;
    }

    // endregion
}
