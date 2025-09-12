<?php

declare(strict_types=1);

use Mede\Defense\Observability\Logger;
use PHPUnit\Framework\TestCase;
use Psr\Log\AbstractLogger;

final class LoggerTest extends TestCase
{
    public function testDefaultIsNullLogger(): void
    {
        $logger = Logger::get();
        $this->assertInstanceOf(\Psr\Log\NullLogger::class, $logger);
    }

    public function testSetCustomLogger(): void
    {
        $messages = [];
        $custom = new class($messages) extends AbstractLogger {
            /** @var array<int, array{level:string, message:string}> */
            public array $messages;
            public function __construct(array &$store)
            {
                $this->messages = &$store;
            }
            public function log($level, $message, array $context = []): void
            {
                $this->messages[] = ['level' => (string)$level, 'message' => (string)$message];
            }
        };

        Logger::set($custom);
        $logger = Logger::get();
        $this->assertSame($custom, $logger);

        $logger->info('hello');
        $this->assertSame([['level' => 'info', 'message' => 'hello']], $custom->messages);
    }
}
