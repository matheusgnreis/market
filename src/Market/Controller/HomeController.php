<?php
namespace Market\Controller;

use Market\Controller\BaseController;
use Market\Model\ThemesComments;

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

        return $this->view->render($response, 'index.html', 
            [
                'page_name' => 'Home', 
                'dictionary' => $translate,
                'lang' => $args['lang'],
                'app_category' => $this->appsCategories($translate),
                'theme_category' => $this->themesCategories($translate),
                'search' => $this->searchCategories($translate),
                'apps' => $apps->getAll($request, $response, $args)->apps,
                'themes' => $themes->getAll($request, $response, $args),
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
                
        return $this->view->render($response, 'apps.html', 
            [
                'data' => [
                    'page' => [
                        'name' => 'Apps',
                        'category' => 'All',
                        'lang' => $args['lang'],
                        'total' => $resp->total,
                        'pages' => ceil($resp->total / 12),
                        'atual' => ceil($request->getParams()['skip'] / 10),
                        'filter' => $request->getParams()['filter']
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
}
