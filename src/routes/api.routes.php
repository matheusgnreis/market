<?php
/**
 * Market Api
 * @todo Check if request has resourceId [middleware]
 * @todo Check if required properties is set on request when is put/patch/post [middleware]
 */
use Market\Controller\AppsController;
use Market\Controller\PartnerController;

$app->group('/v1', function () use ($app, $applicationIsValid) {
    /**
     * Applications resource
     */
    $app->group(
        '/applications',
        function () use ($app, $applicationIsValid) {
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
            $app->post('', function ($request, $response) use ($applicationController) {
                print_r($request->getAttribute('has_errors'));
                if ($request->getAttribute('has_errors')) {
                    //There are errors, read them
                    $validateErrors = $request->getAttribute('errors');
                    foreach ($validateErrors as $key => $value) {
                        print_r($key);
                        $errors[] = [
                            'status' => 400,
                            'property' => $key,
                            'message' => 'Bad-formatted JSON {' . $key . '} invalid, details in user_message',
                            'user_message' => str_replace('null ', '', implode(', ', $value)),
                        ];
                    }
                    return $response->withJson(['erros' => $errors], 400);
                } else {
                    $body = $request->getParsedBody();
                    $resp = $applicationController->create($body);
                    return $response->withJson($resp);
                }
            })->add(new \DavidePastore\Slim\Validation\Validation($applicationIsValid));

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

    /**
     * Partner resource
     */
    $app->group(
        '/partners',
        function () use ($app) {
            $app->get('/{id}', function ($request, $response, $args) {
                $partnet = new PartnerController();
                $find = $partnet->getById(($args['id']));
                return $response->withJson($find);
            });
        }
    );
});
