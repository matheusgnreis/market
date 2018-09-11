<?php
use Market\Controller\HomeController;

$rotas = function (){
    $this->get('/', function(){ echo "redirect lang default."; });
    $this->get('/{lang}', HomeController::class . ':index');
    $this->get('/{lang}/apps', HomeController::class . ':apps');
    $this->get('/{lang}/themes', HomeController::class . ':themes');
    $this->get('/{lang}/apps/{slug}', HomeController::class . ':app');
    $this->get('/{lang}/themes/{slug}', HomeController::class . ':theme');
};

// Api Routes
$app->group('', $rotas)->add($langRedirect);