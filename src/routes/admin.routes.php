<?php
/**
 * Account routes
 */
use Market\Controller\AdminController;

//
$app->get('/admin', AdminController::class . ':admin');
$app->get('/admin/applications', AdminController::class . ':admin_applications');
$app->get('/admin/applications/{application_id}/edit', AdminController::class . ':edit_application');
