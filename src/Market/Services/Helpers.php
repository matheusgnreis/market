<?php
namespace Market\Services;

class Helpers
{
    public static function arrayToJson($request, $response, $args)
    {
        $body = $request->getParsedBody();
        $plans = [];
        if(!empty($body["plan_name"][0])){
            for ($i=0; $i < count($body["plan_name"]); $i++) {
                $plans[] = [
                    "id" => $i,
                    "name" => $body["plan_name"][$i],
                    "currency" => $body["plan_value"][$i],
                    "value" => $body["plan_desc"][$i],
                    "description" => $body["plan_recorrencia"][$i],
                    "checked" => 'checked',
                ];
            }
    
            return (string)json_encode($plans);
        }
        return false;

    }

    public function validScope($request, $response, $args){
        return (string)json_encode($request->getParsedBody());
    }

    public function randomSlug($lenght = 5, $upCase = false, $numb = true, $simb = false)
    {
        $lmin = 'abcdefghijklmnopqrstuvwxyz';
        $lmai = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $num = '1234567890';
        $simb = '!@#$%*-';
        $retorno = '';
        $caracteres = '';
        $caracteres .= $lmin;
        if ($upCase) {
            $caracteres .= $lmai;
        }
        if ($numb) {
            $caracteres .= $num;
        }
        if ($simb) {
            $caracteres .= $simb;
        }
        $len = strlen($caracteres);
        for ($n = 1; $n <= $lenght; $n++) {
            $rand = mt_rand(1, $len);
            $retorno .= $caracteres[$rand-1];
        }
        return $retorno;
    }
}
