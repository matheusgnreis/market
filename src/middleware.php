<?php
use Market\Model\Apps;
use Market\Model\Components;
use Market\Model\Themes;
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

/**
 * Validate components post
 */

$componentsIsValid = array(
    'partner_id' => v::notOptional()->intVal(),
    'title' => v::notOptional()->stringType()->length(1, 40),
    'slug' => v::notOptional()->slug(),
    'url_css' => v::optional(v::url()),
    'url_js' => v::optional(v::url()),
    'template' => v::optional(v::stringType()),
    'config' => v::optional(v::stringType()),
    'paid' => v::notOptional()->boolVal(),
    'icon' => v::notOptional()->stringType(),
);

/**
 * Validate themes post
 */

$themeIsValid = array(
    'partner_id' => v::notOptional()->intVal(),
    'title' => v::notOptional()->stringType()->length(1, 40),
    'slug' => v::notOptional()->slug(),
    'category' => v::notOptional()->stringType(),
    'thumbnail' => v::notOptional()->stringType(),
    'description' => v::optional(v::stringType()),
    'json_body' => v::optional(v::stringType()),
    'paid' => v::notOptional()->boolVal(),
    'version' => v::notOptional()->version(),
    'version_date' => v::optional(v::date()),
    'avg_stars' => v::optional(v::intVal()),
    'evaluations' => v::optional(v::intVal()),
    'link_documentation' => v::optional(v::url()),
    'link_video' => v::optional(v::url()),
    'value_license_basic' => v::optional(v::intVal()),
    'value_license_extend' => v::optional(v::intVal()),
);

/** update theme */
$updateThemeIsValid = function ($request, $response, $next) {
    $route = $request->getAttribute('route');
    $args = $route->getArguments();

    if (!$args['id']) {
        $resp = [
            'status' => 400,
            'message' => 'Resource ID expected and not specified on request URL',
            'user_message' => [
                'en_us' => 'Unexpected error, report to support or responsible developer',
                'pt_br' => 'Erro inesperado, reportar ao suporte ou desenvolvedor responsável',
            ],
        ];
        return $response->withJson($resp, 400);
    }

    $application = Themes::find($args['id']);

    if (!$application) {
        $resp = [
            'status' => 400,
            'message' => 'Invalid value on resource ID',
            'user_message' => [
                'en_us' => 'The informed ID is invalid',
                'pt_br' => 'O ID informado é inválido',
            ],
        ];
        return $response->withJson($resp, 400);
    }

    return $next($request, $response);
};

/** update theme */
$updateApplicationIsValid = function ($request, $response, $next) {
    $route = $request->getAttribute('route');
    $args = $route->getArguments();

    if (!$args['id']) {
        $resp = [
            'status' => 400,
            'message' => 'Resource ID expected and not specified on request URL',
            'user_message' => [
                'en_us' => 'Unexpected error, report to support or responsible developer',
                'pt_br' => 'Erro inesperado, reportar ao suporte ou desenvolvedor responsável',
            ],
        ];
        return $response->withJson($resp, 400);
    }

    $application = Apps::find($args['id']);

    if (!$application) {
        $resp = [
            'status' => 400,
            'message' => 'Invalid value on resource ID',
            'user_message' => [
                'en_us' => 'The informed ID is invalid',
                'pt_br' => 'O ID informado é inválido',
            ],
        ];
        return $response->withJson($resp, 400);
    }

    return $next($request, $response);
};

/** update theme */
$updateComponentsIsValid = function ($request, $response, $next) {
    $route = $request->getAttribute('route');
    $args = $route->getArguments();

    if (!$args['id']) {
        $resp = [
            'status' => 400,
            'message' => 'Resource ID expected and not specified on request URL',
            'user_message' => [
                'en_us' => 'Unexpected error, report to support or responsible developer',
                'pt_br' => 'Erro inesperado, reportar ao suporte ou desenvolvedor responsável',
            ],
        ];
        return $response->withJson($resp, 400);
    }

    $application = Components::find($args['id']);

    if (!$application) {
        $resp = [
            'status' => 400,
            'message' => 'Invalid value on resource ID',
            'user_message' => [
                'en_us' => 'The informed ID is invalid',
                'pt_br' => 'O ID informado é inválido',
            ],
        ];
        return $response->withJson($resp, 400);
    }

    return $next($request, $response);
};
