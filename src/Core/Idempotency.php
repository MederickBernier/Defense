<?php

declare(strict_types=1);

namespace Mede\Defense\Core;

use PDO;

/** @package Mede\Defense\Core */
final class Idempotency
{
    /**
     * @param PDO $pdo 
     * @param int $key 
     * @param callable $fn 
     * @return mixed 
     */
    public static function withPgAdvisoryLock(PDO $pdo, int $key, callable $fn): mixed
    {
        $pdo->exec("SELECT pg_advisory_lock($key)");
        try {
            return $fn();
        } finally {
            $pdo->exec("SELECT pg_advisory_unlock($key)");
        }
    }
}
