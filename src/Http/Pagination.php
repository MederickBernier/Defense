<?php

declare(strict_types=1);

namespace Mede\Defense\Http;

final class Pagination
{
    public function __construct(public int $page, public int $perPage) {}

    public static function fromQuery(array $q, int $max = 100, int $default = 20): self
    {
        $page = max(1, (int)($q['page'] ?? 1));
        $pp   = max(1, min($max, (int)($q['per_page'] ?? $default)));
        return new self($page, $pp);
    }

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
