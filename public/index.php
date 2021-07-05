<?php

require_once __DIR__.'/../src/includes/app.php';

use Src\Http\Router;

//Inicia o Router
$obRouter = new Router(URL);

//Inclui as rotas de páginas
include __DIR__ . '/../src/routes/pages.php';

//Imprime o Response da rota
$obRouter->run()->sendResponse();
