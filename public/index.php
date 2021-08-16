<?php

require_once __DIR__.'/../src/includes/app.php';

use Src\Http\Router;

//Inicia o Router
$obRouter = new Router(URL);

//Inclui as rotas de páginas
include __DIR__ . '/../src/routes/pages.php';

//Inclui as rotas do Painel
include __DIR__ . '/../src/routes/admin.php';

//Inclui as rotas da API
include __DIR__ . '/../src/routes/api.php';

//Imprime o Response da rota
$obRouter->run()->sendResponse();
