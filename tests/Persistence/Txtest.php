<?php

declare(strict_types=1);

use Mede\Defense\Persistence\Tx;
use PHPUnit\Framework\TestCase;

final class TxTest extends TestCase
{
    private PDO $pdo;

    protected function setUp(): void
    {
        $this->pdo = new PDO('sqlite::memory:');
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->pdo->exec('CREATE TABLE t (id INTEGER PRIMARY KEY, v TEXT)');
    }

    public function testCommitOnSuccess(): void
    {
        Tx::run($this->pdo, function () {
            $st = $this->pdo->prepare('INSERT INTO t(v) VALUES (?)');
            $st->execute(['ok']);
        });
        $count = (int)$this->pdo->query('SELECT COUNT(*) FROM t')->fetchColumn();
        $this->assertSame(1, $count);
    }

    public function testRollbackOnException(): void
    {
        try {
            Tx::run($this->pdo, function () {
                $st = $this->pdo->prepare('INSERT INTO t(v) VALUES (?)');
                $st->execute(['nope']);
                throw new RuntimeException('boom');
            });
            $this->fail('Should have thrown');
        } catch (RuntimeException $e) {
            // expected
        }
        $count = (int)$this->pdo->query('SELECT COUNT(*) FROM t')->fetchColumn();
        $this->assertSame(0, $count);
    }
}
