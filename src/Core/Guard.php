<?php

declare(strict_types=1);

namespace Mede\Defense\Core;

use InvalidArgumentException;

/** @package Mede\Defense\Core */
final class Guard
{
    /**
     * @param bool $condition 
     * @param string $message 
     * @param string $exception 
     * @return void 
     */
    public static function against(bool $condition, string $message, string $exception = InvalidArgumentException::class): void
    {
        if ($condition) {
            throw new $exception($message);
        }
    }

    /**
     * @param mixed $value 
     * @param string $message 
     * @return void 
     */
    public static function notNull(mixed $value, string $message = 'Value cannot be null'): void
    {
        self::against($value === null, $message);
    }

    /**
     * @param int $value 
     * @param string $message 
     * @return void 
     */
    public static function positiveInt(int $value, string $message = 'Value must be > 0'): void
    {
        self::against($value <= 0, $message);
    }
}
