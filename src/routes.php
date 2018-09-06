<?php
use Market\Controller\AppsController;
use Market\Controller\HomeController;

$rotas = function (){
    $this->get('/', function(){ echo "redirect lang default."; });
    $this->get('/{lang}', HomeController::class . ':index');
    $this->get('/{lang}/apps', HomeController::class . ':');
    $this->get('/{lang}/themes', HomeController::class . ':');
};

// Api Routes
$app->group('', $rotas)->add($langRedirect);