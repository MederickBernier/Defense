<?php

declare(strict_types=1);

use Mede\Defense\Security\Password;
use PHPUnit\Framework\TestCase;

final class PasswordTest extends TestCase
{
    public function testHashVerifyAndRehash(): void
    {
        $hash = Password::hash('secret');
        $this->assertTrue(Password::verify('secret', $hash));
        $this->assertFalse(Password::verify('nope', $hash));
        $this->assertIsBool(Password::needsRehash($hash));
    }
}
