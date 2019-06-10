<?php
namespace Market\Controller\Partner;

use Market\Controller\AppsController;
use Market\Controller\BaseController;
use Market\Controller\PartnerController;

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
                'resources' => $this->resources(),
                'user' => [
                    'name' => $_SESSION['name'],
                    'avatar' => $_SESSION['path_image'],
                ],
            ],
            'resource' => [
                'title' => 'E-com Plus Partner - Home',
            ],
        ];
        return $this->view->render(
            $response,
            'partner/account.html',
            $params
        );
    }

    public function my_apps($request, $response)
    {
        if (!$_SESSION) {
            session_start();
            if (!$_SESSION['login']) {
                return $response->withRedirect('./../');
            }
        }
        $translate = $this->getDictionary('pt_br');
        $partnerId = $_SESSION['id'];
        // partner infor
        $partnerController = new PartnerController();

        $params = [
            'params' => [
                'data' => [
                    'partner_id' => $partnerId,
                ],
                'partner' => $partnerController->getById($partnerId),
                'dictionary' => $translate,
                'categories' => [
                    'applications' => $this->appsCategories($translate),
                    'themes' => $this->themesCategories($translate),
                ],
                'resources' => $this->resources(),
                'user' => [
                    'name' => $_SESSION['name'],
                    'avatar' => $_SESSION['path_image'],
                ],
            ],
            'resource' => [
                'title' => 'E-com Plus Partner - Meus Applicativos',
            ],
        ];
        return $this->view->render(
            $response,
            'partner/my-apps.html',
            $params
        );
    }

    public function add_app($request, $response)
    {
        if (!$_SESSION) {
            session_start();
            if (!$_SESSION['login']) {
                return $response->withRedirect('./');
            }
        }
        $translate = $this->getDictionary('pt_br');
        $partnerId = $_SESSION['id'];
        // partner infor
        $partnerController = new PartnerController();

        $params = [
            'params' => [
                'data' => [
                    'partner_id' => $partnerId,
                ],
                'partner' => $partnerController->getById($partnerId),
                'dictionary' => $translate,
                'categories' => [
                    'applications' => $this->appsCategories($translate),
                    'themes' => $this->themesCategories($translate),
                ],
                'resources' => $this->resources(),
                'user' => [
                    'name' => $_SESSION['name'],
                    'avatar' => $_SESSION['path_image'],
                ],
            ],
            'resource' => [
                'title' => 'E-com Plus Partner - Criar Aplicativo',
            ],
        ];
        return $this->view->render(
            $response,
            'partner/add-app.html',
            $params
        );
    }

    public function edit_app($request, $response, $args)
    {
        if (!$_SESSION) {
            session_start();
            if (!$_SESSION['login']) {
                return $response->withRedirect('./');
            }
        }
        $translate = $this->getDictionary('pt_br');
        $partnerId = $_SESSION['id'];
        // partner infor
        $partnerController = new PartnerController();
        $applicationsController = new AppsController();
        $application = $applicationsController->getById($args['appId']);
        $modules = $application['module'] ? json_encode($application['module']) : '{}';
        $application_admin_settings = $application['json_body'] ? json_encode($application['json_body']) : '{}';
        $application_auth_scope = $application['auth_scope'] ? json_encode($application['auth_scope']) : '{}';
        $params = [
            'params' => [
                'data' => [
                    'partner_id' => $partnerId,
                ],
                'partner' => $partnerController->getById($partnerId),
                'application' => $application,
                'application_id' => $args['appId'],
                'application_modules' => $modules,
                'application_admin_settings' => $application_admin_settings,
                'application_auth_scope' => $application_auth_scope,
                'dictionary' => $translate,
                'categories' => [
                    'applications' => $this->appsCategories($translate),
                    'themes' => $this->themesCategories($translate),
                ],
                'resources' => $this->resources(),
                'user' => [
                    'name' => $_SESSION['name'],
                    'avatar' => $_SESSION['path_image'],
                ],
            ],
            'resource' => [
                'title' => 'E-com Plus Partner - ' . $application['title'] . ' [Overview]',
            ],
        ];
        return $this->view->render(
            $response,
            'partner/edit-app.html',
            $params
        );
    }

    public function overview_app($request, $response, $args)
    {
        if (!$_SESSION) {
            session_start();
            if (!$_SESSION['login']) {
                return $response->withRedirect('./');
            }
        }
        $translate = $this->getDictionary('pt_br');
        $partnerId = $_SESSION['id'];
        // partner infor
        $partnerController = new PartnerController();
        $applicationsController = new AppsController();
        $application = $applicationsController->getById($args['appId']);
        $params = [
            'params' => [
                'data' => [
                    'partner_id' => $partnerId,
                ],
                'partner' => $partnerController->getById($partnerId),
                'application' => $application,
                'application_id' => $args['appId'],
                'dictionary' => $translate,
                'categories' => [
                    'applications' => $this->appsCategories($translate),
                    'themes' => $this->themesCategories($translate),
                ],
                'resources' => $this->resources(),
                'user' => [
                    'name' => $_SESSION['name'],
                    'avatar' => $_SESSION['path_image'],
                ],
            ],
            'resource' => [
                'title' => 'E-com Plus Partner - ' . $application['title'] . ' [Overview]',
            ],
        ];
        return $this->view->render(
            $response,
            'partner/overview-app.html',
            $params
        );
    }

    public function settings_app($request, $response, $args)
    {
        if (!$_SESSION) {
            session_start();
            if (!$_SESSION['login']) {
                return $response->withRedirect('./');
            }
        }
        $translate = $this->getDictionary('pt_br');
        $partnerId = $_SESSION['id'];
        // partner infor
        $partnerController = new PartnerController();
        $applicationsController = new AppsController();
        $application = $applicationsController->getById($args['appId']);
        $params = [
            'params' => [
                'data' => [
                    'partner_id' => $partnerId,
                ],
                'partner' => $partnerController->getById($partnerId),
                'application' => $application,
                'application_id' => $args['appId'],
                'dictionary' => $translate,
                'categories' => [
                    'applications' => $this->appsCategories($translate),
                    'themes' => $this->themesCategories($translate),
                ],
                'resources' => $this->resources(),
                'user' => [
                    'name' => $_SESSION['name'],
                    'avatar' => $_SESSION['path_image'],
                ],
            ],
            'resource' => [
                'title' => 'E-com Plus Partner - ' . $application['title'] . ' [Overview]',
            ],
        ];
        return $this->view->render(
            $response,
            'partner/settings-app.html',
            $params
        );
    }
}
