<?php
/**
 * Account routes
 */
use Market\Controller\Partner\AccountController;
//
$app->get('/partners', AccountController::class . ':account');
$app->get('/partners/apps', AccountController::class . ':my_apps');
$app->get('/partners/apps/add', AccountController::class . ':add_app');
$app->get('/partners/apps/{appId}/edit', AccountController::class . ':edit_app');
$app->get('/partners/apps/{appId}/overview', AccountController::class . ':overview_app');
$app->get('/partners/apps/{appId}/settings', AccountController::class . ':settings_app');
$app->get('/partners/themes', AccountController::class . ':account');


