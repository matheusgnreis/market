<?php
if (PHP_SAPI == 'cli-server') {
    // To help the built-in PHP dev server, check if the request was actually for
    // something which should probably be served as a static file
    $url  = parse_url($_SERVER['REQUEST_URI']);
    $file = __DIR__ . $url['path'];
    if (is_file($file)) {
        return false;
    }
}

require __DIR__ . '/vendor/autoload.php';

session_start();

// Instantiate the app
$settings = require __DIR__ . '/src/settings.php';

$app = new \Slim\App($settings);

// Set up dependencies
require __DIR__ . '/src/dependencies.php';

// Register middleware
require __DIR__ . '/src/middleware.php';

require __DIR__ . '/src/routes/api.routes.php';
require __DIR__ . '/src/routes/account.routes.php';
require __DIR__ . '/src/routes/partner.routes.php';
require __DIR__ . '/src/routes/admin.routes.php';
require __DIR__ . '/src/routes/helpers.routes.php';
require __DIR__ . '/src/routes/login.routes.php';
require __DIR__ . '/src/routes/market.routes.php';
// Run app
$app->run();
