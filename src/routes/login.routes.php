<?php
use Market\Controller\LoginController;

$app->get(
    '/session/sso_login',
    function ($request, $response, $args) {
        $sso = new Market\Services\EcomSSO();
        $user = $sso->handle_response();

        if ($user !== null) {
            if ($user['logged']) {
                /*
                user attributes:
                name; external_id; email; username; require_activation;
                custom.locale; custom.edit_storefront; custom.store_id;
                 */
                if ($user['email']) {
                    // save session cookies on domain root
                    // expires when browser session closes
                    setCookie('store_id', $user['custom_store_id'], 0, '/');
                    setCookie('username', $user['username'], 0, '/');
                    setCookie('sso_logged', true, 0, '/');

                    if (!$_SESSION) {
                        session_start();
                    }

                    $_SESSION['access_token'] = $user['access_token'];
                    $_SESSION['store_id'] = $user['custom_store_id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['sso_login'] = true;

                    echo <<<EOF
                        <script>
                            window.onunload = refreshParent
                            function refreshParent() {
                                window.opener.location.reload()
                            }
                        </script>
EOF;
                }
            } else {
                return $response->withRedirect('/session/create');
            }
        } else {
            // invalid request
            if (isset($_COOKIE['prev_page'])) {
                return $response->withRedirect($_COOKIE['prev_page']);
            }
        }
    }
);

$app->get(
    '/session/create',
    function ($request, $response, $args) use ($app) {
        var_dump($response);
        $sso = new Market\Services\EcomSSO('EUsJDhFXwZ242mszKJDCkB3nbv7p69NT');
        return $response->withRedirect($sso->login_url());
    }
);

$app->group(
    '/login',
    function () use ($app) {
        $app->post('', LoginController::class . ':login');
    }
);
