<?php

declare(strict_types=1);

use Mede\Defense\Core\Result;
use PHPUnit\Framework\TestCase;

final class ResultTest extends TestCase
{
    public function testOkAndErr(): void
    {
        $r1 = Result::ok(123);
        $this->assertTrue($r1->ok);
        $this->assertSame(123, $r1->val);

        $r2 = Result::err('nope');
        $this->assertFalse($r2->ok);
        $this->assertSame('nope', $r2->err);
    }
}
