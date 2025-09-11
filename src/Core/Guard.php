<?php

declare(strict_types=1);

namespace Mede\Defense\Core;

use InvalidArgumentException;
use LogicException;
use Throwable;

final class Guard
{
    /**
     * @param class-string<Throwable> $exception
     */
    public static function against(
        bool $condition,
        string $message,
        string $exception = InvalidArgumentException::class
    ): void {
        if ($condition) {
            if (!is_subclass_of($exception, Throwable::class)) {
                throw new LogicException('Exception must extend Throwable');
            }
            /** @var class-string<Throwable> $exception */
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
