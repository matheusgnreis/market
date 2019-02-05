<?php
namespace Market\Controller;

use Market\Model\Apps;

/**
 * Undocumented class
 */
class AppsController
{
    private $_limit = 1000;
    private $_offset = 0;
    private $_fields = ['app_id', 'title', 'slug', 'icon', 'version', 'paid'];
    private $_result = [];
    private $_params = ['active' => 1];
    /**
     * Construtor
     */
    public function __construct()
    {
        new \Market\Services\Database();
    }

    public function getAll($request, $response)
    {

        /*
            find multiples ids
        */
        if (isset($request->getParams()['app_id'])) {
            $ids = explode(',', $request->getParams()['app_id']);
            $apps = Apps::whereIn('app_id', $ids)->get($this->_fields);
            return $response->withJson($this->response($apps->toArray()));
        }

        /*
        metafields
         */
        $this->requestHasMeta($request, $response);
        /*
        search
         */
        $result = Apps::where($this->_params)
            ->offset($this->_offset)
            ->limit($this->_limit)
            ->get($this->_fields)
            ->toArray();
        return $response->withJson($this->response($result));
    }

    public function getById($request, $response, $args)
    {
        $query = Apps::where('app_id', $args['id'])->with('imagens')->get();

        $map = $query->map(function ($item) {
            $data['app_id'] = $item->app_id;
            $data['title'] = $item->title;
            $data['slug'] = $item->slug;
            $data['paid'] = (boolean) $item->paid;
            $data['version'] = $item->version;
            $data['type'] = $item->type;
            if (!empty($item->module)) {
                $data['module'] = $item->module;
            }
            if (!empty($item->load_events)) {
                $data['load_events'] = explode(',', str_replace(["\\", "[", "]", '"'], '', (string) $item->load_events));
            }
            if (!empty($item->script_uri)) {
                $data['script_uri'] = $item->script_uri;
            }
            if (!empty($item->redirect_uri)) {
                $data['redirect_uri'] = $item->redirect_uri;
            }
            $data['github_repository'] = $item->github_repository;
            $data['authentication'] = (boolean) $item->authentication;
            $data['auth_callback_uri'] = $item->auth_callback_uri;
            $data['auth_scope'] = json_decode($item->auth_scope);
            $data['pictures'] = $item->imagens;
            return $data;
        });

        return $map ? $response->withJson($map[0], 200)
        : $response->withJson([], 404);
    }

    public function requestHasMeta($request, $response)
    {
        /*
        Possíveis parametros para busca
         */
        if (isset($request->getParams()['filter'])) {
            if ($request->getParams()['filter'] == 'free') {
                $this->_params[] = ['value_plan_basic', 0];
            }
        }

        if (isset($request->getParams()['author'])) {
            $this->_params[] = ['partner_id', $request->getParams()['author']];
        }

        if (isset($request->getParams()['slug'])) {
            $this->_params[] = ['slug', $request->getParams()['slug']];
        }

        if (isset($request->getParams()['category'])) {
            if ($request->getParams()['category'] !== 'all') {
                $this->_params[] = ['category', $request->getParams()['category']];
            }
        }

        if (isset($request->getParams()['title'])) {
            $this->_params[] = ['title', 'like', '%' . $request->getParams()['title'] . '%'];
        }

        /*
        offset
         */
        if (isset($request->getParams()['offset'])) {
            $this->_offset = (int) $request->getParams()['offset'];
        }

        /*
        limit
         */
        if (isset($request->getParams()['limit'])) {
            $this->_limit = (int) $request->getParams()['limit'];
        }
    }

    public function response($result)
    {
        return [
            'meta' => (object) [
                'limit' => $this->_limit,
                'offset' => $this->_offset,
                'sort' => [],
                'fields' => $this->_fields,
                'query' => (object) $this->_params,
            ],
            'result' => $result,
        ];
    }

    public function create($request, $response)
    {
        $body = [
            'partner_id' => !empty($body['partner_id']) ? $body['partner_id'] : null,
            'title' => !empty($body['title']) ? $body['title'] : null,
            'slug' => !empty($body['slug']) ? $body['slug'] : null,
            'category' => !empty($body['category']) ? $body['category'] : null,
            'icon' => !empty($body['icon']) ? $body['icon'] : null,
            'description' => !empty($body['description']) ? $body['description'] : null,
            'json_body' => !empty($body['json_body']) ? $body['json_body'] : null,
            'paid' => isset($body['paid']) ? $body['paid'] : null,
            'version' => !empty($body['version']) ? $body['version'] : null,
            'version_date' => !empty($body['version_date']) ? $body['version_date'] : null,
            'type' => !empty($body['type']) ? $body['type'] : null,
            'module' => !empty($body['module']) ? $body['module'] : null,
            'load_events' => !empty($body['load_events']) ? (string) (json_encode($body['load_events'])) : null,
            'script_uri' => !empty($body['script_uri']) ? $body['script_uri'] : null,
            'github_repository' => !empty($body['github_repository']) ? $body['github_repository'] : null,
            'authentication' => isset($body['authentication']) ? $body['authentication'] : null,
            'auth_callback_uri' => !empty($body['auth_callback_uri']) ? $body['auth_callback_uri'] : null,
            'redirect_uri' => !empty($body['redirect_uri']) ? $body['redirect_uri'] : null,
            'auth_scope' => !empty($body['auth_scope']) ? $body['auth_scope'] : null,
            'avg_stars' => !empty($body['avg_stars']) ? $body['avg_stars'] : null,
            'evaluations' => !empty($body['evaluations']) ? $body['evaluations'] : null,
            'website' => !empty($body['website']) ? $body['website'] : null,
            'link_video' => !empty($body['link_video']) ? $body['link_video'] : null,
            'plans_json' => !empty($body['plans_json']) ? $body['plans_json'] : null,
            'value_plan_basic' => !empty($body['value_plan_basic']) ? $body['value_plan_basic'] : null,
            'active' => !empty($body['active']) ? $body['active'] : 1,
        ];

        $application = Apps::create($body);

        if (!$application) {
            $return = [
                'status' => 400,
                'message' => 'Error with request on this resource',
                'user_message' => [
                    'en_us' => 'Unexpected error, report to support or responsible developer',
                    'pt_br' => 'Erro inesperado, reportar ao suporte ou desenvolvedor responsável',
                ],
            ];

            return $response->withJson($return, 400);
        }
        return $response->withJson($app->id, 201);
    }

    public function update($request, $response, $args)
    {
        if (!$args['id']) {
            $return = [
                'status' => 400,
                'message' => 'Resource ID expected and not specified on request UR',
                'user_message' => [
                    'en_us' => 'Unexpected error, report to support or responsible developer',
                    'pt_br' => 'Erro inesperado, reportar ao suporte ou desenvolvedor responsável',
                ],
            ];

            return $response->withJson($return, 400);
        }

        $application = Apps::find($args['id']);

        if (!$application) {
            $return = [
                'status' => 400,
                'message' => 'Invalid value on resource ID',
                'user_message' => [
                    'en_us' => 'The informed ID is invalid',
                    'pt_br' => 'O ID informado é inválido',
                ],
            ];

            return $response->withJson($return, 400);
        }

        $requestBody = $request->getParsedBody();

        $updateBody = [
            'title' => isset($requestBody['title']) ? $requestBody['title'] : $application->title,
            'slug' => isset($requestBody['slug']) ? $requestBody['slug'] : $application->slug,
            'category' => isset($requestBody['category']) ? $requestBody['category'] : $application->category,
            'icon' => isset($requestBody['icon']) ? $requestBody['icon'] : $application->icon,
            'description' => isset($requestBody['description']) ? $requestBody['description'] : $application->description,
            'json_body' => isset($requestBody['json_body']) ? $requestBody['json_body'] : $application->json_body,
            'paid' => isset($requestBody['paid']) ? $requestBody['paid'] : $application->paid,
            'version' => isset($requestBody['version']) ? $requestBody['version'] : $application->version,
            'version_date' => isset($requestBody['version_date']) ? $requestBody['version_date'] : $application->version_date,
            'type' => isset($requestBody['type']) ? $requestBody['type'] : $application->type,
            'module' => isset($requestBody['module']) ? $requestBody['module'] : $application->module,
            'load_events' => isset($requestBody['load_events']) ? $requestBody['load_events'] : $application->load_events,
            'script_uri' => isset($requestBody['script_uri']) ? $requestBody['script_uri'] : $application->script_uri,
            'github_repository' => isset($requestBody['github_repository']) ? $requestBody['github_repository'] : $application->github_repository,
            'authentication' => isset($requestBody['authentication']) ? $requestBody['authentication'] : $application->authentication,
            'auth_callback_uri' => isset($requestBody['auth_callback_uri']) ? $requestBody['auth_callback_uri'] : $application->auth_callback_uri,
            'auth_scope' => isset($requestBody['auth_scope']) ? $requestBody['auth_scope'] : $application->auth_scope,
            'avg_stars' => isset($requestBody['avg_stars']) ? $requestBody['avg_stars'] : $application->avg_stars,
            'evaluations' => isset($requestBody['evaluations']) ? $requestBody['evaluations'] : $application->evaluations,
            'website' => isset($requestBody['website']) ? $requestBody['website'] : $application->website,
            'link_video' => isset($requestBody['link_video']) ? $requestBody['link_video'] : $application->link_video,
            'plans_json' => isset($requestBody['plans_json']) ? $requestBody['plans_json'] : $application->plans_json,
            'value_plan_basic' => isset($requestBody['value_plan_basic']) ? $requestBody['value_plan_basic'] : $application->value_plan_basic,
        ];

        $update = $application->update($updateBody);

        if (!$update) {
            $return = [
                'status' => 400,
                'message' => 'Bad-formatted JSON body, details in user_message',
                'user_message' => [
                    'en_us' => 'data should NOT have additional properties',
                    'pt_br' => 'data Não são permitidas propriedades adicionais',
                ],
            ];

            return $response->withJson($return, 400);
        }

        return $response->withStatus(204);
    }
}
