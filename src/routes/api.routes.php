<?php
/**
 * Market Api
 * @todo Check if request has resourceId [middleware]
 * @todo Check if required properties is set on request when is put/patch/post [middleware]
 */
use Market\Controller\AppsController;
use Market\Controller\ComponentsController;
use Market\Controller\PartnerController;
use Market\Controller\ThemesController;

$app->group(
    '/v1',
    function () use ($app, $applicationIsValid, $componentsIsValid, $themeIsValid, $updateThemeIsValid, $updateApplicationIsValid, $updateComponentsIsValid) {
        /**
         * Applications resource
         */
        $app->group(
            '/applications',
            function () use ($app, $applicationIsValid, $updateApplicationIsValid) {
                // controller
                $applicationController = new AppsController();

                /**
                 * Request all applications
                 */
                $app->get('', function ($request, $response) use ($applicationController) {
                    $params = $request->getParams();
                    return $response->withJson($applicationController->getAll($params), 200);
                });

                /**
                 * Create new application
                 */
                $app->post('', function ($request, $response) use ($applicationController) {
                    if ($request->getAttribute('has_errors')) {
                        //There are errors, read them
                        $validateErrors = $request->getAttribute('errors');
                        foreach ($validateErrors as $key => $value) {
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

                        return $response->withJson($resp, 201);
                    }
                })->add(new \DavidePastore\Slim\Validation\Validation($applicationIsValid));

                /**
                 * Request application by Id
                 */
                $app->get('/{id}', function ($request, $response, $args) use ($applicationController) {
                    $application = $applicationController->getById($args['id']);
                    $result = $application ? $application : [];
                    return $response->withJson((object) $result, 200);
                });

                /**
                 * Patch Application
                 */
                $app->patch('/{id}', AppsController::class . ':update')->add($updateApplicationIsValid);
            }
        );

        /**
         * Applications resource
         */
        $app->group(
            '/components',
            function () use ($app, $componentsIsValid, $updateComponentsIsValid) {
                // controller
                $componentsController = new ComponentsController();

                /**
                 * Request all components
                 */
                $app->get('', function ($request, $response) use ($componentsController) {
                    $params = $request->getParams();
                    return $response->withJson($componentsController->getAll($params), 200);
                });

                /**
                 * Create new components
                 */
                $app->post('', function ($request, $response) use ($componentsController) {
                    if ($request->getAttribute('has_errors')) {
                        //There are errors, read them
                        $validateErrors = $request->getAttribute('errors');
                        foreach ($validateErrors as $key => $value) {
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
                        $resp = $componentsController->create($body);

                        return $response->withJson($resp, 201);
                    }
                })->add(new \DavidePastore\Slim\Validation\Validation($componentsIsValid));

                /**
                 * Request components by Id
                 */
                $app->get('/{id}', function ($request, $response, $args) use ($componentsController) {
                    $component = $componentsController->getById($args['id']);
                    $result = $component ? $component : [];
                    return $response->withJson((object) $result, 200);
                });

                /**
                 * Patch components
                 */
                $app->patch('/{id}', AppsController::class . ':update')->add($updateComponentsIsValid);
            }
        );

        /**
         * Theme resource
         */
        $app->group(
            '/themes',
            function () use ($app, $themeIsValid, $updateThemeIsValid) {
                // controller
                $themesController = new ThemesController();

                /**
                 * Request all theme
                 */
                $app->get('', function ($request, $response) use ($themesController) {
                    $params = $request->getParams();
                    return $response->withJson($themesController->getAll($params));
                });

                /**
                 * Create new theme
                 */
                $app->post('', function ($request, $response) use ($themesController) {
                    if ($request->getAttribute('has_errors')) {
                        //There are errors, read them
                        $validateErrors = $request->getAttribute('errors');
                        foreach ($validateErrors as $key => $value) {
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
                        $resp = $themesController->create($body);

                        return $response->withJson($resp, 201);
                    }
                })->add(new \DavidePastore\Slim\Validation\Validation($themeIsValid));

                /**
                 * Request theme by Id
                 */
                $app->get('/{id}', function ($request, $response, $args) use ($themesController) {
                    $theme = $themesController->getById($args['id']);
                    $result = $theme ? $theme : [];
                    return $response->withJson((object) $result, 200);
                });

                /**
                 * Patch theme
                 */
                $app->patch('/{id}', ThemesController::class . ':update')->add($updateThemeIsValid);
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
                    return $response->withJson($find, 200);
                });
            }
        );
    }
);
