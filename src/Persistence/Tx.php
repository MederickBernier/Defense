<?php

declare(strict_types=1);

namespace Mede\Defense\Persistence;

use PDO;
use PDOException;
use Throwable;

/** @package Mede\Defense\Persistence */
final class Tx
{
    /**
     * @param PDO $pdo 
     * @param callable $fn 
     * @return mixed 
     * @throws PDOException 
     * @throws Throwable 
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
