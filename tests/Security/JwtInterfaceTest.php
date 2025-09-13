<?php

declare(strict_types=1);

use Mede\Defense\Security\Jwt;
use PHPUnit\Framework\TestCase;

final class JwtInterfaceTest extends TestCase
{
    public function testInterfaceExists(): void
    {
        $this->assertTrue(interface_exists(Jwt::class));
        $ref = new ReflectionClass(Jwt::class);
        $this->assertTrue($ref->hasMethod('encode'));
        $this->assertTrue($ref->hasMethod('decode'));
    }
}
