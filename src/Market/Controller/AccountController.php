<?php
namespace Market\Controller;

use Market\Controller\BaseController;

class AccountController extends BaseController
{
    use \Market\Services\Dictionary;
    use \Market\Services\Categories;

    public function account($request, $response)
    {
        if (!$_SESSION) {
            session_start();
            if (!$_SESSION['login']) {
                return $response->withRedirect('./');
            }
        }
        $translate = $this->getDictionary('pt_br');
        $partnerId = $_SESSION['id'];
        $params = [
            'params' => [
                'data' => [
                    'partner_id' => $partnerId,
                ],
                'dictionary' => $translate,
                'categories' => [
                    'applications' => $this->appsCategories($translate),
                    'themes' => $this->themesCategories($translate),
                ],
                'resources' => $this->resources()
            ],
        ];
        return $this->view->render(
            $response,
            'layout/account.html',
            $params
        );
    }
}
