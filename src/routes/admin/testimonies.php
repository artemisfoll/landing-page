<?php

use Src\Http\Response;
use \Src\Controllers\Admin;

//Rota de listagem de Depoimentos
$obRouter->get('/admin/testimonies', [
    'middlewares' => [
        'required-admin-login'
    ],
    function ($request) {
        return new Response(200, Admin\Testimony::getTestimonies($request));
    }
]);