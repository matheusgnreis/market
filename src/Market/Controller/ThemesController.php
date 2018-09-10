<?php
namespace Market\Controller;

use Slug\Slugifier as Slugifier;

use Market\Model\Themes;

class ThemesController
{
    public function __construct()
    {
        new \Market\Services\Database();
    }

    public function getAll($request, $response, $args)
    {
        $params = $this->getSearchParams($request);
        $skip = $this->getSearchSkip($request);
        $take = $this->getSearchTake($request);
        return Themes::where($params)->skip($skip)->take($take)->with('partner')->get()->toArray();
        
        //return $ret ? $response->withJson($ret, 200) : $response->withJson([], 404);
    }

    public function getById($request, $response, $args)
    {
        $ret = Themes::find($args['id'])
                                    ->evaluations()
                                    ->partner()
                                    ->comments()
                                    ->imagens();
        
        return $ret ? $response->withJson($ret, 200) : $response->withJson([], 404);
    }

    public function getBySlug($request, $response, $args)
    {
        $ret = Themes::where('slug', $args['slug'])->get();
        return $response->withJson($ret, 200);
    }

    public function getSearchParams($request)
    {
        $search = [];
        
        if (isset($request->getParams()['free'])) {
            if ($request->getParams()['free'] == 1) {
                $search[] = ['value_plan_basic', 0];
            }
        }

        if (isset($request->getParams()['title'])) {
            $search[] = ['title', $request->getParams()['title']];
        }

        if (isset($request->getParams()['category'])) {
            $search[] = ['category', $request->getParams()['category']];
        }

        if (isset($request->getParams()['partner'])) {
            $search[] = ['partner_id', $request->getParams()['partner_id']];
        }

        return $search;
    }

    public function getSearchSkip($request)
    {
        return isset($request->getParams()['skip']) ? (int) $request->getParams()['skip'] : 0;
    }

    public function getSearchTake($request)
    {
        return isset($request->getParams()['take']) ? (int) $request->getParams()['take'] : 10;
    }
    
    public function create($request, $response, $args)
    {
        $body = $request->getParsedBody();

        $theme = Apps::create([
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
            'avg_stars' => $body['avg_stars'],
            'evaluations' => $body['evaluations'],
            'link_documentation' => $body['link_documentation'],
            'link_video' => $body['link_video'],
            'value_license_basic' => $body['value_license_basic'],
            'value_license_extend' => $body['value_license_extend']
        ]);

        return $theme ? $response->withJson(['status' => 201, 'message' => 'created', 'theme_id' => $theme->id], 201) : $response->withJson(['erro' => 'Error with ThemesController request'], 400);
    }

    public function update($request, $response, $args)
    {
        if (!$args['id']) {
            return $response->withJson(['status' => 400, 'message' => 'theme_id not found'], 400);
        }

        $theme = Themes::find($args['id']);

        if (!$theme) {
            return $response->withJson(['status' => 400, 'message' => 'theme not found'], 400);
        }

        $body = $request->getParsedBody();
        $update = $theme->update([
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
        ]);

        return $update ? $response->withJson(['status' => 201, 'message' => 'updated'], 201) : false;
    }

    public function destroy($request, $response, $args)
    {
        return Themes::where('id', '=', $args['id'])->delete() ? $response->withJson(['success' => 'Theme deleted'], 204) : $response->withJson(['erro' => 'Theme not found'], 404);
    }
}
