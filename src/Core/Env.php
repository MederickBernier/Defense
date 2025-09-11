<?php

declare(strict_types=1);

namespace Mede\Defense\Core;

final class Env
{
    /**
     * Retrieves the value of the specified environment variable as a string.
     *
     * @param string $key The name of the environment variable to retrieve.
     * @return string The value of the environment variable.
     * @throws \RuntimeException If the environment variable is missing or empty.
     */
    public static function str(string $key): string
    {
        $v = getenv($key);
        if ($v === false || $v === '') {
            throw new \RuntimeException("Missing env {$key}");
        }
        return $v;
    }

    /**
     * Retrieves an environment variable as an integer.
     *
     * Attempts to get the value of the specified environment variable by key.
     * If the variable is not set or retrieval fails, returns the provided default value.
     * Otherwise, casts the value to an integer and returns it.
     *
     * @param string $key The name of the environment variable to retrieve.
     * @param int $default The default value to return if the environment variable is not set. Defaults to 0.
     * @return int The integer value of the environment variable, or the default value if not set.
     */
    public static function int(string $key, int $default = 0): int
    {
        $v = getenv($key);
        return $v === false ? $default : (int)$v;
    }
}
