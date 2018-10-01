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
        $requestBody = $request->getParsedBody();
        $user_api = parent::getApiLogin($requestBody['u']);

        if ($user_api) {
            $u = Partner::find($user_api[0]->id);
            $u = (object)$u->makeVisible(['password_hash'])->toArray();

            if (password_verify($requestBody['p'], $u->password_hash)) {
                if ($this->sessao) {
                    if (!isset($_SESSION)) {
                        session_start();
                    }

                    foreach ($u as $key => $valor) {
                        $_SESSION[$key] = $valor;
                    }
                    $_SESSION['login'] = true;
                    $_SESSION['email'] = $requestBody['u'];
                }
            }
        }
        return $response->withJson(['login' => true]);
    }

    public function password($request, $response, $args)
    {
        $body = $request->getParsedBody();

        $user = json_decode(base64_decode($body['u']));

        return $response->withJson(parent::setPassword($user[0], $body['p']));
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

    public static function logout()
    {
        if (isset($_SESSION)) {
            session_destroy();
        }
        return true;
    }

    public static function hasLogin()
    {
        if (!isset($_SESSION)) {
            session_start();
        }

        if (isset($_SESSION['login']) && $_SESSION['login'] == true) {
            return true;
        }
        return false;
    }

    public static function session()
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        return $_SESSION;
    }
}
