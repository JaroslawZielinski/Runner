<?php

declare(strict_types=1);

namespace JaroslawZielinski\Runner\Plugins;

class DotEnvSettings
{
    /**
     * @var array
     */
    private $dotEnvArray;

    /**
     * @param array $dotEnvArray
     */
    public function __construct(array $dotEnvArray)
    {
        $this->dotEnvArray = $dotEnvArray;
    }

    public function get(string $dotEnvKey): ?string
    {
        return $this->dotEnvArray[$dotEnvKey] ?? null;
    }
}
