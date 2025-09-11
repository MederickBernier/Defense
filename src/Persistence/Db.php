<?php

declare(strict_types=1);

namespace Mede\Defense\Persistence;

use PDO;

/** @package Mede\Defense\Persistence */
final class Db
{
    /**
     * @param string $dsn 
     * @param string $user 
     * @param string $pass 
     * @return PDO 
     */
    public static function connect(string $dsn, string $user = '', string $pass = ''): PDO
    {
        return new PDO($dsn, $user, $pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]);
    }
}
