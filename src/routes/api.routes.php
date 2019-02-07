<?php
/**
 * Market Api
 * @todo Check if request has resourceId [middleware]
 * @todo Check if required properties is set on request when is put/patch/post [middleware]
 */
use Market\Controller\AppsController;

$app->group('/v1', function () use ($app) {
    /**
     * Applications resource
     */
    $app->group(
        '/applications',
        function () use ($app) {
            // controller
            $applicationController = new AppsController();

            /**
             * Request all applications
             */
            $app->get('', function ($request, $response) use ($applicationController) {
                $params = $request->getParams();
                return $response->withJson($applicationController->getAll($params));
            });

            /**
             * Create new application
             */
            $app->post('', AppsController::class . ':create');

            /**
             * Request application by Id
             */
            $app->get('/{id}', function ($request, $response, $args) use ($applicationController) {
                return $response->withJson($applicationController->getById($args['id']));
            });

            /**
             * Patch Application
             */
            $app->patch('/{id}', AppsController::class . ':update');

            /**
             * Update Application
             */
            $app->put('/{id}', AppsController::class . ':update');
        }
    );
});
