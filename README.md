# Mezzio Domain Layout #
PSR-15 Middleware for Mezzio Framework to change layout based on host.

## Install ##

### Composer ###

`composer install advancedideasmechanics/mezzio-domain-layout`

#### Use ####

For pipeline.php Middleware Use.

Recommend placing before `$app->pipe(DispatchMiddleware::class);`

`$app->pipe(AdvancedIdeasMechanics\MezzioDomainLayout\Middleware\DomainLayoutMiddleware::class);`

For route.php Middleware use.

`use AdvancedIdeasMechanics\MezzioDomainLayout\Middleware\DomainLayoutMiddleware;`

`$app->get('/', [DomainLayoutMiddleware::class, App\Handler\HomePageHandler::class], 'home');`

#### Example Configuration ####

Create a file in config/autoload/domain_layouts.local.php or domain_layouts.global.php.

`return [ 'domain_layouts' => [ 'example1.com' => 'layout::example1', 'example2.com' => 'layout::example2' ] ];`

