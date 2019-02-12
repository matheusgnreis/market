<?php
/**
 * retorna adictionario
 */
$app->get(
    '/dictionary/{lang}',
    function ($request, $response, $args) {
        return $response->withJson(\Market\Services\Dictionary::getDictionary($args['lang']));
    }
);
