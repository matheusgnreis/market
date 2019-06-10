<?php
/**
 * Account routes
 */
use Market\Controller\AdminController;

$middleware = function ($request, $response, $next) {
    if ($_SESSION) {
        session_start();
    }

    if (!$_SESSION['sso_login'] || (isset($_SESSION['sso_login']) && $_SESSION['sso_login'] !== true)) {
        return $response->withRedirect('/session/create');
    }
    $next();
};

//
$app->get('/admin', AdminController::class . ':admin')->add($middleware);
$app->get('/admin/applications', AdminController::class . ':admin_applications')->add($middleware);
$app->get('/admin/applications/{application_id}/edit', AdminController::class . ':edit_application')->add($middleware);
