<?php

declare(strict_types=1);

namespace Mede\Defense\Persistence;

use PDO;
use PDOException;
use Throwable;

final class Tx
{
    /**
     * Executes a callable within a database transaction.
     *
     * Begins a transaction on the provided PDO instance, executes the given callable,
     * and commits the transaction if successful. If an exception is thrown during execution,
     * the transaction is rolled back and the exception is rethrown.
     *
     * @param PDO $pdo The PDO instance to use for the transaction.
     * @param callable $fn The function to execute within the transaction.
     * @return mixed The result returned by the callable.
     * @throws Throwable If an error occurs during execution, after rolling back the transaction.
     */
    public static function run(PDO $pdo, callable $fn): mixed
    {
        $pdo->beginTransaction();
        try {
            $res = $fn();
            $pdo->commit();
            return $res;
        } catch (Throwable $e) {
            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }
            throw $e;
        }
    }
}
