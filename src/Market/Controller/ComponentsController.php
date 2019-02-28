<?php
namespace Market\Controller;

use Market\Model\Components;

class ComponentsController
{
    private $_limit = 30;
    private $_offset = 0;
    private $_fields = [];
    private $_result = [];
    private $_params = ['active' => 1];

    public function __construct()
    {
        new \Market\Services\Database();
    }

    public function getAll($params)
    {
        /*
        find multiples ids
         */
        if (isset($params['id'])) {
            $ids = explode(',', $params['id']);
            $apps = Components::whereIn('id', $ids)->get($this->_fields);
            return $this->response($apps->toArray());
        }

        /*
        metafields
         */
        $this->requestHasMeta($params);
        /*
        search
         */
        $result = Components::where($this->_params)
            ->offset($this->_offset)
            ->limit($this->_limit)
            ->get($this->_fields)
            ->toArray();

        /*             $result = Components::limit(30)->offset(30)->get(['id']); */
        return $this->response($result);
    }

    public function requestHasMeta($params)
    {
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

    public function getById($componentId)
    {
        return Components::find($componentId);
    }

    public function getBySlug($component)
    {
        return Components::where('slug', $component)->first();
    }

    public function create($body)
    {
        $component = [
            'partner_id' => !empty($body['partner_id']) ? $body['partner_id'] : null,
            'title' => !empty($body['title']) ? $body['title'] : null,
            'slug' => !empty($body['slug']) ? $body['slug'] : null,
            'ejs' => !empty($body['ejs']) ? $body['ejs'] : null,
            'js' => !empty($body['js']) ? $body['js'] : null,
            'json_schema' => !empty($body['json_schema']) ? $body['json_schema'] : null,
            'icon' => !empty($body['icon']) ? $body['icon'] : null,
        ];

        $result = Components::create($component);

        if (!$result) {
            return [
                'status' => 400,
                'message' => 'Error with request on this resource',
                'user_message' => [
                    'en_us' => 'Unexpected error, report to support or responsible developer',
                    'pt_br' => 'Erro inesperado, reportar ao suporte ou desenvolvedor responsável',
                ],
            ];
        }

        return $result;
    }

    public function update($componentId, $componentBody)
    {
        if (!$componentId) {
            return [
                'status' => 400,
                'message' => 'Resource ID expected and not specified on request UR',
                'user_message' => [
                    'en_us' => 'Unexpected error, report to support or responsible developer',
                    'pt_br' => 'Erro inesperado, reportar ao suporte ou desenvolvedor responsável',
                ],
            ];
        }

        $component = Components::find($componentId);

        if (!$component) {
            return [
                'status' => 400,
                'message' => 'Invalid value on resource ID',
                'user_message' => [
                    'en_us' => 'The informed ID is invalid',
                    'pt_br' => 'O ID informado é inválido',
                ],
            ];
        }

        $componentUpdate = [
            'partner_id' => !empty($body['partner_id']) ? $body['partner_id'] : $component->partner_id,
            'title' => !empty($body['title']) ? $body['title'] : $component->title,
            'slug' => !empty($body['slug']) ? $body['slug'] : $component->slug,
            'ejs' => !empty($body['ejs']) ? $body['ejs'] : $component->ejs,
            'js' => !empty($body['js']) ? $body['js'] : $component->js,
            'json_schema' => !empty($body['json_schema']) ? $body['json_schema'] : $component->json_schema,
            'icon' => !empty($body['icon']) ? $body['icon'] : $component->icon,
        ];

        $update = $component->update($componentUpdate);

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
}
