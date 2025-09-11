<?php

declare(strict_types=1);

namespace Mede\Defense\Http;

/** @package Mede\Defense\Http */
final class ProblemJson
{
    /**
     * @param int $status 
     * @param string $title 
     * @param string $detail 
     * @param array $ext 
     * @return array 
     */
    public static function build(int $status, string $title, string $detail, array $ext = []): array
    {
        return ['type' => 'about:blank', 'title' => $title, 'status' => $status, 'detail' => $detail] + $ext;
    }
}
