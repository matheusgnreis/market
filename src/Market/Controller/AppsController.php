<?php
namespace Market\Controller;

use Slug\Slugifier as Slugifier;
use Market\Model\Apps;

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
        $ret = Apps::where($params)->skip($skip)->take($take)->get();
        return $ret ? $response->withJson($ret, 200) : $response->withJson([], 404);
    }

    public function getById($request, $response, $args)
    {
        $ret = Apps::find($args['id'])
                                    ->evaluations()
                                    ->partner()
                                    ->comments()
                                    ->imagens();

        return $ret ? $response->withJson($ret, 200) : $response->withJson([], 404);
    }
    
    public function getBySlug($request, $response, $args)
    {
        $ret = Apps::where('slug', $args['slug'])->get();
        return $response->withJson($ret, 200);
    }

    public function getSearchParams($request)
    {
        $search = [];
        $search[] = ['active', 1];
        
        if (isset($request->getParams()['free'])) {
            if ($request->getParams()['free'] == 1) {
                $search[] = ['value_plan_basic', 0];
            }
        }

        if (isset($request->getParams()['title'])) {
            $search[] = ['title', $request->getParams()['title']];
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

        $app = Apps::create([
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
            'type' => $body['type'],
            'module' => $body['module'],
            'load_events' => $body['load_events'],
            'script_uri' => $body['script_uri'],
            'github_repository' => $body['github_repository'],
            'authentication' => $body['authentication'],
            'auth_callback_uri' => $body['auth_callback_uri'],
            'auth_scope' => $body['auth_scope'],
            'avg_stars' => $body['avg_stars'],
            'evaluations' => $body['evaluations'],
            'website' => $body['website'],
            'link_video' => $body['link_video'],
            'plans_json' => $body['plans_json'],
            'value_plan_basic' => $body['value_plan_basic'],
            'active' => $body['active']
        ]);

        return $app ? $response->withJson(['status' => 201, 'message' => 'created', 'app_id' => $app->id], 201) : $response->withJson(['erro' => 'Error creating new app'], 400);
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
}
