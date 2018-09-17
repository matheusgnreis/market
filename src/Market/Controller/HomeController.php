<?php
namespace Market\Controller;

use Market\Controller\BaseController;

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
        // Render index view
        $translate = $this->getDictionary($args['lang']);
        $apps = new AppsController();
        $themes = new ThemesController();
        var_dump($request->getParams());
        if ($request->getParams()['title'] && $request->getParams()['categories']) {
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
                'login' => false,
                'user' => null
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

    public function dashboard($request, $response, $args)
    {
        return $this->view->render(
                $response,
                '/d/dashboard-car.twig',
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
                    'user' => null,
                    'app' => $resp,
                    'plans' => json_decode($resp->app['plans_json']),
                    'is' => 'themer'
                ]
            );
    }
}
