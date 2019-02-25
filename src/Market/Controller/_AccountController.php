<?php
//namespace Market\Controller;

use Market\Controller\BaseController;
use Market\Controller\LoginController;
use Market\Controller\BuyAppsController;

class AccountController extends BaseController
{
    use \Market\Services\Dictionary;
    use \Market\Services\Categories;

    public function account($request, $response, $args)
    {
        $bc = new BuyAppsController();
        $translate = $this->getDictionary('pt_br');
        $itens_apps = $bc->getBuyApps($request, $response, $args);
        return $this->view->render(
                $response,
                'account.html',
                [
                    'data' => [
                        'page' => [
                            'name' => 'Apps',
                            'lang' => $args['lang'],
                            'current' => 'apps',
                            'app' => 1
                        ]
                    ],
                    'app_category' => $this->appsCategories($translate),
                    'theme_category' => $this->themesCategories($translate),
                    'categories' => $this->appsCategories($translate),
                    'dictionary' => $translate,
                    'login' => true,
                    'user' => LoginController::session()
                ]
            );
    }

    public function account_settings($request, $response, $args)
    {
        $translate = $this->getDictionary('pt_br');
        $login = new \Market\Model\Login();
        $user_hash = $login->getApiLogin(LoginController::session()['email']);
        //$encode = base64_encode(json_encode($user_hash));
        $user_hash = base64_encode(json_encode($user_hash)); //json_encode(array('user' => $encode));

        return $this->view->render(
                $response,
                'account-settings.html',
                [
                    'data' => [
                        'page' => [
                            'name' => 'Apps',
                            'lang' => $args['lang'],
                            'current' => 'apps',
                            'app' => 1
                        ]
                    ],
                    'app_category' => $this->appsCategories($translate),
                    'theme_category' => $this->themesCategories($translate),
                    'categories' => $this->appsCategories($translate),
                    'dictionary' => $translate,
                    'login' => true,
                    'user' => LoginController::session(),
                    'hash' => $user_hash
                ]
            );
    }

    public function account_statement($request, $response, $args)
    {
        $translate = $this->getDictionary('pt_br');
        return $this->view->render(
                $response,
                'account-statement.html',
                [
                    'data' => [
                        'page' => [
                            'name' => 'Apps',
                            'lang' => $args['lang'],
                            'current' => 'apps',
                            'app' => 1
                        ]
                    ],
                    'app_category' => $this->appsCategories($translate),
                    'theme_category' => $this->themesCategories($translate),
                    'categories' => $this->appsCategories($translate),
                    'dictionary' => $translate,
                    'login' => true,
                    'user' => LoginController::session()
                ]
            );
    }

    public function account_add($request, $response, $args)
    {
        $translate = $this->getDictionary('pt_br');

        return $this->view->render(
                $response,
                'account-add.html',
                [
                    'data' => [
                        'page' => [
                            'name' => 'Apps',
                            'lang' => $args['lang'],
                            'current' => 'apps',
                            'app' => 1
                        ]
                    ],
                    'total_cat_theme' => count($this->themesCategories($translate)),
                    'total_cat_app' => count($this->appsCategories($translate)),
                    'total_plans_app' => 10,
                    'total_faqs' => 10,
                    'is_app' => 1,
                    'app_category' => $this->appsCategories($translate),
                    'theme_category' => $this->themesCategories($translate),
                    'categories' => $this->appsCategories($translate),
                    'dictionary' => $translate,
                    'login' => true,
                    'user' => LoginController::session(),
                    'resources' => $this->resources()
                ]
            );
    }

    public function account_edit($request, $response, $args)
    {
        $translate = $this->getDictionary('pt_br');
        $user = LoginController::session();
        $request = $request->withAttribute('partner_id', $user['id']);
        $appController = new AppsController();
        $themesController = new ThemesController();

        $apps = $appController->getByPartnerId($request, $response, $args);
        $themes = $themesController->getByPartnerId($request, $response, $args);

        return $this->view->render(
                $response,
                'account-edit.html',
                [
                    'data' => [
                        'page' => [
                            'name' => 'Apps',
                            'lang' => $args['lang'],
                            'current' => 'apps',
                            'app' => 1
                        ]
                    ],
                    'total_cat_theme' => count($this->themesCategories($translate)),
                    'total_cat_app' => count($this->appsCategories($translate)),
                    'total_plans_app' => 10,
                    'total_faqs' => 10,
                    'is_app' => 1,
                    'app_category' => $this->appsCategories($translate),
                    'theme_category' => $this->themesCategories($translate),
                    'categories' => $this->appsCategories($translate),
                    'dictionary' => $translate,
                    'login' => true,
                    'user' => $user,
                    'resources' => $this->resources(),
                    'apps' => $apps,
                    'themes' => $themes
                ]
            );
    }

    public function account_edit_app($request, $response, $args)
    {
        $translate = $this->getDictionary('pt_br');
        $user = LoginController::session();
        $appController = new AppsController();

        $apps = (object)$appController->getById($request, $response, $args);
        $plans = json_decode($apps->app['plans_json']);

        $load_events = explode(',', $apps->app['load_events']);
        $load_events = array_map(function ($a) {
            return str_replace('\\', '', $a);
        }, $load_events);

        return $this->view->render(
                $response,
                'account-edit-app.html',
                [
                    'data' => [
                        'page' => [
                            'name' => 'Apps',
                            'lang' => $args['lang'],
                            'current' => 'apps',
                            'app' => 1
                        ]
                    ],
                    'total_cat_theme' => count($this->themesCategories($translate)),
                    'total_cat_app' => count($this->appsCategories($translate)),
                    'total_plans_app' => 10,
                    'total_faqs' => 10,
                    'is_app' => 1,
                    'app_category' => $this->appsCategories($translate),
                    'theme_category' => $this->themesCategories($translate),
                    'categories' => $this->appsCategories($translate),
                    'dictionary' => $translate,
                    'login' => true,
                    'user' => $user,
                    'resources' => $this->resources(),
                    'app' => $apps,
                    'plans' => $plans,
                    'load_events' => $load_events
                ]
            );
    }

    public function account_wallet($request, $response, $args)
    {
        $translate = $this->getDictionary('pt_br');
        return $this->view->render(
                $response,
                'account-wallet.html',
                [
                    'data' => [
                        'page' => [
                            'name' => 'Apps',
                            'lang' => $args['lang'],
                            'current' => 'apps',
                            'app' => 1
                        ]
                    ],
                    'app_category' => $this->appsCategories($translate),
                    'theme_category' => $this->themesCategories($translate),
                    'categories' => $this->appsCategories($translate),
                    'dictionary' => $translate,
                    'login' => true,
                    'user' => LoginController::session()
                ]
            );
    }

    public function logout($request, $response, $args)
    {
        if (LoginController::logout()) {
            return $response->withStatus(302)->withHeader('Location', '/'.$args['lang']);
        }
    }
}
