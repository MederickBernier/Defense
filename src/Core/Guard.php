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

    /**
     * Ensures that the given string value is not empty after trimming whitespace.
     *
     * @param string $value The string value to check.
     * @param string $message Optional. The exception message if the value is empty. Defaults to "Value cannot be empty".
     * @throws \InvalidArgumentException If the string is empty after trimming.
     */
    public static function notEmptyString(string $value, string $message = "Value cannot be empty"):void{
        self::against(trim($value) === '', $message);
    }

    /**
     * Validates that the given string does not exceed the specified maximum length.
     *
     * @param string $value   The string to check.
     * @param int    $max     The maximum allowed length.
     * @param string $message Optional. The exception message if validation fails. Defaults to "String too long".
     *
     * @throws \Exception If the string length exceeds the maximum allowed.
     */
    public static function maxLength(string $value, int $max, string $message = "String too long"):void{
     self::against(mb_strlen($value)>$max, $message);   
    }

    /**
     * Validates that a given value exists within a specified array.
     *
     * @param string|int $needle   The value to search for in the array.
     * @param array      $haystack The array to search within.
     * @param string     $message  The exception message to use if validation fails. Defaults to "Invalid value".
     *
     * @throws \InvalidArgumentException If the value is not found in the array.
     */
    public static function inArray(string|int $needle, array $haystack, string $message = "Invalid value"):void{
        self::against(!in_array($needle, $haystack, true), $message);
    }

    /**
     * Ensures that a given value is greater than a specified minimum.
     *
     * Throws an exception with the provided message if the value is less than or equal to the minimum.
     *
     * @param int|float $value   The value to check.
     * @param int|float $min     The minimum value that $value must exceed.
     * @param string    $message The exception message if the check fails. Defaults to "Too small".
     *
     * @throws \Exception If $value is less than or equal to $min.
     */
    public static function greaterThan(int|float $value, int|float $min, string $message = "Too small"):void{
        self::against($value <= $min, $message);
    }
}
