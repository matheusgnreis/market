<?php
namespace Market\Controller;

use Market\Model\Themes;

class ThemesController
{
    private $_limit = 30;
    private $_offset = 0;
    private $_fields = ['id', 'title', 'slug', 'category', 'thumbnail', 'paid', 'value_license_basic', 'value_license_extend'];
    private $_result = [];
    private $_params = [];

    public function __construct()
    {
        new \Market\Services\Database();
    }

    public function getAll($params)
    {

        /*
        find multiples ids
         */
        if (isset($params['theme_id'])) {
            $ids = explode(',', $params['theme_id']);
            $apps = Themes::whereIn('id', $ids)->get($this->_fields);
            return $this->response($apps->toArray());
        }

        /*
        metafields
         */
        $this->requestHasMeta($params);
        /*
        search
         */
        $result = Themes::where($this->_params)
            ->offset($this->_offset)
            ->limit($this->_limit)
            ->get($this->_fields)
            ->toArray();
        return $this->response($result);
    }

    public function getById($themeId)
    {
        return Themes::find($themeId);
    }

    public function getBySlug($slug)
    {
        $theme = Apps::where('slug', $applicationSlug)->first();
        if ($theme) {
            return [
                'theme' => $theme->toArray(),
                'imagens' => $theme->imagens->toArray(),
                'comments' => $theme->comments->toArray(),
                'partner' => $theme->partner->toArray(),
            ];
        }
        return false;
    }

    public function requestHasMeta($params)
    {
        /*
        Possíveis parametros para busca
         */
        if (isset($params['paid'])) {
            $this->_params[] = ['paid', $params['paid']];
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
        $theme = Themes::create(
            [
                'partner_id' => $body['partner_id'],
                'title' => $body['title'],
                'slug' => $body['slug'],
                'category' => $body['category'],
                'thumbnail' => $body['thumbnail'],
                'description' => $body['description'],
                'json_body' => $body['json_body'],
                'paid' => $body['paid'],
                'version' => $body['version'],
                'version_date' => $body['version_date'],
                'avg_stars' => 0,
                'evaluations' => 0,
                'link_documentation' => $body['link_documentation'],
                'link_video' => $body['link_video'],
                'value_license_basic' => isset($body['value_license_basic']) ? $body['value_license_basic'] : 0,
                'value_license_extend' => isset($body['value_license_extend']) ? $body['value_license_extend'] : 0,
            ]
        );

        return $theme;
    }

    public function update($themeId, $bodyUpdate)
    {
        $theme = Themes::find($themeId);

        $body = $bodyUpdate;
        $update = $theme->update(
            [
                'title' => isset($body['title']) ? $body['title'] : $theme->title,
                'slug' => isset($body['slug']) ? $body['slug'] : $theme->slug,
                'category' => isset($body['category']) ? $body['category'] : $theme->category,
                'thumbnail' => isset($body['thumbnail']) ? $body['thumbnail'] : $theme->thumbnail,
                'description' => isset($body['description']) ? $body['description'] : $theme->description,
                'json_body' => isset($body['json_body']) ? $body['json_body'] : $theme->json_body,
                'paid' => isset($body['paid']) ? $body['paid'] : $theme->paid,
                'version' => isset($body['version']) ? $body['version'] : $theme->version,
                'version_date' => isset($body['version_date']) ? $body['version_date'] : $theme->version_date,
                'avg_stars' => isset($body['avg_stars']) ? $body['avg_stars'] : $theme->avg_stars,
                'evaluations' => isset($body['evaluations']) ? $body['evaluations'] : $theme->evaluations,
                'link_documentation' => isset($body['link_documentation']) ? $body['link_documentation'] : $theme->link_documentation,
                'link_video' => isset($body['link_video']) ? $body['link_video'] : $theme->link_video,
                'value_license_basic' => isset($body['value_license_basic']) ? $body['value_license_basic'] : $theme->value_license_basic,
                'value_license_extend' => isset($body['value_license_extend']) ? $body['value_license_extend'] : $theme->value_license_extend,
            ]
        );

        return $update;
    }

    public function destroy($request, $response, $args)
    {
        return Themes::where('id', '=', $args['id'])->delete() ? $response->withJson(['success' => 'Theme deleted'], 204) : $response->withJson(['erro' => 'Theme not found'], 404);
    }
}
