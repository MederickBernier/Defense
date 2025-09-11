<?php

declare(strict_types=1);

namespace Mede\Defense\Core;

final class Result
{
    /**
     * Constructs a new Result instance.
     *
     * @param bool $ok Indicates whether the result is successful.
     * @param mixed $val The value associated with a successful result (optional).
     * @param string|null $err The error message if the result is unsuccessful (optional).
     */
    private function __construct(public bool $ok, public mixed $val = null, public ?string $err = null)
    {
    }

    /**
     * Creates a successful Result instance with the provided value.
     *
     * @param mixed $v The value to be stored in the Result.
     * @return self Returns a new Result instance representing success.
     */
    public static function ok(mixed $v): self
    {
        return new self(true, $v, null);
    }

    /**
     * Creates a new Result instance representing an error state.
     *
     * @param string $e The error message.
     * @return self The Result instance with error information.
     */
    public static function err(string $e): self
    {
        return new self(false, null, $e);
    }
}
