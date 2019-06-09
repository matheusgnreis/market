<?php
use Market\Controller\LoginController;

$app->get(
    '/session/sso_login',
    function ($request, $response, $args) {
        $sso = new Market\Services\EcomSSO(getenv('SSO_SECRET'));
        $user = $sso->handle_response();

        if ($user !== null) {
            if ($user['logged']) {
                /*
                user attributes:
                name; external_id; email; username; require_activation;
                custom.locale; custom.edit_storefront; custom.store_id;
                 */
                if ($user['email']) {
                    if (!$_SESSION) {
                        session_start();
                    }
                    $_SESSION['my_id'] = $user['external_id'];
                    $_SESSION['access_token'] = $user['custom_access_token'];
                    $_SESSION['store_id'] = $user['custom_store_id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['sso_login'] = true;

                    echo "
                        <script>
                            window.opener.location.reload()
                            window.close();
                        </script>
                    ";
                }
            } else {
                return $response->withRedirect('/session/create');
            }
        } else {
            return $response->withRedirect('/session/create');
        }
    }
);

$app->get(
    '/session/create',
    function ($request, $response, $args) use ($app) {
        $sso = new Market\Services\EcomSSO(getenv('SSO_SECRET'));
        return $response->withRedirect($sso->login_url());
    }
);

$app->group(
    '/login',
    function () use ($app) {
        $app->post('', LoginController::class . ':login');
    }
);

$app->group(
    '/logout',
    function () use ($app) {
        $app->get('', function ($request, $response, $args) {
            if (LoginController::logout()) {
                return $response->withRedirect('../');
            }
        });
    }
);
