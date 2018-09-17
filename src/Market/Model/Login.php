<?php
namespace Market\Model;

use Market\Model\Partner;
use Illuminate\Database\Eloquent\Model;

class Login extends Model
{
    private $http;
    private $token;

    public function __construct()
    {
        $this->token = getenv('ECC_API_TOKEN');
        $this->http = new \GuzzleHttp\Client();
    }

    public function getApiLogin($email)
    {
        $path = 'https://e-com.plus/api/v1/partners.json?email=' . $email;
        $res = $this->http->request('GET', $path, [
            'headers' => ['X-Sg-Auth' => $this->token]
        ]);
        
        if (200 != $res->getStatusCode()) {
            return [
                'error' => $res->getStatusCode()
            ];
        }

        $result = json_decode($res->getBody());
        
        if ($result->result) {
            return $result->result;
        } else {
            return ['erro' => 'user not found'];
        }
    }

    public function setPassword($user, $password)
    {
        
        $partner = Partner::find($user->id);

        if ($partner) {
            $ret = $partner->update([
                'password_hash' => password_hash($password, PASSWORD_DEFAULT)
            ]);
        } else {
            $ret = Partner::create([
                'id' => $user->id,
                'name' => $user->name,
                'password_hash' => password_hash($password, PASSWORD_DEFAULT)
            ]);
        }
        return $ret;
    }
}
