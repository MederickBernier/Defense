<?php

declare(strict_types=1);

namespace Mede\Defense\Observability;

final class RequestId
{
    /**
     * Generates a unique request identifier as a hexadecimal string.
     *
     * This method creates a 16-byte random value and converts it to a 32-character
     * hexadecimal string, suitable for use as a request ID in observability and tracing.
     *
     * @return string A 32-character hexadecimal string representing the request ID.
     */
    public static function generate(): string
    {
        return bin2hex(random_bytes(16));
    }

    /**
     * Ensures that a valid request ID is present.
     *
     * If an existing request ID is provided and is not empty, it returns that value.
     * Otherwise, it generates and returns a new request ID.
     *
     * @param string|null $existing An optional existing request ID.
     * @return string The ensured or newly generated request ID.
     */
    public static function ensure(?string $existing = null): string
    {
        return ($existing !== null && $existing !== '') ? $existing : self::generate();
    }
}
