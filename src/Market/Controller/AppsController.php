<?php
namespace Market\Controller;

use Market\Model\Apps;

/**
 * Undocumented class
 */
class AppsController
{
    private $_limit = 30;
    private $_offset = 0;
    private $_fields = ['app_id', 'title', 'category', 'slug', 'icon', 'version', 'paid', 'short_description', 'evaluations', 'downloads'];
    private $_result = ['id', 'partner_id', 'title', 'slug', 'css', 'js', 'json_schema', 'icon'];
    private $_params = ['active' => 1];
    /**
     * Construtor
     */
    public function __construct()
    {
        new \Market\Services\Database();
    }

    public function getAll($params)
    {

        /*
        find multiples ids
         */
        if (isset($params['app_id'])) {
            $ids = explode(',', $params['app_id']);
            $apps = Apps::whereIn('app_id', $ids)->get($this->_fields);
            return $this->response($apps->toArray());
        }

        /*
        metafields
         */
        $this->requestHasMeta($params);
        /*
        search
         */
        $result = Apps::where($this->_params)
            ->offset($this->_offset)
            ->limit($this->_limit)
            ->get($this->_fields)
            ->toArray();
        return $this->response($result);
    }

    public function getById($applicationId)
    {
        $app = Apps::where('app_id', $applicationId)->get();
        if ($app) {
            $map = $app->map(function ($application) {
                $data['app_id'] = $application->app_id;
                $data['title'] = $application->title;
                $data['slug'] = $application->slug;
                $data['category'] = $application->category;
                $data['icon'] = $application->icon;
                $data['description'] = (string) $application->description;
                $data['short_description'] = $application->short_description;
                $data['json_body'] = json_decode($application->json_body);
                $data['paid'] = (boolean) $application->paid;
                $data['free_trial'] = $application->free_trial;
                $data['version'] = $application->version;
                $data['version_date'] = $application->version_date;
                $data['type'] = $application->type;
                if (!empty($application->module)) {
                    $data['module'] = json_decode($application->module);
                }
                if (!empty($application->load_events)) {
                    $data['load_events'] = explode(',', str_replace(["\\", "[", "]", '"'], '', (string) $application->load_events));
                }
                if (!empty($application->script_uri)) {
                    $data['script_uri'] = $application->script_uri;
                }
                if (!empty($application->redirect_uri)) {
                    $data['redirect_uri'] = $application->redirect_uri;
                }
                $data['github_repository'] = $application->github_repository;
                $data['authentication'] = (boolean) $application->authentication;
                $data['auth_callback_uri'] = $application->auth_callback_uri;
                $data['auth_scope'] = json_decode($application->auth_scope);
                $data['avg_stars'] = $application->avg_stars;
                $data['evaluations'] = $application->evaluations;
                $data['downloads'] = $application->downloads;
                $data['website'] = $application->website;
                $data['link_video'] = $application->link_video;
                $data['plans_json'] = json_decode($application->plans_json);
                $data['value_plan_basic'] = $application->value_plan_basic;
                $data['pictures'] = $application->imagens;
                $data['comments'] = $application->comments->toArray();
                $data['partner'] = $application->partner->toArray();
                $data['active'] = $application->active;
                return $data;
            });
            return $map[0];
        }
        return [];
    }

    public function getBySlug($applicationSlug)
    {
        $app = Apps::where('slug', $applicationSlug)->first();
        if ($app) {
            return [
                'application' => $app->toArray(),
                'imagens' => $app->imagens->toArray(),
                'comments' => $app->comments->toArray(),
                'partner' => $app->partner->toArray(),
            ];
        }
        return false;
    }

    public function requestHasMeta($params)
    {
        /*
        Possíveis parametros para busca
         */
        if (isset($params['filter'])) {
            if ($params['filter'] == 'free') {
                $this->_params[] = ['value_plan_basic', 0];
            }
        }

        if (isset($params['author'])) {
            $this->_params[] = ['partner_id', $params['author']];
        }

        if (isset($params['slug'])) {
            $this->_params[] = ['slug', $params['slug']];
        }

        if (isset($params['category'])) {
            if ($params['category'] !== 'all') {
                $this->_params[] = ['category', $params['category']];
            }
        }

        if (isset($params['title'])) {
            $this->_params[] = ['title', 'like', '%' . $params['title'] . '%'];
        }

        /*
        offset
         */
        if (isset($params['offset'])) {
            $this->_offset = (int) $params['offset'];
        }

        /*
        limit
         */
        if (isset($params['limit'])) {
            $this->_limit = (int) $params['limit'];
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

    public function create($body)
    {
        $applicationbody = [
            'partner_id' => !empty($body['partner_id']) ? $body['partner_id'] : null,
            'title' => !empty($body['title']) ? $body['title'] : null,
            'slug' => !empty($body['slug']) ? $body['slug'] : null,
            'category' => !empty($body['category']) ? $body['category'] : null,
            'icon' => !empty($body['icon']) ? $body['icon'] : null,
            'description' => !empty($body['description']) ? $body['description'] : null,
            'short_description' => !empty($body['short_description']) ? $body['short_description'] : null,
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

        $application = Apps::create($applicationbody);

        if (!$application) {
            return [
                'status' => 400,
                'message' => 'Error with request on this resource',
                'user_message' => [
                    'en_us' => 'Unexpected error, report to support or responsible developer',
                    'pt_br' => 'Erro inesperado, reportar ao suporte ou desenvolvedor responsável',
                ],
            ];
        }
        return $application;
    }

    public function patch($applicationId, $requestBody)
    {

        $application = Apps::find($applicationId);
        if (isset($requestBody['title'])) {
            $application->title = $requestBody['title'];
        }
        if (isset($requestBody['slug'])) {
            $application->slug = $requestBody['slug'];
        }
        if (isset($requestBody['category'])) {
            $application->category = $requestBody['category'];
        }
        if (isset($requestBody['icon'])) {
            $application->icon = $requestBody['icon'];
        }
        if (isset($requestBody['description'])) {
            $application->description = $requestBody['description'];
        }
        if (isset($requestBody['json_body'])) {
            $application->json_body = $requestBody['json_body'];
        }
        if (isset($requestBody['paid'])) {
            $application->paid = $requestBody['paid'];
        }
        if (isset($requestBody['version'])) {
            $application->version = $requestBody['version'];
        }
        if (isset($requestBody['version_date'])) {
            $application->version_date = $requestBody['version_date'];
        }
        if (isset($requestBody['type'])) {
            $application->type = $requestBody['type'];
        }
        if (isset($requestBody['module'])) {
            $application->module = $requestBody['module'];
        }
        if (isset($requestBody['load_events'])) {
            $application->load_events = $requestBody['load_events'];
        }
        if (isset($requestBody['script_uri'])) {
            $application->script_uri = $requestBody['script_uri'];
        }
        if (isset($requestBody['github_repository'])) {
            $application->github_repository = $requestBody['github_repository'];
        }
        if (isset($requestBody['authentication'])) {
            $application->authentication = $requestBody['authentication'];
        }
        if (isset($requestBody['auth_callback_uri'])) {
            $application->auth_callback_uri = $requestBody['auth_callback_uri'];
        }
        if (isset($requestBody['auth_scope'])) {
            $application->auth_scope = $requestBody['auth_scope'];
        }
        if (isset($requestBody['avg_stars'])) {
            $application->avg_stars = $requestBody['avg_stars'];
        }
        if (isset($requestBody['evaluations'])) {
            $application->evaluations = $requestBody['evaluations'];
        }
        if (isset($requestBody['website'])) {
            $application->website = $requestBody['website'];
        }
        if (isset($requestBody['link_video'])) {
            $application->link_video = $requestBody['link_video'];
        }
        if (isset($requestBody['plans_json'])) {
            $application->plans_json = $requestBody['plans_json'];
        }
        if (isset($requestBody['value_plan_basic'])) {
            $application->value_plan_basic = $requestBody['value_plan_basic'];
        }
        if (isset($requestBody['active'])) {
            $application->active = $requestBody['active'];
        }
        if (!$application->save()) {
            return [
                'erros' => true,
                'status' => 400,
                'message' => 'Bad-formatted JSON body, details in user_message',
                'user_message' => [
                    'en_us' => 'data should NOT have additional properties',
                    'pt_br' => 'data Não são permitidas propriedades adicionais',
                ],
            ];
        }

        return 204;
    }

    public function update($applicationId, $requestBody)
    {
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
            return [
                'status' => 400,
                'message' => 'Bad-formatted JSON body, details in user_message',
                'user_message' => [
                    'en_us' => 'data should NOT have additional properties',
                    'pt_br' => 'data Não são permitidas propriedades adicionais',
                ],
            ];
        }

        return 204;
    }

    public function delete($applicationId)
    {
        $application = Apps::find($applicationId);
        if ($application) {
            if ($application->delete()) {
                return true;
            }
        }
        return false;
    }
}
