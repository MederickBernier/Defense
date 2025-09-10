<?php

declare(strict_types=1);

namespace Mede\Defense\Core;

/** @package Mede\Defense\Core */
final class Result
{
    /**
     * @param bool $ok 
     * @param mixed|null $val 
     * @param null|string $err 
     * @return void 
     */
    private function __construct(public bool $ok, public mixed $val = null, public ?string $err = null) {}

    /**
     * @param mixed $v 
     * @return Result 
     */
    public static function ok(mixed $v): self
    {
        return new self(true, $v, null);
    }

    /**
     * @param string $e 
     * @return Result 
     */
    public static function err(string $e): self
    {
        return new self(false, null, $e);
    }
}
