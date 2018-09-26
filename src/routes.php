<?php
use Market\Controller\HomeController;
use Market\Controller\LoginController;
use Market\Controller\PartnerController;
use Market\Controller\AppsController;
use Market\Services\Helpers;
use Market\Controller\MediaController;
use Market\Controller\ThemesController;
$routes = function () use ($langRedirect) {

    // dashboard
    $this->get('/logout', HomeController::class . ':logout');
    $this->get('/account', HomeController::class . ':account');
    $this->get('/account/settings', HomeController::class . ':account_settings');
    $this->get('/account/statement', HomeController::class . ':account_statement');
    $this->get('/account/add', HomeController::class . ':account_add');
    $this->get('/account/edit', HomeController::class . ':account_edit');
    $this->get('/account/edit/app/{id}', HomeController::class . ':account_edit_app');
    $this->get('/account/wallet', HomeController::class . ':account_wallet');

    //app routes
    $this->get('/', function () {echo "redirect lang default.";})->add($langRedirect);
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
    $this->post('/ws/apps', AppsController::class . ':create');
    $this->post('/ws/apps/media/{id}', MediaController::class . ':create');
    $this->get('/ws/apps/slug/{slug}', AppsController::class . ':verifySlug');

    // path themes
    $this->post('/ws/themes', ThemesController::class . ':create');
    $this->post('/ws/themes/media/{id}', MediaController::class . ':create');

    // helper
    $this->post('/ws/format/plans', Helpers::class . ':arrayToJson');
    $this->post('/ws/format/scope', Helpers::class . ':validScope');

};

// Api Routes
$app->group('', $routes);
