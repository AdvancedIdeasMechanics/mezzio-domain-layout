<?php

namespace AdvancedIdeasMechanics\MezzioDomainLayout\Middleware;

use Mezzio\Router\RouteResult;
use Mezzio\Template\TemplateRendererInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class DomainLayoutMiddleware implements MiddlewareInterface
{
    private $renderer;
    private $domainLayoutMap;

    public function __construct(TemplateRendererInterface $renderer, array $domainLayoutMap = [])
    {
        $this->renderer = $renderer;
        $this->domainLayoutMap = $domainLayoutMap;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $routeResult = $request->getAttribute(RouteResult::class);
        if ($routeResult === null || $routeResult->isFailure()) {
            return $handler->handle($request);
        }

        if ($request->getHeaderLine('X-Requested-With') === 'XMLHttpRequest') {
            return $handler->handle($request);
        }

        if (str_contains($request->getHeaderLine('Accept'), 'application/json')) {
            return $handler->handle($request);
        }

        $host  = $request->getHeaderLine('X-Forwarded-Host') ?: $request->getHeaderLine('Host') ?: $request->getUri()->getHost();

        $layout = $this->domainLayoutMap[$host] ?? 'layout::default';

        $this->renderer->addDefaultParam(
            TemplateRendererInterface::TEMPLATE_ALL,
            'layout',
            $layout
        );

        return $handler->handle($request);
    }
}