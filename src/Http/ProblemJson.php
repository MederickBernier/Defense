<?php

declare(strict_types=1);

namespace Mede\Defense\Http;

final class ProblemJson
{
    /**
     * @param array<string,mixed> $ext
     * @return array<string,mixed>
     */
    public static function build(int $status, string $title, string $detail = '', array $ext = []): array
    {
        return [
            'type'   => 'about:blank',
            'title'  => $title,
            'status' => $status,
            'detail' => $detail,
        ] + $ext;
    }

    /**
     * @param array<string,mixed> $context
     * @return array<string,mixed>
     */
    public static function fromException(\Throwable $e, int $status = 500, array $context = []): array
    {
        return self::build(
            $status,
            $context['title']   ?? class_basename($e),
            $context['detail']  ?? ($e->getMessage() ?: 'Unhandled error'),
            $context + ['exception' => ['class' => $e::class]]
        );
    }

    /**
     * @param array<string,string|string[]> $errors field => message(s)
     * @return array<string,mixed>
     */
    public static function validationError(array $errors, string $title = 'Validation Failed', int $status = 422): array
    {
        return self::build($status, $title, 'One or more fields are invalid.', ['errors' => $errors]);
    }
}
/**
 * @internal Tiny helper to avoid depending on a framework.
 */
function class_basename(object|string $c): string
{
    $name = \is_object($c) ? $c::class : $c;
    $pos = strrpos($name, '\\');
    return $pos === false ? $name : substr($name, $pos + 1);
}
