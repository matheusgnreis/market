<?php
namespace Market\Controller;

use Market\Controller\BaseController;

class AdminController extends BaseController
{
    public function admin($request, $response)
    {
        if (!$_SESSION) {
            session_start();
        }

        $params = [
            'params' => [
                'user' => [
                    'username' => $_SESSION['username'],
                    'sso_login' => $_SESSION['sso_login'],
                    'store_id' => $_SESSION['store_id'],
                    'access_token' => $_SESSION['access_token'],
                    'my_id' => $_SESSION['my_id'],
                ],
            ],
        ];
        return $this->view->render(
            $response,
            'layout/admin.html',
            $params
        );
    }

    public function admin_applications($request, $response, $args)
    {
        if (!$_SESSION) {
            session_start();
        }

        $params = [
            'params' => [
                'user' => [
                    'username' => $_SESSION['username'],
                    'sso_login' => $_SESSION['sso_login'],
                    'store_id' => $_SESSION['store_id'],
                    'access_token' => $_SESSION['access_token'],
                    'my_id' => $_SESSION['my_id'],
                ],
            ],
            'application' => [
                'id' => $args['application_id'],
            ],
        ];
        return $this->view->render(
            $response,
            'admin/applications.html',
            $params
        );
    }

    public function edit_application($request, $response, $args)
    {
        if (!$_SESSION) {
            session_start();
        }

        $params = [
            'params' => [
                'user' => [
                    'username' => $_SESSION['username'],
                    'sso_login' => $_SESSION['sso_login'],
                    'store_id' => $_SESSION['store_id'],
                    'access_token' => $_SESSION['access_token'],
                    'my_id' => $_SESSION['my_id'],
                ],
                'application' => [
                    'id' => $args['application_id'],
                ],
            ],
        ];
        return $this->view->render(
            $response,
            'admin/applications-edit.html',
            $params
        );
    }
}
