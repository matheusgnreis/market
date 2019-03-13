<?php
namespace Market\Controller;

use Market\Model\Widgets;

class WidgetsController
{
    private $_limit = 30;
    private $_offset = 0;
    private $_fields = ['app_id', 'partner_id', 'title', 'slug', 'url_css', 'template', 'url_js', 'config', 'icon', 'short_description', 'description', 'category', 'version', 'version_date', 'paid', 'active', 'website', 'downloads', 'plans_json'];
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
            $apps = Widgets::whereIn('id', $ids)->get($this->_fields);
            return $this->response($apps->toArray());
        }

        /*
        metafields
         */
        $this->requestHasMeta($params);
        /*
        search
         */
        $result = Widgets::where($this->_params)
            ->offset($this->_offset)
            ->limit($this->_limit)
            ->get($this->_fields);
            //->toArray();

        $filter = $result->filter(function ($value, $key) {
            if ($value !== null && $value !== "") {
                return $value;
            }
        });

        /*             $result = Widgets::limit(30)->offset(30)->get(['id']); */
        return $this->response($filter->all());
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
        return Widgets::find($componentId);
    }

    public function getBySlug($component)
    {
        $widget = Widgets::where('slug', $component)->first();
        if ($widget) {
            return [
                'application' => $widget->toArray(),
                //'imagens' => $widget->imagens->toArray(),
                //'comments' => $widget->comments->toArray(),
                'partner' => $widget->partner->toArray(),
            ];
        }
        return false;
    }

    public function create($body)
    {
        $component = [
            'partner_id' => !empty($body['partner_id']) ? $body['partner_id'] : null,
            'title' => !empty($body['title']) ? $body['title'] : null,
            'slug' => !empty($body['slug']) ? $body['slug'] : null,
            'url_css' => !empty($body['url_css']) ? $body['url_css'] : null,
            'url_js' => !empty($body['url_js']) ? $body['url_js'] : null,
            'template' => !empty($body['template']) ? $body['template'] : null,
            'config' => !empty($body['config']) ? $body['config'] : null,
            'paid' => !empty($body['paid']) ? $body['paid'] : null,
            'icon' => !empty($body['icon']) ? $body['icon'] : null,
        ];

        $result = Widgets::create($component);

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

        $component = Widgets::find($componentId);

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
            'partner_id' => !empty($componentBody['partner_id']) ? $componentBody['partner_id'] : $component->partner_id,
            'title' => !empty($componentBody['title']) ? $componentBody['title'] : $component->title,
            'slug' => !empty($componentBody['slug']) ? $componentBody['slug'] : $component->slug,
            'url_css' => !empty($componentBody['url_css']) ? $componentBody['url_css'] : $component->url_css,
            'url_js' => !empty($componentBody['url_js']) ? $componentBody['url_js'] : $component->url_js,
            'template' => !empty($componentBody['template']) ? $componentBody['template'] : $component->template,
            'config' => !empty($componentBody['config']) ? $componentBody['config'] : $component->config,
            'paid' => !empty($componentBody['paid']) ? $componentBody['paid'] : $component->paid,
            'icon' => !empty($componentBody['icon']) ? $componentBody['icon'] : $component->icon,
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
