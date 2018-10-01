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
                'data' => [
                    'page' => [
                        'name' => 'Home'
                    ]
                ],
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
                'login' => LoginController::hasLogin(),
                'user' => LoginController::session(),
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
                'login' => LoginController::hasLogin(),
                'user' => LoginController::session(),
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
                          'name' => 'App - ' . $resp->app->title,
                          'lang' => $args['lang'],
                          'current' => 'apps',
                          'app' => 1
                      ]
                  ],
                  'app_category' => $this->appsCategories($translate),
                  'theme_category' => $this->themesCategories($translate),
                  'categories' => $this->appsCategories($translate),
                  'dictionary' => $translate,
                  'login' => LoginController::hasLogin(),
                  'user' => LoginController::session(),
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
        print_r($resp);
        return $this->view->render(
                $response,
                'single.html',
                [
                    'data' => [
                        'page' => [
                            'name' => 'Tema - '. $resp->app->title,
                            'lang' => $args['lang'],
                            'current' => 'apps',
                            'app' => 1
                        ]
                    ],
                    'app_category' => $this->appsCategories($translate),
                    'theme_category' => $this->themesCategories($translate),
                    'categories' => $this->appsCategories($translate),
                    'dictionary' => $translate,
                    'login' => LoginController::hasLogin(),
                    'user' => LoginController::session(),
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

        return $this->view->render(
                $response,
                'author.html',
                [
                    'data' => [
                        'page' => [
                            'name' => 'Autor - ' . $partner->name,
                            'lang' => $args['lang'],
                            'current' => 'apps',
                            'app' => 1
                        ]
                    ],
                    'app_category' => $this->appsCategories($translate),
                    'theme_category' => $this->themesCategories($translate),
                    'categories' => $this->appsCategories($translate),
                    'dictionary' => $translate,
                    'login' => LoginController::hasLogin(),
                    'user' => LoginController::session(),
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
                'login' => LoginController::hasLogin(),
                'user' => LoginController::session(),
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
                   'login' => LoginController::hasLogin(),
                   'user' => LoginController::session(),
                   'user' => $user[0]
               ]
           );
    }
}
