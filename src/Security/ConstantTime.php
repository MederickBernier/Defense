<?php

declare(strict_types=1);

namespace Mede\Defense\Security;

final class ConstantTime
{
    /**
     * Compares two strings in constant time to prevent timing attacks.
     *
     * This method checks if the two input strings are equal without leaking timing information
     * that could be exploited in cryptographic contexts. If the built-in `hash_equals` function
     * is available, it is used. Otherwise, a manual byte-by-byte comparison is performed.
     *
     * @param string $a The first string to compare.
     * @param string $b The second string to compare.
     * @return bool Returns true if the strings are equal, false otherwise.
     */
    public static function equals(string $a, string $b): bool
    {
        if (\function_exists('hash_equals')) {
            return hash_equals($a, $b);
        }
        $len = \strlen($a);
        if ($len !== \strlen($b)) {
            return false;
        }
        $res = 0;
        for ($i = 0; $i < $len; $i++) {
            $res |= (\ord($a[$i]) ^ \ord($b[$i]));
        }
        return $res === 0;
    }
}
