<?php

$langRedirect = function ($request, $response, $next) {
    $uri = $request->getUri();
    $route = $request->getAttribute('route');
    $args = $route->getArguments();

    if (!isset($args['lang'])) {
        return $response->withStatus(302)->withHeader('Location', '/pt_br');
    } else {
        $lang = explode('/', $uri->getPath());
        if ($lang[1] != 'pt_br' && $lang[1] != 'en_us') {
            return $response->withStatus(302)->withHeader('Location', '/pt_br' . $uri->getPath());
        }
    }
    return $next($request, $response);
};

$appIsValid = function($request, $response, $next){
    
};