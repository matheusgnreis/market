<?php
namespace Market\Controller;

use Market\Model\Login;
use Market\Services\Database;
use Market\Model\Partner;

class LoginController extends Login
{
    private $sessao = true;
    private $cookie = true;
    private $rememberTime = 7; //in days
    private $cookiePath = '/';

    public function __construct()
    {

        parent::__construct();
        new Database();
    }

    public function login($request, $response, $args)
    {
        $body = $request->getParsedBody();
        $user_api = parent::getApiLogin($body['u']);
        if ($user_api) {
            $u = Partner::find($user_api[0]->id);
            $u = (object)$u->makeVisible(['password_hash'])->toArray();
            var_dump($u->password_hash);

        }
    }

    public function hasLogin($request, $response, $args)
    {
    }

    public function password($request, $response, $args)
    {
        $body = $request->getParsedBody();

        $user = json_decode(base64_decode($body['u']));

        parent::setPassword($user[0], $body['p']);
    }

    public function verify($request, $response, $args)
    {
        $body = $request->getParsedBody();
        $ret = parent::getApiLogin($body['user_email']);
        
        if (!$ret['erro']) {
            return json_encode(['user' => base64_encode(json_encode($ret))]);
        }
        return json_encode($ret);
    }
}
