<?php

declare(strict_types=1);

use Laminas\Diactoros\Response;
use Laminas\Diactoros\ServerRequest;
use Mede\Defense\Http\Middleware\RequestIdMiddleware;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class RequestIdMiddlewareTest extends TestCase
{
    private function makeRequest(array $headers = []): ServerRequestInterface
    {
        $req = new ServerRequest();
        foreach ($headers as $name => $value) {
            $req = $req->withHeader($name, $value);
        }
        return $req;
    }

    private function makeHandler(?string &$seenAttr, ?ResponseInterface $preset = null): RequestHandlerInterface
    {
        return new class ($seenAttr, $preset) implements RequestHandlerInterface {
            public function __construct(private ?string &$seenAttr, private ?ResponseInterface $preset)
            {
            }
            public function handle(ServerRequestInterface $r): ResponseInterface
            {
                $this->seenAttr = $r->getAttribute(RequestIdMiddleware::ATTR);
                return $this->preset ?? new Response();
            }
        };
    }

    public function testGeneratesWhenMissing(): void
    {
        $mw = new RequestIdMiddleware();
        $req = $this->makeRequest();
        $seen = null;

        $resp = $mw->process($req, $this->makeHandler($seen));

        $this->assertNotEmpty($seen);
        $this->assertMatchesRegularExpression('/^[0-9a-f]{32}$/', (string)$seen);
        $this->assertTrue($resp->hasHeader(RequestIdMiddleware::HEADER));
        $this->assertMatchesRegularExpression('/^[0-9a-f]{32}$/', $resp->getHeaderLine(RequestIdMiddleware::HEADER));
    }

    public function testPropagatesIncoming(): void
    {
        $mw = new RequestIdMiddleware();
        $incoming = 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa';
        $req = $this->makeRequest([RequestIdMiddleware::HEADER => $incoming]);
        $seen = null;

        $resp = $mw->process($req, $this->makeHandler($seen));

        $this->assertSame($incoming, $seen);
        $this->assertSame($incoming, $resp->getHeaderLine(RequestIdMiddleware::HEADER));
    }

    public function testDoesNotOverwriteExistingHeader(): void
    {
        $mw = new RequestIdMiddleware();
        $incoming = 'bbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbb';
        $req = $this->makeRequest([RequestIdMiddleware::HEADER => $incoming]);

        // Downstream sets its own header (simulating app/handler behavior)
        $preset = (new Response())->withHeader(RequestIdMiddleware::HEADER, 'cccccccccccccccccccccccccccccccc');
        $seen = null;

        $resp = $mw->process($req, $this->makeHandler($seen, $preset));

        $this->assertSame($incoming, $seen); // attribute shows incoming
        $this->assertSame('cccccccccccccccccccccccccccccccc', $resp->getHeaderLine(RequestIdMiddleware::HEADER)); // preserved
    }
}
