<?php
namespace Market\Controller;

use Market\Controller\BaseController;

class HomeController extends BaseController
{
    use \Market\Services\Dictionary;
    /**
     * @param $request
     * @param $response
     * @param $args
     * @return \Slim\Views\Twig
     */
    public function index($request, $response, $args)
    {
        // Render index view        
        return $this->view->render($response, 'index.twig', ['dictionary' => $this->getDictionary($args['lang'])]);
    }
}
