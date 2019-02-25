<?php
namespace Market\Controller;

use Market\Controller\BaseController;

class AdminController extends BaseController
{
    public function admin($request, $response)
    {
        if (!$_SESSION) {
            session_start();
            //
            $_SESSION['sso_login'] = true;
            if (!$_SESSION['sso_login']) {
                return $response->withRedirect('./');
            }
        }
        $params = [
            'params' => [],
        ];
        return $this->view->render(
            $response,
            'layout/admin.html',
            $params
        );
    }
}
