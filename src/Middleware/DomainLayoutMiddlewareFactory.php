<?php

namespace AdvancedIdeasMechanics\MezzioDomainLayout\Middleware;

use Mezzio\Template\TemplateRendererInterface;
use Psr\Container\ContainerInterface;

class DomainLayoutMiddlewareFactory
{
    public function __invoke(ContainerInterface $container): DomainLayoutMiddleware
    {
        $renderer = $container->get(TemplateRendererInterface::class);
        
        $config = $container->has('config') ? $container->get('config') : [];
        
        // Extract our specific config array, defaulting to an empty array if not present
        $domainLayoutMap = $config['domain_layouts'] ?? [];

        return new DomainLayoutMiddleware($renderer, $domainLayoutMap);
    }
}