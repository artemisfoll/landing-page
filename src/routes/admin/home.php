<?php

use Src\Controllers\Admin;
use Src\Http\Response;

//Rota do Admin
$obRouter->get('/admin', [
    'middlewares' => [
        'required-admin-login'
    ],
    function ($request) {
        return new Response(200, Admin\Home::getHome($request));
    }
]);