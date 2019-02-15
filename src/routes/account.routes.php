<?php
/**
 * Account routes
 */
use Market\Controller\AccountController;
//
$app->get('/account', AccountController::class . ':account');

