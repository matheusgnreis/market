<?php
use Market\Controller\HomeController;
use Market\Controller\LoginController;

$routes = function () use ($langRedirect) {

    // dashboard
    $this->get('/account', HomeController::class . ':dashboard');

    //app routes
    $this->get('/', function () {echo "redirect lang default.";})->add($langRedirect);
    $this->get('/{lang}', HomeController::class . ':index')->add($langRedirect);
    $this->get('/{lang}/apps', HomeController::class . ':apps')->add($langRedirect);
    $this->get('/{lang}/themes', HomeController::class . ':themes')->add($langRedirect);
    $this->get('/{lang}/signup', HomeController::class . ':signUp')->add($langRedirect);
    $this->get('/{lang}/register-password', HomeController::class . ':signUpPassword')->add($langRedirect);
    $this->get('/{lang}/apps/{slug}', HomeController::class . ':app')->add($langRedirect);
    $this->get('/{lang}/themes/{slug}', HomeController::class . ':theme')->add($langRedirect);


    //api
    $this->post('/ws/login', LoginController::class . ':login');
    $this->post('/ws/login/pass', LoginController::class . ':password');
    $this->post('/ws/login/verify', LoginController::class . ':verify');
};

// Api Routes
$app->group('', $routes);
