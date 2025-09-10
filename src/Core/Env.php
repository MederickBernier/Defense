<?php

declare(strict_types=1);

namespace Mede\Defense\Core;

use RuntimeException;

/** @package Mede\Defense\Core */
final class Env
{
    /**
     * @param string $key 
     * @return string 
     * @throws RuntimeException 
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
     * @param string $key 
     * @param int $default 
     * @return int 
     */
    public static function int(string $key, int $default = 0): int
    {
        $v = getenv($key);
        return $v === false ? $default : (int)$v;
    }
}
