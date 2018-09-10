<?php
use Market\Controller\AppsController;
use Market\Controller\HomeController;

$rotas = function (){
    $this->get('/', function(){ echo "redirect lang default."; });
    $this->get('/{lang}', HomeController::class . ':index');
    $this->get('/{lang}/apps', HomeController::class . ':apps');
    $this->get('/{lang}/themes', HomeController::class . ':index');
    $this->get('/{lang}/apps/{slug}', HomeController::class . ':index');
    $this->get('/{lang}/themes/{slug}', HomeController::class . ':index');
};

// Api Routes
$app->group('', $rotas)->add($langRedirect);