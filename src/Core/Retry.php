<?php

declare(strict_types=1);

namespace Mede\Defense\Core;

use Throwable;

final class Retry
{
    /**
     * Executes a callable function with retry logic using exponential backoff.
     *
     * Attempts to run the provided callable up to $maxAttempts times. If an exception
     * is thrown, it waits for an exponentially increasing amount of time (in milliseconds)
     * before retrying, with a small random jitter added to the delay.
     *
     * @param callable $fn The function to execute.
     * @param int $maxAttempts Maximum number of attempts before giving up (default: 3).
     * @param int $baseMs Base delay in milliseconds for exponential backoff (default: 100).
     * @return mixed The result of the callable if successful.
     * @throws Throwable The last exception thrown if all attempts fail.
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
