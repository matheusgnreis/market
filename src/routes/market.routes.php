<?php
/**
 * Routes of public views
 */
use Market\Controller\HomeController;

/**
 * Market views
 */
$app->get(
    '/',
    function () {
        echo "redirect lang default.";
    }
)->add($redirectToLang);

$app->group(
    '/{lang}',
    function () use ($app, $redirectToLang) {
        $app->get('', HomeController::class . ':home')->add($redirectToLang);
        $app->get('/apps', HomeController::class . ':apps')->add($redirectToLang);
    }
);
