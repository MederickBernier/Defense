<?php

declare(strict_types=1);

namespace Mede\Defense\Core;

use PDO;

final class Idempotency
{
    /**
     * Executes a callable function within a PostgreSQL advisory lock context.
     *
     * Acquires a PostgreSQL advisory lock using the provided key before executing the given callable.
     * The lock is released after the callable has been executed, regardless of whether it throws an exception.
     *
     * @param PDO $pdo The PDO instance connected to the PostgreSQL database.
     * @param int $key The integer key used to acquire the advisory lock.
     * @param callable $fn The function to execute while the advisory lock is held.
     * @return mixed Returns the result of the callable function.
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
