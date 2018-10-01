<?php
namespace Market\Controller;

use Slug\Slugifier as Slugifier;
use Market\Model\Apps;
use Market\Services\Helpers;

class AppsController
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
        $apps = Apps::where($params)->skip($skip)->take($take)->with('partner')->get()->toArray();
        return (object)[
            'apps' => $apps,
            'total' => Apps::where($params)->count()
        ];
    }

    public function getById($request, $response, $args)
    {
        //$ret = Apps::find($args['id'])->with('imagens')->toArray();
        $ret = Apps::where('id', $args['id'])->first();
        return $ret ? ['app'=>$ret->toArray(), 'imagens' => array_map(function ($a) {
            $r['path'] = $a['path_image'];
            $r['id'] = $a['id'];
            return $r;
        }, $ret->imagens->toArray())] : [];
        //return $ret ? $response->withJson($ret, 200) : $response->withJson([], 404);
    }
    
    public function getBySlug($request, $response, $args)
    {
        $app = Apps::where('slug', $args['slug'])->first();

        if ($app) {
            return (object) [
                'app' => $app->toArray(),
                //'imagens' => $app->imagens->toArray(),
                'imagens' => array_map(function ($a) {
                    $r['path'] = $a['path_image'];
                    return $r;
                }, $app->imagens->toArray()),
                'partner' => $app->partner->toArray(),
                'comments' => $app->comments->toArray(),
                'evaluations' => $app->evaluations
            ];
        }
        return false;
    }

    public function getByPartnerId($request, $response, $args)
    {
        $id = $request->getAttribute('partner_id');
        $ret = Apps::where('partner_id', $id)->get()->toArray();
        return $ret ? (array)$ret : [];
        //return $ret ? $response->withJson($ret, 200) : $response->withJson([], 404);
    }

    public function getSearchParams($request)
    {
        $search = [];
        $search[] = ['active', 1];
        
        if (isset($request->getParams()['filter'])) {
            if ($request->getParams()['filter'] == 'free') {
                $search[] = ['value_plan_basic', 0];
            }
        }

        if (isset($request->getParams()['author'])) {
            $search[] = ['partner_id', $request->getParams()['author']];
        }

        if (isset($request->getParams()['category'])) {
            if ($request->getParams()['category'] !== 'all') {
                $search[] = ['category', $request->getParams()['category']];
            }
        }

        if (isset($request->getParams()['title'])) {
            $search[] = ['title','like', '%' . $request->getParams()['title'] . '%'];
        }

        return $search;
    }

    public function getSearchSkip($request)
    {
        return isset($request->getParams()['skip']) ? (int) $request->getParams()['skip'] : 0;
    }

    public function getSearchTake($request)
    {
        return isset($request->getParams()['take']) ? (int) $request->getParams()['take'] : 12;
    }

    public function create($request, $response, $args)
    {
        $body = $request->getParsedBody();

        $app = Apps::create([
                    'partner_id' => !empty($body['partner_id']) ? $body['partner_id'] : null,
                    'title' => !empty($body['title']) ? $body['title'] : null,
                    'slug' => !empty($body['slug']) ? $body['slug'] : null,
                    'category' => !empty($body['category']) ? $body['category'] : null,
                    'thumbnail' => !empty($body['thumbnail']) ? $body['thumbnail'] : null,
                    'description' => !empty($body['description']) ? $body['description'] : null,
                    'json_body' => !empty($body['json_body']) ? $body['json_body'] : null,
                    'paid' => isset($body['paid']) ? $body['paid'] : null,
                    'version' => !empty($body['version']) ? $body['version'] : null,
                    'version_date' => !empty($body['version_date']) ? $body['version_date'] : null,
                    'type' => !empty($body['type']) ? $body['type'] : null,
                    'module' => !empty($body['module']) ? $body['module'] : null,
                    'load_events' => !empty($body['load_events']) ? (string)(json_encode($body['load_events'])) : null,
                    'script_uri' => !empty($body['script_uri']) ? $body['script_uri'] : null,
                    'github_repository' => !empty($body['github_repository']) ? $body['github_repository'] : null,
                    'authentication' => isset($body['authentication']) ? $body['authentication'] : null,
                    'auth_callback_uri' => !empty($body['auth_callback_uri']) ? $body['auth_callback_uri'] : null,
                    'auth_scope' => !empty($body['auth_scope']) ? $body['auth_scope'] : null,
                    'avg_stars' => !empty($body['avg_stars']) ? $body['avg_stars'] : null,
                    'evaluations' => !empty($body['evaluations']) ? $body['evaluations'] : null,
                    'website' => !empty($body['website']) ? $body['website'] : null,
                    'link_video' => !empty($body['link_video']) ? $body['link_video'] : null,
                    'plans_json' => !empty($body['plans_json']) ? $body['plans_json'] : null,
                    'value_plan_basic' => !empty($body['value_plan_basic']) ? $body['value_plan_basic'] : null,
                    'active' => !empty($body['active']) ? $body['active'] : 1
        ]);
        
        return $app ? $response->withJson(['status' => 201, 'message' => 'created', 'app' => $app], 201) : $response->withJson(['erro' => 'Error creating new app'], 400);
    }

    public function update($request, $response, $args)
    {
        if (!$args['id']) {
            return $response->withJson(['status' => 400, 'message' => 'app_id not found'], 400);
        }

        $app = Apps::find($args['id']);

        if (!$app) {
            return $response->withJson(['status' => 400, 'message' => 'app not found'], 400);
        }

        $body = $request->getParsedBody();
        $update = $app->update([
            'partner_id' => isset($body['partner_id']) ? $body['partner_id'] : $app->partner_id,
            'title' => isset($body['title']) ? $body['title'] : $app->title,
            'slug' => isset($body['slug']) ? $body['slug'] : $app->slug,
            'category' => isset($body['category']) ? $body['category'] : $app->category,
            'thumbnail' => isset($body['thumbnail']) ? $body['thumbnail'] : $app->thumbnail,
            'description' => isset($body['description']) ? $body['description'] : $app->description,
            'json_body' => isset($body['json_body']) ? $body['json_body'] : $app->json_body,
            'paid' => isset($body['paid']) ? $body['paid'] : $app->paid,
            'version' => isset($body['version']) ? $body['version'] : $app->version,
            'version_date' => isset($body['version_date']) ? $body['version_date'] : $app->version_date,
            'type' => isset($body['type']) ? $body['type'] : $app->type,
            'module' => isset($body['module']) ? $body['module'] : $app->module,
            'load_events' => isset($body['load_events']) ? $body['load_events'] : $app->load_events,
            'script_uri' => isset($body['script_uri']) ? $body['script_uri'] : $app->script_uri,
            'github_repository' => isset($body['github_repository']) ? $body['github_repository'] : $app->github_repository,
            'authentication' => isset($body['authentication']) ? $body['authentication'] : $app->authentication,
            'auth_callback_uri' => isset($body['auth_callback_uri']) ? $body['auth_callback_uri'] : $app->auth_callback_uri,
            'auth_scope' => isset($body['auth_scope']) ? $body['auth_scope'] : $app->auth_scope,
            'avg_stars' => isset($body['avg_stars']) ? $body['avg_stars'] : $app->avg_stars,
            'evaluations' => isset($body['evaluations']) ? $body['evaluations'] : $app->evaluations,
            'website' => isset($body['website']) ? $body['website'] : $app->website,
            'link_video' => isset($body['link_video']) ? $body['link_video'] : $app->link_video,
            'plans_json' => isset($body['plans_json']) ? $body['plans_json'] : $app->plans_json,
            'value_plan_basic' => isset($body['value_plan_basic']) ? $body['value_plan_basic'] : $app->value_plan_basic,
            'active' => isset($body['active']) ? $body['active'] : $app->active
        ]);

        return $update ? $response->withJson(['status' => 201, 'message' => 'updated'], 201) : false;
    }

    public function destroy($request, $response, $args)
    {
        return Apps::where('id', '=', $args['id'])->delete() ? $response->withJson(['success' => 'App deleted'], 204) : $response->withJson(['erro' => 'App not found'], 404);
    }

    public function verifySlug($request, $response, $args)
    {
        $slug = $args['slug'];
        $app = Apps::where('slug', $slug)->first();

        if ($app) {
            return $response->withJson([
                'status' => 409,
                'message' => 'slug in use',
                'suggestions' => [
                    $slug.'-'.Helpers::randomSlug(),
                    $slug.'-'.Helpers::randomSlug(),
                    $slug.'-'.Helpers::randomSlug(),
                    $slug.'-'.Helpers::randomSlug()
                ]
            ]);
        }
        return $response->withJson(['status' => 302, 'message' => 'valid']);
    }
}
