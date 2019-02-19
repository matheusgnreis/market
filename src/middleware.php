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
    'partner_id' => v::intVal()->notEmpty(),
    'title' => v::stringType()->notEmpty()->length(1, 40),
    'slug' => v::slug()->notEmpty(),
    'category' => v::stringType()->notEmpty(),
    'icon' => v::stringType()->notEmpty(),
    'description' => v::stringType(),
    'short_description' => v::stringType()->notEmpty()->length(1, 300),
    'json_body' => v::stringType(),
    'paid' => v::boolVal()->notEmpty(),
    'version' => v::version()->notEmpty(),
    'version_date' => v::date(),
    'type' => v::stringType(),
    'module' => v::stringType(),
    'load_events' => v::arrayVal(),
    'script_uri' => v::url(),
    'github_repository' => v::url(),
    'authentication' => v::boolVal()->notEmpty(),
    'auth_callback_uri' => v::url(),
    'redirect_uri' => v::url(),
    'auth_scope' => v::stringType(),
    'avg_stars' => v::intVal(),
    'evaluations' => v::intVal(),
    'downloads' => v::intVal(),
    'website' => v::url(),
    'link_video' => v::url(),
    'plans_json' => v::stringType(),
    'value_plan_basic' => v::intVal(),
);
