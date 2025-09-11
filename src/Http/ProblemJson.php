<?php

declare(strict_types=1);

namespace Mede\Defense\Http;

final class ProblemJson
{
    /**
     * Builds a Problem Details JSON response array according to RFC 7807.
     *
     * @param int    $status HTTP status code.
     * @param string $title  Short, human-readable summary of the problem.
     * @param string $detail Detailed, human-readable explanation of the problem.
     * @param array<string,mixed>  $ext    Additional extension members to include in the response.
     *
     * @return array<string,mixed> The Problem Details response array.
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
