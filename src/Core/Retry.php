<?php

declare(strict_types=1);

namespace Mede\Defense\Core;

use Random\RandomException;
use Throwable;

/** @package Mede\Defense\Core */
final class Retry
{
    /**
     * @param callable $fn 
     * @param int $maxAttempts 
     * @param int $baseMs 
     * @return mixed 
     * @throws Throwable 
     * @throws RandomException 
     */
    public static function run(callable $fn, int $maxAttempts = 3, int $baseMs = 100): mixed
    {
        $attempt = 0;

        while (true) {
            try {
                return $fn();
            } catch (Throwable $e) {
                if (++$attempt >= $maxAttempts) {
                    throw $e;
                }
                $sleepMs = (int)(($baseMs * (2 ** ($attempt - 1))) + random_int(0, 50));
                usleep($sleepMs * 1000);
            }
        }
    }
}
