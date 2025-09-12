<?php

declare(strict_types=1);

use Mede\Defense\Observability\HealthCheck;
use PHPUnit\Framework\TestCase;

final class HealthCheckTest extends TestCase
{
    public function testRunAndAllOk(): void
    {
        $hc = new HealthCheck();
        $hc->add('ok', fn(): bool => true)
            ->add('fail', fn(): bool => false);

        $results = $hc->run();
        $this->assertCount(2, $results);

        // Find by name
        $byName = static function (array $arr, string $name): ?array {
            foreach ($arr as $r) {
                if ($r['name'] === $name) {
                    return $r;
                }
            }
            return null;
        };

        $this->assertSame(['name' => 'ok', 'ok' => true], $byName($results, 'ok'));
        $this->assertSame(['name' => 'fail', 'ok' => false], $byName($results, 'fail'));
        $this->assertFalse($hc->allOk());
    }

    public function testExceptionCountsAsFailure(): void
    {
        $hc = new HealthCheck();
        $hc->add('boom', function (): bool {
            throw new RuntimeException('nope');
        });
        $this->assertFalse($hc->allOk());
    }
}
