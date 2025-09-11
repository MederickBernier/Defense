<?php

declare(strict_types=1);

namespace Mede\Defense\Http;

final class Pagination
{
    /**
     * Constructs a new Pagination instance.
     *
     * @param int $page    The current page number.
     * @param int $perPage The number of items per page.
     */
    public function __construct(public int $page, public int $perPage)
    {
    }

    /**
     * Creates a Pagination instance from query parameters.
     *
     * @param array<string,mixed> $q Query parameters, typically from $_GET.
     * @param int $max Maximum allowed items per page (default: 100).
     * @param int $default Default items per page if not specified (default: 20).
     * @return self Returns a new instance of Pagination with page and per-page values.
     */
    public static function fromQuery(array $q, int $max = 100, int $default = 20): self
    {
        $page = max(1, (int)($q['page'] ?? 1));
        $pp   = max(1, min($max, (int)($q['per_page'] ?? $default)));
        return new self($page, $pp);
    }

    /**
     * Generates pagination metadata for the current page.
     *
     * @param int $total The total number of items available.
     * @return array{page:int, per_page:int, total:int, pages:int} Returns an associative array containing pagination metadata.
     */
    public function meta(int $total): array
    {
        return [
            'page' => $this->page,
            'per_page' => $this->perPage,
            'total' => $total,
            'pages' => (int)ceil($total / max(1, $this->perPage)),
        ];
    }
}
