<?php

use Src\Controllers\Api\Api;
use Src\Http\Response;

//Rota raiz da API
$obRouter->get('/api/v1', [
    'middlewares' => [
        'api'
    ],
    function ($request) {
        return new Response(200, Api::getDetails($request), 'application/json');
    }
]);