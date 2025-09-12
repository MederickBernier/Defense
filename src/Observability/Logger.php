<?php

declare(strict_types=1);

namespace Mede\Defense\Observability;

use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

final class Logger
{
    private static ?LoggerInterface $logger = null;

    /**
     * Sets the logger instance to be used by the class.
     *
     * @param LoggerInterface $logger The logger instance to set.
     */
    public static function set(LoggerInterface $logger): void
    {
        self::$logger = $logger;
    }

    /**
     * Retrieves the current logger instance.
     *
     * If a logger has been set, it returns that instance. Otherwise, it returns a NullLogger,
     * which implements the LoggerInterface but performs no logging operations.
     *
     * @return LoggerInterface The logger instance or a NullLogger if none is set.
     */
    public static function get(): LoggerInterface
    {
        return self::$logger  ?? new NullLogger();
    }
}
