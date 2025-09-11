<?php

declare(strict_types=1);

namespace Mede\Defense\Http;

final class ProblemJson
{
    /**
     * @param array<string,mixed> $ext
     * @return array<string,mixed>
     */
    public static function build(int $status, string $title, string $detail, array $ext = []): array
    {
        return [
            'type'   => 'about:blank',
            'title'  => $title,
            'status' => $status,
            'detail' => $detail,
        ] + $ext;
    }
}
