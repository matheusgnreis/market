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
