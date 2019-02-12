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
    public function home($request, $response, $args)
    {
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
                ],
                'data' => $app,
                'view' => [
                    'scripts' => [
                        'https://cdn.jsdelivr.net/npm/marked/marked.min.js',
                        'https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment-with-locales.min.js'
                    ]
                ]
            ],
        ];
        if ($app) {
            return $this->view->render($response, 'single.html', $params);
        }
        return $this->view->render($response, '404.html', $params);
    }
}
