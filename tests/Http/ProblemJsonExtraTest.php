<?php

declare(strict_types=1);

use Mede\Defense\Http\ProblemJson;
use PHPUnit\Framework\TestCase;

final class ProblemJsonExtraTest extends TestCase
{
    public function testFromException(): void
    {
        $ex = new RuntimeException('boom');
        $p = ProblemJson::fromException($ex, 500);
        $this->assertSame(500, $p['status']);
        $this->assertSame('RuntimeException', $p['title']);
        $this->assertSame('boom', $p['detail']);
        $this->assertSame(RuntimeException::class, $p['exception']['class']);
    }

    public function testValidationError(): void
    {
        $p = ProblemJson::validationError(['email' => 'Invalid email', 'name' => ['Too short']]);
        $this->assertSame(422, $p['status']);
        $this->assertSame('Validation Failed', $p['title']);
        $this->assertIsArray($p['errors']);
    }
}
