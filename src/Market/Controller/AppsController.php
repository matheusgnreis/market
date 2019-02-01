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
    private $_fields = ["id", "title", "slug", "thumbnail", "version", "paid"];
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
        metafields
         */
        $this->requestHasMeta($request);
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
        $query = Apps::where('id', $args['id'])->get();
        //$query = Apps::find($args['id']);
        $map = $query->map(function ($item) {
            $data['app_id'] = $item->id;
            $data['title'] = $item->title;
            $data['slug'] = $item->slug;
            $data['paid'] = (boolean) $item->paid;
            $data['version'] = $item->version;
            //$data['version_date'] = $item->version_date;
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
            $data['state'] = 'active';
            $data['status'] = 'active';
            return $data;
        });

        return $map ? $response->withJson($map[0], 200)
        : $response->withJson([], 404);
    }

    public function requestHasMeta($request)
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
}
