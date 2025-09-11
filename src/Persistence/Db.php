<?php

declare(strict_types=1);

namespace Mede\Defense\Persistence;

use PDO;

final class Db
{
    /**
     * Establishes a connection to a database using PDO.
     *
     * @param string $dsn  The Data Source Name, or DSN, containing the information required to connect to the database.
     * @param string $user The username for the DSN string. Optional, defaults to an empty string.
     * @param string $pass The password for the DSN string. Optional, defaults to an empty string.
     *
     * @return PDO Returns a PDO instance representing a connection to the database.
     *
     * @throws PDOException If the attempt to connect to the database fails.
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
