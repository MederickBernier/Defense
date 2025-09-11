<?php

declare(strict_types=1);

use Mede\Defense\Security\ConstantTime;
use PHPUnit\Framework\TestCase;

final class ConstantTimeTest extends TestCase
{
    public function testEquals(): void
    {
        $this->assertTrue(ConstantTime::equals('abc', 'abc'));
        $this->assertFalse(ConstantTime::equals('abc', 'abd'));
    }
}
