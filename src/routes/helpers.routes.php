<?php
/**
 * retorna adictionario
 */
use Market\Services\FileUploader;
use Market\Controller\MediaController;

$app->get(
    '/dictionary/{lang}',
    function ($request, $response, $args) {
        return $response->withJson(\Market\Services\Dictionary::getDictionary($args['lang']));
    }
);

$app->post('/uploads', MediaController::class . ':upload');
$app->delete('/uploads/{itemId}/{appId}', MediaController::class . ':delete');
