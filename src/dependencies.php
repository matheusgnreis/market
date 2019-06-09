<?php
$app->add(new Psr7Middlewares\Middleware\TrailingSlash(false));
$app->add(function ($req, $res, $next) {
    $response = $next($req, $res);
    return $response
        ->withHeader('Access-Control-Allow-Origin', '*')
        ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
        ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
});
$app->add(function ($request, $response, $next) {
    $route = $request->getAttribute('route');
    $methods = [];

    if (!empty($route)) {
        $pattern = $route->getPattern();

        foreach ($this->router->getRoutes() as $route) {
            if ($pattern === $route->getPattern()) {
                $methods = array_merge_recursive($methods, $route->getMethods());
            }
        }
        //Methods holds all of the HTTP Verbs that a particular route handles.
    } else {
        $methods[] = $request->getMethod();
    }

    $response = $next($request, $response);

    return $response->withHeader('Access-Control-Allow-Methods', implode(',', $methods));
});
$app->add(new \Slim\HttpCache\Cache(getenv('APP_CACHE_API'), 3600));

//
$container = $app->getContainer();
$container['cache'] = function () {
    return new \Slim\HttpCache\CacheProvider();
};

$container['view'] = function ($c) {
    $view = new \Slim\Views\Twig(__DIR__ . '/Market/View', [
        'cache' => getenv('APP_CACHE')
    ]);

    $view->addExtension(new Twig_Extensions_Extension_Text());
    // Instantiate and add Slim specific extension
    $router = $c->get('router');
    $uri = \Slim\Http\Uri::createFromEnvironment(new \Slim\Http\Environment($_SERVER));
    $view->addExtension(new \Slim\Views\TwigExtension($router, $uri));
    $view->addExtension(new \Market\Services\MarketExtensions());
    $view->addExtension(new \Market\Services\CMSContent());
    return $view;
};
//Erro 404
$container['notFoundHandler'] = function ($c) {
    return function ($request, $response) use ($c) {
        return $c['view']->render($response->withStatus(404), '404.html');
    };
};
// Erro 405
$container['notAllowedHandler'] = function ($c) {
    return function ($request, $response, $methods) use ($c) {
        return $c['response']
            ->withStatus(405)
            ->withHeader('Allow', implode(', ', $methods))
            ->withHeader('Content-type', 'application/json')
            ->write(json_encode(array('code' => 405, 'message' => 'metodo não permitido, metodos válidos.', 'metodos' => implode(', ', $methods))));
    };
};
// Erro 500
$container['errorHandler'] = function ($c) {
    return function ($request, $response, $exception) use ($c) {
        return $c['view']->render($response->withStatus(500), '500.html');            
    };
};
// Monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));

    return $logger;
};
