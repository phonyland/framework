<?php

declare(strict_types=1);

namespace Phonyland\Framework;

use Flow\JSONPath\JSONPath;
use Phonyland\Framework\Exceptions\ShouldNotHappen;
use RuntimeException;

abstract class Generator
{
    /**
     * The name of attributes and their fetching paths.
     *
     * @var array<string, string>
     */
    protected array $attributes;

    /**
     * The attribute aliases.
     *
     * @var array<string, string>
     */
    protected array $attributeAliases;

    /**
     * The method aliases to use methods as attributes.
     *
     * @var array<string, array<mixed>>
     */
    protected array $methodsAsAttributes;

    /**
     * The method aliases.
     *
     * @var array<string, string>
     */
    protected array $methodAliases;

    /**
     * Holds the list of data packages for the generator.
     *
     * @var array<string, string>
     */
    private array $dataPackages = [];

    public function __construct(
        public string $alias,
        public string $name,
        protected Phony $phony,
    ) {
    }

    // region Magic Setup

    /**
     * Calls a magic attribute.
     *
     * @param  string  $name
     *
     * @return mixed
     */
    public function __get(string $name): mixed
    {
        // If it's a magic attribute
        if (isset($this->attributes[$name])) {
            return $this->fetch($this->attributes[$name]);
        }

        // If it's a magic attribute alias
        if (isset($this->attributeAliases[$name])) {
            return $this->fetch($this->attributes[$this->attributeAliases[$name]]);
        }

        // If it's a magic attribute for a method
        if (isset($this->methodsAsAttributes[$name]) && method_exists($this, $name)) {
            return call_user_func_array([$this, $name], $this->methodsAsAttributes[$name]);
        }

        throw new RuntimeException("The $name attribute is not defined!");
    }

    /**
     * Setting a magic attribute is not allowed.
     *
     * @param  string  $name
     * @param  mixed   $value
     *
     * @return void
     */
    public function __set(string $name, mixed $value): void
    {
        throw new RuntimeException("Setting $name attribute is not allowed!");
    }

    /**
     * Checks if a magic attribute exists.
     *
     * @param  string  $name
     *
     * @return bool
     */
    public function __isset(string $name)
    {
        // If it's a magic attribute
        if (isset($this->attributes[$name])) {
            return true;
        }

        // If it's a magic attribute alias
        if (isset($this->attributeAliases[$name])) {
            return true;
        }

        // If it's a magic attribute for a method
        if (isset($this->methodsAsAttributes[$name]) && method_exists($this, $name)) {
            return true;
        }

        return false;
    }

    /**
     * Calls a magic method.
     *
     * @param  string  $name
     * @param  array<mixed>   $arguments
     *
     * @return mixed
     */
    public function __call(string $name, array $arguments): mixed
    {
        if (isset($this->methodAliases[$name])) {
            return call_user_func_array([$this, $this->methodAliases[$name]], $arguments);
        }

        throw new RuntimeException("The $name method is not defined!");
    }

    // endregion

    // region Fetching

    /**
     * Builds the file path for the generator data file.
     *
     * @param  array<string>  $dataPathParts
     *
     * @return string
     */
    protected function buildDataPath(array $dataPathParts): string
    {
        return getcwd() .
            '/vendor/' .
            $this->dataPackages[$this->phony->defaultLocale] .
            '/data/' .
            implode('/', $dataPathParts) .
            '.php';
    }

    /**
     * Fetches data by given path.
     *
     * @param  string  $path
     *
     * @return mixed
     * @throws \Flow\JSONPath\JSONPathException
     */
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

        if ($inlinePath !== null) {
            $data = (new JSONPath($data))->find($inlinePath)->getData();
        }

        return is_array($data)
            ? $data[array_rand($data)]
            : $data;

    }

    // endregion

    // region Data Packages

    /**
     * Set one or many data packages for the generator.
     *
     * @param  array<string, string>|null  $dataPackages
     *
     * @return void
     */
    public function setDataPackages(?array $dataPackages = null): void
    {
        if ($dataPackages === [] || $dataPackages === null) {
            return;
        }

        foreach ($dataPackages as $locale => $dataPackage) {
            // This will overwrite previous data package if it already exists
            $this->dataPackages[$locale] = $dataPackage;
        }
    }

    /**
     * Returns the data packages for the generator.
     *
     * @return array<string, string>
     */
    public function getDataPackages(): array
    {
        return $this->dataPackages;
    }

    public function hasDataPackageForDefaultLocale(): bool
    {
        return isset($this->dataPackages[$this->phony->defaultLocale]);
    }

    // endregion
}
