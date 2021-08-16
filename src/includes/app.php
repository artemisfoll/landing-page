<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use Src\Http\Middleware\Api;
use Src\Http\Middleware\Maintenance;
use Src\Http\Middleware\Queue;
use Src\Http\Middleware\RequireAdminLogin;
use Src\Http\Middleware\RequireAdminLogout;
use Src\Utils\View;
use WilliamCosta\DotEnv\Environment;
use WilliamCosta\DatabaseManager\Database;


//Carrega variaveis de ambiente
Environment::load(__DIR__ . '/../');

//Define as configurações de banco de dados
Database::config(
    getenv('DB_HOST'),
    getenv('DB_NAME'),
    getenv('DB_USER'),
    getenv('DB_PASS'),
    getenv('DB_PORT')
);

//Define a constante de URL do projeto
define('URL', getenv('URL'));

//Define o valor padrão das variaveis
View::init([
    'URL' => URL
]);

//Define o mapeamento de middlewares
Queue::setMap([
    'maintenance'           => Maintenance::class,
    'required-admin-logout' => RequireAdminLogout::class,
    'required-admin-login'  => RequireAdminLogin::class,
    'api'                   => Api::class
]);

//Define o mapeamento de middlewares Padrões (todas as rotas)
Queue::setDefault([
    'maintenance'
]);
