<?php
namespace Market\Controller;

use Market\Model\Login;
use Market\Services\Database;

class LoginController extends Login
{
    public function __construct()
    {
        parent::__construct();
        new Database();
    }

    public function login($request, $response, $args)
    {
    }

    public function hasLogin($request, $response, $args)
    {
    }

    public function password($request, $response, $args)
    {
    }

    public function createPassword($request, $response, $args)
    {
        $body = $request->getParsedBody();

        $user = json_decode(base64_decode($body['u']));

        parent::setPassword($user[0] , $body['p']);
    }

    public function verify($request, $response, $args)
    {
        $body = $request->getParsedBody();
        $ret = parent::getApiLogin($body['user_email']);
        
        if(!$ret['erro']){
            return json_encode(['user' => base64_encode(json_encode($ret))]);
        }
        return json_encode($ret);
    }
}
