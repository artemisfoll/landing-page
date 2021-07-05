<?php

require_once __DIR__. '/../../vendor/autoload.php';

use Src\Utils\View;
use WilliamCosta\DotEnv\Environment;
use WilliamCosta\DatabaseManager\Database;

//Carrega variaveis de ambiente
Environment::load(__DIR__.'/../');

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
