<?php
use Market\Controller\HomeController;

/**
 * Market views
 */
$app->get('/', function () {
    echo "redirect lang default.";
})->add($redirectToLang);

$app->group('/{lang}', function () use ($app, $redirectToLang) {
    $app->get('', HomeController::class . ':home')->add($redirectToLang);
});
