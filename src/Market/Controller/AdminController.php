<?php
namespace Market\Controller;

use Market\Controller\BaseController;

class AdminController extends BaseController
{
    public function admin($request, $response)
    {
        if (!$_SESSION) {
            session_start();

            if (!$_SESSION['sso_login']) {
                return $response->withRedirect('./');
            }
        }

        $params = [
            'params' => [
                'user' => [
                    'username' => $_SESSION['username'],
                    'sso_login' => $_SESSION['sso_login'],
                    'store_id' => $_SESSION['store_id'],
                ],
            ],
        ];
        return $this->view->render(
            $response,
            'layout/admin.html',
            $params
        );
    }
}
