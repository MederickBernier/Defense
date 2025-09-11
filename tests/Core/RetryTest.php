<?php

declare(strict_types=1);

use Mede\Defense\Core\Retry;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use Random\RandomException;

/** @package  */
final class RetryTest extends TestCase
{
    /**
     * @return void 
     * @throws Throwable 
     * @throws RandomException 
     * @throws ExpectationFailedException 
     */
    public function testRetrySucceedsAfterFailures(): void
    {
        $i = 0;
        $val = Retry::run(function () use (&$i) {
            if ($i++ < 2) {
                throw new RuntimeException('fail');
            }
            return 'ok';
        }, 3, 1);
        $this->assertSame('ok', $val);
    }
}
