<?php

declare(strict_types=1);

namespace Mede\Defense\Core;

use InvalidArgumentException;

final class Guard
{
    public static function against(bool $condition, string $message, string $exception = InvalidArgumentException::class): void
    {
        if ($condition) {
            throw new $exception($message);
        }
    }

    public static function notNull(mixed $value, string $message = 'Value cannot be null'): void
    {
        self::against($value === null, $message);
    }

    public static function positiveInt(int $value, string $message = 'Value must be > 0'): void
    {
        self::against($value <= 0, $message);
    }
}
