<?php

declare(strict_types=1);

use Mede\Defense\Observability\RequestId;
use PHPUnit\Framework\TestCase;

final class RequestIdTest extends TestCase
{
    public function testGenerateHex(): void
    {
        $id = RequestId::generate();
        $this->assertMatchesRegularExpression('/^[0-9a-f]{32}$/', $id);
    }

    public function testEnsureUsesExisting(): void
    {
        $existing = 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa';
        $this->assertSame($existing, RequestId::ensure($existing));
        $this->assertNotSame($existing, RequestId::ensure(null));
    }
}
