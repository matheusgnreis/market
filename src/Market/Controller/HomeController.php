<?php
namespace Market\Controller;

class HomeController extends BaseController
{
    use \Market\Services\Dictionary;
    use \Market\Services\Categories;

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
}
