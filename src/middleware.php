<?php
use Respect\Validation\Validator as v;

$redirectToLang = function ($request, $response, $next) {
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

$verifyLogin = function ($request, $response, $next) {
    if (!\Market\Controller\LoginController::hasLogin()) {
        return $response->withStatus(302)->withHeader('Location', '/pt_br');
    }

    return $next($request, $response);
};

/**
 * Validate application post
 */

$applicationIsValid = array(
    'partner_id' => v::notOptional()->intVal(),
    'title' => v::notOptional()->stringType()->length(1, 40),
    'slug' => v::notOptional()->slug(),
    'category' => v::notOptional()->stringType(),
    'icon' => v::notOptional()->stringType(),
    'description' => v::optional(v::stringType()),
    'short_description' => v::notOptional()->stringType()->length(1, 300),
    'json_body' => v::optional(v::stringType()),
    'paid' => v::notOptional()->boolVal(),
    'version' => v::notOptional()->version(),
    'version_date' => v::optional(v::date()),
    'type' => v::optional(v::stringType()),
    'module' => v::optional(v::stringType()),
    'load_events' => v::optional(v::arrayVal()),
    'script_uri' => v::optional(v::url()),
    'github_repository' => v::optional(v::url()),
    'authentication' => v::notOptional()->boolVal(),
    'auth_callback_uri' => v::optional(v::url()),
    'redirect_uri' => v::optional(v::url()),
    'auth_scope' => v::optional(v::stringType()),
    'avg_stars' => v::optional(v::intVal()),
    'evaluations' => v::optional(v::intVal()),
    'downloads' => v::optional(v::intVal()),
    'website' => v::optional(v::url()),
    'link_video' => v::optional(v::url()),
    'plans_json' => v::optional(v::stringType()),
    'value_plan_basic' => v::optional(v::intVal()),
);
