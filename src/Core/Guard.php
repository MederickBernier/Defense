<?php

declare(strict_types=1);

namespace Mede\Defense\Core;

use InvalidArgumentException;
use LogicException;
use Throwable;

final class Guard
{
    /**
     * Throws an exception if the given condition is true.
     *
     * @param bool $condition The condition to evaluate. If true, an exception is thrown.
     * @param string $message The exception message to use if the condition is true.
     * @param string $exception The fully qualified class name of the exception to throw. Must extend Throwable.
     *
     * @throws Throwable If the condition is true, throws the specified exception with the provided message.
     * @throws LogicException If the specified exception class does not extend Throwable.
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

    /**
     * Ensures that the given value is not null.
     *
     * Throws an exception with the provided message if the value is null.
     *
     * @param mixed $value The value to check for null.
     * @param string $message Optional. The exception message if the value is null. Defaults to 'Value cannot be null'.
     * @throws \InvalidArgumentException If the value is null.
     */
    public static function notNull(mixed $value, string $message = 'Value cannot be null'): void
    {
        self::against($value === null, $message);
    }

    /**
     * Ensures that the given integer value is positive (> 0).
     *
     * @param int $value The integer value to validate.
     * @param string $message Optional. The exception message if validation fails. Defaults to 'Value must be > 0'.
     *
     * @throws \InvalidArgumentException If the value is not positive.
     */
    public static function positiveInt(int $value, string $message = 'Value must be > 0'): void
    {
        self::against($value <= 0, $message);
    }
}
