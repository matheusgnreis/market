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
        return $this->view->render($response, 'market/index.html', $params);
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
        return $this->view->render($response, 'market/apps.html', $params);
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
                'user' => [
                    'username' => $_SESSION['username'],
                    'sso_login' => $_SESSION['sso_login'],
                    'store_id' => $_SESSION['store_id'],
                    'access_token' => $_SESSION['access_token'],
                    'my_id' => $_SESSION['my_id'],
                ],
            ],
        ];
        if ($app) {
            return $this->view->render($response, 'market/single.html', $params);
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
            return $this->view->render($response, 'market/widgets.html', $params);
        }
        return $this->view->render($response, 'market/404.html', $params);
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
                'user' => [
                    'username' => $_SESSION['username'],
                    'sso_login' => $_SESSION['sso_login'],
                    'store_id' => $_SESSION['store_id'],
                    'access_token' => $_SESSION['access_token'],
                    'my_id' => $_SESSION['my_id'],
                ],
            ],
        ];
        if ($widget) {
            return $this->view->render($response, 'market/widgets.html', $params);
        }
        return $this->view->render($response, 'market/404.html', $params);
    }
}
