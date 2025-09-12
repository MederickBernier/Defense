<?php

declare(strict_types=1);

namespace Mede\Defense\Observability;

final class HealthCheck
{
    /**
     * @var array<string, callable():bool> Map of health check names to functions that return bool.
     */
    private array $checks = [];

    /**
     * Adds a health check callable to the list of checks.
     *
     * @param string   $name The name of the health check.
     * @param callable():bool $fn   The callable function that performs the health check.
     * @return self Returns the current instance for method chaining.
     */
    public function add(string $name, callable $fn): self
    {
        $this->checks[$name] = $fn;
        return $this;
    }

    /**
     * Executes all registered health checks and returns their results.
     *
     * Iterates over each health check function in `$this->checks`, executing them safely.
     * If a check throws an exception or error, it is considered failed (`ok` = false).
     * Each result contains the check's name and its status.
     *
     * @return array<int, array{name:string, ok:bool}> An array of results, each with 'name' and 'ok' status.
     */
    public function run(): array
    {
        $results = [];
        foreach ($this->checks as $name => $fn) {
            try {
                $ok = (bool) $fn();
            } catch (\Throwable) {
                $ok = false;
            }
            $results[] = ['name' => $name, 'ok' => $ok];
        }
        return $results;
    }

    /**
     * Checks if all health checks have passed successfully.
     *
     * Iterates through the results of the `run()` method and returns `true`
     * only if all checks have an 'ok' status of `true`. If any check fails,
     * returns `false`.
     *
     * @return bool True if all health checks are OK, false otherwise.
     */
    public function allOk(): bool
    {
        foreach ($this->run() as $r) {
            if ($r['ok'] === false) {
                return false;
            }
        }
        return true;
    }
}
