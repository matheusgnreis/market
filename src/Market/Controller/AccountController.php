<?php
namespace Market\Controller;

use Market\Controller\BaseController;

class AccountController extends BaseController
{
    use \Market\Services\Dictionary;
    use \Market\Services\Categories;

    public function account($request, $response)
    {
        return $this->view->render(
            $response,
            'layout/account.html', []
        );
    }
}
