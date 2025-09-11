<?php

declare(strict_types=1);

namespace Mede\Defense\Security;

/** @package Mede\Defense\Security */
final class Password
{
    /**
     * @param string $plain 
     * @param array $options 
     * @return string 
     */
    public static function hash(string $plain, array $options = []): string
    {
        return password_hash($plain, PASSWORD_DEFAULT, $options);
    }

    /**
     * @param string $plain 
     * @param string $hash 
     * @return bool 
     */
    public static function verify(string $plain, string $hash): bool
    {
        return password_verify($plain, $hash);
    }

    /**
     * @param string $hash 
     * @param array $options 
     * @return bool 
     */
    public static function needsRehash(string $hash, array $options = []): bool
    {
        return password_needs_rehash($hash, PASSWORD_DEFAULT, $options);
    }
}
