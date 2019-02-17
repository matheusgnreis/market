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
        }
        $partnerId = $_SESSION['id'];
        $params = [
            'params' => [
                'data' => [
                    'partner_id' => $partnerId,
                ],
            ],
        ];
        return $this->view->render(
            $response,
            'layout/account.html',
            $params
        );
    }
}
