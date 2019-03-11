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
        $app->get('/apps/{slug}', HomeController::class . ':single')->add($redirectToLang);
        $app->get('/themes', HomeController::class . ':default')->add($redirectToLang);
        $app->get('/widgets', HomeController::class . ':default')->add($redirectToLang);
        $app->get('/partner', HomeController::class . ':default')->add($redirectToLang);
    }
);
