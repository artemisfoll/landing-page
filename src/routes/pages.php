<?php

use \Src\Http\Response;
use \Src\Controllers\Pages;

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



////Rota Dinamica
//$obRouter->get('/pagina/{idPagina}/{acao}', [
//    function($idPagina, $acao){
//        return new Response(200, 'Página '.$idPagina.' - '. $acao);
//    }
//]);