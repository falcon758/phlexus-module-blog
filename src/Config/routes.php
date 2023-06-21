<?php
declare(strict_types=1);

use Phalcon\Mvc\Router\Group as RouterGroup;

$routes = new RouterGroup([
    'module'     => \Phlexus\Modules\Shop\Module::getModuleName(),
    'namespace'  => \Phlexus\Modules\Shop\Module::getHandlersNamespace() . '\\Controllers',
    'controller' => 'blog',
    'action'     => 'index',
]);

$routes->addGet('/blog', [
    'controller' => 'blog',
    'action'     => 'index',
]);

return $routes;
