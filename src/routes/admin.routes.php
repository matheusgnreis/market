<?php
/**
 * Account routes
 */
use Market\Controller\AdminController;
//
$app->get('/admin', AdminController::class . ':admin');