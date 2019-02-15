<?php
use Market\Controller\HomeController;
use Market\Controller\AccountController;
use Market\Controller\LoginController;
use Market\Controller\PartnerController;
use Market\Controller\AppsController;
use Market\Controller\MediaController;
use Market\Controller\ThemesController;
use Market\Services\Helpers;

$routes = function () use ($langRedirect, $verifyLogin) {

    // dashboard
    $this->get('/logout', AccountController::class . ':logout');
    $this->get('/account', AccountController::class . ':account')->add($verifyLogin);
    $this->get('/account/settings', AccountController::class . ':account_settings')->add($verifyLogin);
    $this->get('/account/statement', AccountController::class . ':account_statement')->add($verifyLogin);
    $this->get('/account/add', AccountController::class . ':account_add')->add($verifyLogin);
    $this->get('/account/edit', AccountController::class . ':account_edit')->add($verifyLogin);
    $this->get('/account/edit/app/{id}', AccountController::class . ':account_edit_app')->add($verifyLogin);
    $this->get('/account/wallet', AccountController::class . ':account_wallet')->add($verifyLogin);

    //app routes
    $this->get('/', function () {
        echo "redirect lang default.";
    })->add($langRedirect);
    $this->get('/{lang}', HomeController::class . ':index')->add($langRedirect);
    $this->get('/{lang}/apps', HomeController::class . ':apps')->add($langRedirect);
    $this->get('/{lang}/themes', HomeController::class . ':themes')->add($langRedirect);
    $this->get('/{lang}/signup', HomeController::class . ':signUp')->add($langRedirect);
    $this->get('/{lang}/register-password', HomeController::class . ':signUpPassword')->add($langRedirect);
    $this->get('/{lang}/apps/{slug}', HomeController::class . ':app')->add($langRedirect);
    $this->get('/{lang}/author/{id}', HomeController::class . ':author')->add($langRedirect);
    $this->get('/{lang}/themes/{slug}', HomeController::class . ':theme')->add($langRedirect);

    //api
    $this->post('/ws/login', LoginController::class . ':login');
    $this->post('/ws/login/pass', LoginController::class . ':password');
    $this->post('/ws/login/verify', LoginController::class . ':verify');
    $this->post('/ws/partner/profile/picture', PartnerController::class . ':updatePicture');

    // path apps
    $this->get('/ws/app/{id}', AppsController::class . ':_byId'); // ok

    $this->post('/ws/apps', AppsController::class . ':create'); //ok
    $this->post('/ws/apps/media/{id}', MediaController::class . ':create'); 
    $this->get('/ws/apps/slug/{slug}', AppsController::class . ':verifySlug'); //ok

    // path themes
    $this->post('/ws/themes', ThemesController::class . ':create');// mudar isso para pacth em application/pictures
    $this->post('/ws/themes/media/{id}', MediaController::class . ':create'); // mudar isso para pacth em application/pictures

    // helper
    $this->post('/ws/format/plans', Helpers::class . ':arrayToJson'); // fazer com js
    $this->post('/ws/format/scope', Helpers::class . ':validScope'); // fazer com js
};

// Api Routes
$app->group('', $routes);
