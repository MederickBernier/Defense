<?php

declare(strict_types=1);

use Mede\Defense\Http\Pagination;
use PHPUnit\Framework\TestCase;

final class PaginationTest extends TestCase
{
    public function testClampAndMeta(): void
    {
        $p = Pagination::fromQuery(['page' => '0', 'per_page' => '999'], max: 50, default: 10);
        $this->assertSame(1, $p->page);
        $this->assertSame(50, $p->perPage);

        $meta = $p->meta(120);
        $this->assertSame(['page' => 1, 'per_page' => 50, 'total' => 120, 'pages' => 3], $meta);
    }
}
