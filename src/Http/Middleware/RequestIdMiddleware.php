<?php

declare(strict_types=1);

namespace Mede\Defense\Http\Middleware;

use Mede\Defense\Observability\RequestId;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class RequestIdMiddleware implements MiddlewareInterface
{
    public const HEADER = 'X-Request-Id';
    public const ATTR   = 'request_id';

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $incoming = $request->getHeaderLine(self::HEADER) ?: null;
        $rid = RequestId::ensure($incoming);

        $response = $handler->handle($request->withAttribute(self::ATTR, $rid));

        if (!$response->hasHeader(self::HEADER)) {
            $response = $response->withHeader(self::HEADER, $rid);
        }
        return $response;
    }
}
