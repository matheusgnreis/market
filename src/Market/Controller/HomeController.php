<?php
namespace Market\Controller;

use Market\Controller\AppsController;

class HomeController extends BaseController
{
    use \Market\Services\Dictionary;
    use \Market\Services\Categories;

    /**
     * Home view
     *
     * @param [Object] $request
     * @param [Object] $response
     * @param [Object] $args
     * @return void
     */
    function default($request, $response, $args) {
        return $response->withRedirect('/');
    }

    /**
     * Home view
     *
     * @param [Object] $request
     * @param [Object] $response
     * @param [Object] $args
     * @return void
     */
    public function home($request, $response, $args)
    {
        $apps = new AppsController();
        $all = $apps->getAll(['limit' => 8]);
        $translate = $this->getDictionary($args['lang']);
        $params = [
            'params' => [
                'dictionary' => $translate,
                'categories' => [
                    'applications' => $this->appsCategories($translate),
                    'themes' => $this->themesCategories($translate),
                ],
                'page' => [
                    'name' => 'Home',
                ],
                'data' => $all['result'],
            ],
        ];
        return $this->view->render($response, 'index.html', $params);
    }

    /**
     * Apps View
     */
    public function apps($request, $response, $args)
    {
        $apps = new AppsController();
        $all = $apps->getAll($request->getParams());
        $translate = $this->getDictionary($args['lang']);
        $params = [
            'params' => [
                'dictionary' => $translate,
                'categories' => [
                    'applications' => $this->appsCategories($translate),
                    'themes' => $this->themesCategories($translate),
                ],
                'page' => [
                    'name' => 'Apps',
                ],
                'data' => $all['result'],
            ],
        ];
        return $this->view->render($response, 'apps.html', $params);
    }

    /**
     * Single app View
     */
    public function single($request, $response, $args)
    {
        if (!$_SESSION) {
            session_start();
        }

        $apps = new AppsController();
        $app = $apps->getBySlug($args['slug']);
        $translate = $this->getDictionary($args['lang']);

        $params = [
            'params' => [
                'dictionary' => $translate,
                'categories' => [
                    'applications' => $this->appsCategories($translate),
                    'themes' => $this->themesCategories($translate),
                ],
                'page' => [
                    'name' => 'Apps',
                    'type' => 'apps',
                ],
                'data' => $app,
                'view' => [
                    'scripts' => [
                        'https://cdn.jsdelivr.net/npm/marked/marked.min.js',
                        'https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment-with-locales.min.js',
                    ],
                ],
                'login' => [
                    'store_id' => $_SESSION['store_id'],
                    'username' => $_SESSION['username'],
                    'sso' => $_SESSION['sso_login'] ? $_SESSION['sso_login'] : 0,
                    'my_id' => $_SESSION['myId'],
                    'token' => $_SESSION['access_token'],
                ],
/*                 'login' => [
'store_id' => 1011,
'username' => 'ecom',
'sso' => 1,
'my_id' => '5b1abe30a4d4531b8fe40726',
'token' => 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiI1YjFhYmUzMGE0ZDQ1MzFiOGZlNDA3MjYiLCJjb2QiOjkyODY2NzAyLCJleHAiOjE1NTI3NjAyMjE5NTZ9.es5Ae0TfdqVvPOnmajDbeJmbLXCdJ60MDqysbKm-cGM',
], */
            ],
        ];
        if ($app) {
            return $this->view->render($response, 'single.html', $params);
        }
        return $this->view->render($response, '404.html', $params);
    }

    /**
     * Single app View
     */
    public function widgets($request, $response, $args)
    {
        $apps = new AppsController();
        $app = $apps->getBySlug($args['slug']);
        $app = true;
        $translate = $this->getDictionary($args['lang']);

        $params = [
            'params' => [
                'dictionary' => $translate,
                'categories' => [
                    'applications' => $this->appsCategories($translate),
                    'themes' => $this->themesCategories($translate),
                ],
                'page' => [
                    'name' => 'Apps',
                ],
                'data' => $app,
                'view' => [
                    'scripts' => [
                        'https://cdn.jsdelivr.net/npm/marked/marked.min.js',
                        'https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment-with-locales.min.js',
                    ],
                ],
            ],
        ];
        if ($app) {
            return $this->view->render($response, 'widgets.html', $params);
        }
        return $this->view->render($response, '404.html', $params);
    }
    /**
     * Single app View
     */
    public function widgetSingle($request, $response, $args)
    {
        if (!$_SESSION) {
            session_start();
        }

        $controller = new WidgetsController();
        $widget = $controller->getBySlug($args['slug']);
        $translate = $this->getDictionary($args['lang']);

        $params = [
            'params' => [
                'dictionary' => $translate,
                'categories' => [
                    'applications' => $this->appsCategories($translate),
                    'themes' => $this->themesCategories($translate),
                ],
                'page' => [
                    'name' => 'Widget',
                    'type' => 'widgets',
                ],
                'data' => $widget,
                'view' => [
                    'scripts' => [
                        'https://cdn.jsdelivr.net/npm/marked/marked.min.js',
                        'https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment-with-locales.min.js',
                    ],
                ],
                'login' => [
                    'store_id' => $_SESSION['store_id'],
                    'username' => $_SESSION['username'],
                    'sso' => $_SESSION['sso_login'] ? $_SESSION['sso_login'] : 0,
                ],
            ],
        ];
        if ($widget) {
            return $this->view->render($response, 'widgets.html', $params);
        }
        return $this->view->render($response, '404.html', $params);
    }
}
