<?php

declare(strict_types=1);

namespace Mede\Defense\Security;

/**
 * JWT interface to keep Defense decoupled from implementations.
 */
interface Jwt
{
    /**
     * @param array<string,mixed> $claims
     */
    public function encode(array $claims, string $key, string $alg = 'HS256'): string;

    /**
     * @param list<string> $algs  Allowed algorithms (e.g. ['HS256','RS256'])
     * @return array<string,mixed>
     */
    public function decode(string $jwt, string $key, array $algs = ['HS256']): array;
}
