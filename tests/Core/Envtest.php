<?php

declare(strict_types=1);

use Mede\Defense\Core\Env;
use PHPUnit\Framework\TestCase;

final class EnvTest extends TestCase
{
    public function testStrReadsEnv(): void
    {
        putenv('DEF_TEST=hello');
        $this->assertSame('hello', ENV::str('DEF_TEST'));
    }

    public function testStrThrowsWhenMissing(): void
    {
        putenv('DEF_MISS');
        $this->expectException(RuntimeException::class);
        Env::str('DEF_MISS');
    }

    public function testIntWithDefault(): void
    {
        putenv('DEF_INT');
        $this->assertSame(42, Env::int('DEF_INT', 42));
        putenv('DEF_INT=123');
        $this->assertSame(123, Env::int('DEF_INT', 42));
    }
}
