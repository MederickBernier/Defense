<?php

declare(strict_types=1);

namespace Mede\Defense\Security;

final class Password
{
    /**
     * Hashes a plain text password using a secure algorithm.
     *
     * @param string $plain   The plain text password to hash.
     * @param array  $options Optional array of options for password hashing (e.g., cost).
     *
     * @return string The hashed password.
     */
    public static function hash(string $plain, array $options = []): string
    {
        return password_hash($plain, PASSWORD_DEFAULT, $options);
    }

    /**
     * Verifies that a plain text password matches a given hash.
     *
     * Uses PHP's password_verify function to check if the provided plain password
     * corresponds to the specified hashed password.
     *
     * @param string $plain The plain text password to verify.
     * @param string $hash The hashed password to compare against.
     * @return bool Returns true if the password matches the hash, false otherwise.
     */
    public static function verify(string $plain, string $hash): bool
    {
        return password_verify($plain, $hash);
    }


    /**
     * Determines if the given password hash needs to be rehashed according to the specified options.
     *
     * This method uses PHP's `password_needs_rehash()` function to check if the hash should be updated,
     * for example, if the algorithm or its options have changed since the hash was created.
     *
     * @param string $hash    The existing password hash to check.
     * @param array  $options Optional. An associative array of options for the hashing algorithm.
     *                        Refer to PHP documentation for supported options.
     *
     * @return bool Returns true if the hash needs to be rehashed, false otherwise.
     */
    public static function needsRehash(string $hash, array $options = []): bool
    {
        return password_needs_rehash($hash, PASSWORD_DEFAULT, $options);
    }
}
