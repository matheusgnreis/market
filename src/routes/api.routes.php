<?php
/**
 * Market Api
 */
use Market\Controller\AppsController;

$app->group('/v1', function () use ($app) {
    /**
     * Applications resource
     */
    $app->group('/applications', function () use ($app) {
        $app->get('', AppsController::class . ':getAll');
        $app->post('', AppsController::class . ':create');
        $app->get('/{id}', AppsController::class . ':getById');
        $app->patch('/{id}', AppsController::class . ':update');
        $app->put('/{id}', AppsController::class . ':update');
    });

    /**
     * Themes resource
     */
    /*     $app->group('/themes', function () use ($app) {
    }); */
});
