<?php

use \Src\Http\Response;
use \Src\Controllers\Pages;

$obRouter = '';

//Rota da Home
$obRouter->get('/', [
    function () {
        return new Response(200, Pages\Home::getHome());
    }
]);

//Rota Sobre
$obRouter->get('/sobre', [
    function () {
        return new Response(200, Pages\Sobre::getSobre());
    }
]);

//Rota Depoimentos
$obRouter->get('/depoimentos', [
    function ($request) {
        return new Response(200, Pages\Depoimentos::getDepoimentos($request));
    }
]);

//Rota Depoimentos (Inserir)
$obRouter->post('/depoimentos', [
    function ($request) {
        return new Response(200, Pages\Depoimentos::insertTestimony($request));
    }
]);

//Rota QrCode
$obRouter->get('/qrcode', [
    function ($request) {
        return new Response(200, Pages\Qrcode::getQrCode($request));
    }
]);

//Rota QrCode
$obRouter->post('/qrcode', [
    function ($request) {
        return new Response(200, Pages\Qrcode::getQrCode($request));
    }
]);

