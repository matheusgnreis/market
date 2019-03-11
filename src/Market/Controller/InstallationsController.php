<?php
namespace Market\Controller;

use Market\Model\Installations;

class InstallationsController
{
    private $_limit = 30;
    private $_offset = 0;
    private $_fields = ['id', 'widget_id', 'installed_at', 'store_id', 'state', 'status'];
    private $_result = [];
    private $_params = ['status' => 'active'];

    public function __construct()
    {
        new \Market\Services\Database();
    }

    public function getAll($params)
    {
        $result = Installations::with('widgets')->where($this->_params)
            ->offset($this->_offset)
            ->limit($this->_limit)
            ->get()
            ->toArray();

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

    public function getByStoreId($storeId, $authentication = false)
    {
        $result = Installations::with('widgets')->where(['store_id' => $storeId])->get();

        if ($result) {
            $map = $result->map(function ($installation) {
                $data['app_id'] = $installation->widgets[0]->app_id;
                $data['template'] = $installation->widgets[0]->template;
                $data['config'] = $installation->widgets[0]->config;
                if ($authentication) {
                    $data['url_css'] = $installation->widgets[0]->url_css;
                    $data['url_js'] = $installation->widgets[0]->url_js;
                }
                return $data;
            });
            $result = $map;
        }
        return $result;
    }

    public function create($body)
    {
    }

    public function update($componentId, $componentBody)
    {
    }
}
