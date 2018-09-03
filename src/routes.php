<?php
use Market\Controller\AppsController;

$rotas = function () {
    $this->get('apps', AppsController::class . ':getAll');
};

// Api Routes
$app->group('/', $rotas);
