<?php

declare(strict_types=1);

namespace Mede\Defense\Security;

final class Password
{
    /**
     * @param array<string,mixed> $options
     */
    public static function hash(string $plain, array $options = []): string
    {
        return password_hash($plain, PASSWORD_DEFAULT, $options);
    }

    public static function verify(string $plain, string $hash): bool
    {
        return password_verify($plain, $hash);
    }

    /**
     * @param array<string,mixed> $options
     */
    public static function needsRehash(string $hash, array $options = []): bool
    {
        return password_needs_rehash($hash, PASSWORD_DEFAULT, $options);
    }
}
