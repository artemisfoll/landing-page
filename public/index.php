<?php

require_once __DIR__.'/../vendor/autoload.php';


use Src\Http\Router;
use Src\Utils\View;

define('URL', 'http://localhost');

//Define o valor padrão das variaveis
View::init([
    'URL' => URL
]);

//Inicia o Router
$obRouter = new Router(URL);

//Inclui as rotas de páginas
include __DIR__.'/../src/routes/pages.php';

//Imprime o Response da rota
$obRouter->run()->sendResponse();
