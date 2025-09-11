<?php

declare(strict_types=1);

use Mede\Defense\Http\ProblemJson;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;

/** @package  */
final class ProblemJsonTest extends TestCase
{
    /**
     * @throws ExpectationFailedException
     */
    public function testShape(): void
    {
        $p = ProblemJson::build(400, 'Bad', 'Nope', ['foo' => 'bar']);
        $this->assertSame(400, $p['status']);
        $this->assertSame('Bad', $p['title']);
        $this->assertSame('Nope', $p['detail']);
        $this->assertSame('bar', $p['foo']);
    }
}
