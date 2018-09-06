<?php

$langRedirect = function ($request, $response, $next) {
    $uri = $request->getUri();
    $route = $request->getAttribute('route');
    $args = $route->getArguments();
    var_dump($args['lang']);

    if (!isset($args['lang'])) {
        return $response->withStatus(302)->withHeader('Location', '/pt_br');
    } else {
        if ($args['lang'] != 'pt_br' || !$argc['lang'] != 'en_us') {
            var_dump($uri->getPath());
            var_dump(explode('/', $uri->getPath()));
            return $response->withStatus(302)->withHeader('Location', '/pt_br' . $uri->getPath());
        }
    }
    return $next($request, $response);
};
