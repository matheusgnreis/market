<?php
namespace Market\Controller;

use Market\Controller\BaseController;
use Market\Controller\LoginController;
use Market\Controller\BuyAppsController;

class HomeController extends BaseController
{
    use \Market\Services\Dictionary;
    use \Market\Services\Categories;

    /**
     * @param $request
     * @param $response
     * @param $args
     * @return \Slim\Views\Twig
     */
    public function index($request, $response, $args)
    {
        if ($request->getParams()['title'] && $request->getParams()['categories']) { // form search
            switch ($request->getParams()['categories']) {
                case 'apps':
                    return $response->withStatus(302)->withHeader('Location', '/'.$args['lang'].'/apps?title='.$request->getParams()['title']);
                    break;
                case 'themes':
                    return $response->withStatus(302)->withHeader('Location', '/'.$args['lang'].'/themes?title='.$request->getParams()['title']);
                    break;
                default:
                    return $response->withStatus(302)->withHeader('Location', '/'.$args['lang']);
                    break;
            }
        }
        
        // Render index view
        $translate = $this->getDictionary($args['lang']);
        $apps = new AppsController();
        $themes = new ThemesController();

        return $this->view->render(
            $response,
            'index.html',
            [
                'page_name' => 'Home',
                'dictionary' => $translate,
                'lang' => $args['lang'],
                'app_category' => $this->appsCategories($translate),
                'theme_category' => $this->themesCategories($translate),
                'search' => $this->searchCategories($translate),
                'apps' => $apps->getAll($request, $response, $args)->apps,
                'themes' => $themes->getAll($request, $response, $args)->themes,
                'login' => LoginController::hasLogin(),
                'user' => LoginController::session()
            ]
        );
    }

    public function apps($request, $response, $args)
    {
        // Render index view
        $translate = $this->getDictionary($args['lang']);
        $apps = new AppsController();
        $themes = new ThemesController();

        $resp = $apps->getAll($request, $response, $args);

        return $this->view->render(
            $response,
            'apps.html',
            [
                'data' => [
                    'page' => [
                        'name' => 'Apps',
                        'category' => $request->getParams()['category'],
                        'lang' => $args['lang'],
                        'total' => $resp->total,
                        'pages' => ceil($resp->total / 12),
                        'current' => 'apps',
                        'atual' => ceil($request->getParams()['skip'] / 10),
                        'filter' => isset($request->getParams()['filter']) ? $request->getParams()['filter'] : 'all'
                    ]
                ],
                'app_category' => $this->appsCategories($translate),
                'theme_category' => $this->themesCategories($translate),
                'categories' => $this->appsCategories($translate),
                'dictionary' => $translate,
                'login' => false,
                'user' => null,
                'apps' => $resp->apps
            ]
        );
    }

    public function themes($request, $response, $args)
    {
        // Render index view
        $translate = $this->getDictionary($args['lang']);
        $apps = new AppsController();
        $themes = new ThemesController();

        $resp = $themes->getAll($request, $response, $args);

        return $this->view->render(
            $response,
            'apps.html',
            [
                'data' => [
                    'page' => [
                        'name' => 'Temas',
                        'category' => $request->getParams()['category'],
                        'lang' => $args['lang'],
                        'total' => $resp->total,
                        'pages' => ceil($resp->total / 12),
                        'current' => 'themes',
                        'atual' => ceil($request->getParams()['skip'] / 10),
                        'filter' => isset($request->getParams()['filter']) ? $request->getParams()['filter'] : 'all'
                    ]
                ],
                'app_category' => $this->appsCategories($translate),
                'theme_category' => $this->themesCategories($translate),
                'categories' => $this->themesCategories($translate),
                'dictionary' => $translate,
                'login' => false,
                'user' => null,
                'apps' => $resp->themes
            ]
        );
    }

    public function app($request, $response, $args)
    {
        // Render index view
        $translate = $this->getDictionary($args['lang']);
        $apps = new AppsController();
        $resp = $apps->getBySlug($request, $response, $args);
        
        if (!$resp) {
            return $this->view->render($response->withStatus(404), '404.html', ['search' => ['type' => 'App'], 'dictionary' => $translate]);
        }

        return $this->view->render(
              $response,
              'single.html',
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
                  'login' => false,
                  'user' => null,
                  'app' => $resp,
                  'plans' => json_decode($resp->app['plans_json']),
                  'is' => 'app'
              ]
          );
    }

    public function theme($request, $response, $args)
    {
        // Render index view
        $translate = $this->getDictionary($args['lang']);
        $apps = new ThemesController();
        $resp = $apps->getBySlug($request, $response, $args);
        
        if (!$resp) {
            return $this->view->render($response->withStatus(404), '404.html', ['search' => ['type' => 'Themer'], 'dictionary' => $translate]);
        }

        return $this->view->render(
                $response,
                'single.html',
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
                    'login' => false,
                    'user' => null,
                    'app' => $resp,
                    'plans' => json_decode($resp->app['plans_json']),
                    'is' => 'themer'
                ]
            );
    }

    public function author($request, $response, $args)
    {
        // Render index view
        $translate = $this->getDictionary($args['lang']);
        $partnerController = new PartnerController();
        $partner = $partnerController->getById($request, $response, $args);

        // $resp = $apps->getBySlug($request, $response, $args);
        
        // if (!$resp) {
        //     return $this->view->render($response->withStatus(404), '404.html', ['search' => ['type' => 'Author'], 'dictionary' => $translate]);
        // }

        return $this->view->render(
                $response,
                'author.html',
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
                    'login' => false,
                    'partner' => $partner
                ]
            );
    }

    public function signUp($request, $response, $args)
    {
        // Render index view
        $translate = $this->getDictionary($args['lang']);
        
        return $this->view->render(
              $response,
              'register.html',
                [
                'data' => [
                        'page' => [
                            'name' => 'Signup',
                            'lang' => $args['lang'],
                            'current' => 'signup',
                            'app' => 1
                        ]
                ],
                'app_category' => $this->appsCategories($translate),
                'theme_category' => $this->themesCategories($translate),
                'categories' => $this->appsCategories($translate),
                'dictionary' => $translate,
                'login' => false,
                'user' => null
            ]
        );
    }

    public function signUpPassword($request, $response, $args)
    {
        // Render index view
        $translate = $this->getDictionary($args['lang']);
        $body = $request->getQueryParams();
        
        if ($body['u']) {
            $user = json_decode(base64_decode($body['u']));
        } else {
            return $response->withStatus(302)->withHeader('Location', '/'.$args['lang'].'/signup');
        }

        return $this->view->render(
               $response,
               'register-password.html',
               [
                   'data' => [
                       'page' => [
                           'name' => 'Register Password',
                           'lang' => $args['lang'],
                           'current' => 'register-password',
                       ],
                       'user_hash' => $body['u']
                   ],
                   'app_category' => $this->appsCategories($translate),
                   'theme_category' => $this->themesCategories($translate),
                   'categories' => $this->appsCategories($translate),
                   'dictionary' => $translate,
                   'login' => false,
                   'user' => $user[0]
               ]
           );
    }

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
        var_dump($apps->app['plans_json']);
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
