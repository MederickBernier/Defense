<?php

declare(strict_types=1);

use Mede\Defense\Core\Guard;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;

/** @package  */
final class GuardTest extends TestCase
{
    /** @return void  */
    public function testAgainstThrows(): void
    {
        $this->expectException(InvalidArgumentException::class);
        Guard::against(true, 'fail');
    }

    /**
     * @return void 
     * @throws ExpectationFailedException 
     */
    public function testAgainstPasses(): void
    {
        $this->assertNull(Guard::against(false, 'ok'));
    }
}
