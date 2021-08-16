<?php

use Src\Controllers\Api\Testimony;
use Src\Http\Response;

//Rota de listagem de depoimentos
$obRouter->get('/api/v1/testimonies', [
    'middlewares' => [
        'api'
    ],
    function ($request) {
        return new Response(200, Testimony::getTestimonies($request), 'application/json');
    }
]);

//Rota de consulta individual de depoimentos
$obRouter->get('/api/v1/testimonies/{id}', [
    'middlewares' => [
        'api'
    ],
    function ($request, $id) {
        return new Response(200, Testimony::getTestimony($request, $id), 'application/json');
    }
]);