<?php
namespace Market\Controller;

use Market\Model\BuyApps;
use Market\Services\Database;


class BuyAppsController
{
    
    function __construct()
    {
        new Database();
    }

    public function getBuyApps($request, $response, $args)
    {
        $body = $request->getParsedBody();
        $params = [
            'payment_status' => 1,
            //'store_id' => $body['id']
            'store_id' => 1
        ];
        $apps = BuyApps::where($params)->with('app')->get()->toArray();
    }
}
