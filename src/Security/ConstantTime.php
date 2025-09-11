<?php

declare(strict_types=1);

namespace Mede\Defense\Security;

/** @package Mede\Defense\Security */
final class ConstantTime
{
    /**
     * @param string $a 
     * @param string $b 
     * @return bool 
     */
    public static function equals(string $a, string $b): bool
    {
        if (function_exists('hash_equals')) return hash_equals($a, $b);
        $len = strlen($a);
        if ($len !== strlen($b)) return false;
        $res = 0;
        for ($i = 0; $i < $len; $i++) {
            $res |= (ord($a[$i]) ^ ord($b[$i]));
        }
        return $res === 0;
    }
}
