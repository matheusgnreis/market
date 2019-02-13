<?php

$app->get(
    '/session/sso_login',
    function ($request, $response, $args) {
        $sso = new Market\Services\EcomSSO('EUsJDhFXwZ242mszKJDCkB3nbv7p69NT');
        print_r($sso->handle_response());
    }
);
