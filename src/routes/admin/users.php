<?php

use Src\Http\Response;
use \Src\Controllers\Admin;

//Rota de listagem de Usuário
$obRouter->get('/admin/user', [
    'middlewares' => [
        'required-admin-login'
    ],
    function ($request) {
        return new Response(200, Admin\User::getUsers($request));
    }
]);

//Rota de cadastro de um novo Usúario
$obRouter->get('/admin/user/new', [
    'middlewares' => [
        'required-admin-login'
    ],
    function ($request) {
        return new Response(200, Admin\User::getNewUser($request));
    }
]);

//Rota de edição de Usuários
$obRouter->get('/admin/user/{id}/edit', [
    'middlewares' => [
        'required-admin-login'
    ],
    function ($request, $id) {
        return new Response(200, Admin\User::getEditUser($request, $id));
    }
]);

//Rota de cadastro de um novo Usuário (Post)
$obRouter->post('/admin/user/new', [
    'middlewares' => [
        'required-admin-login'
    ],
    function ($request) {
        return new Response(200, Admin\User::setNewUser($request));
    }
]);

//Rota de edição de Usuário (post)
$obRouter->post('/admin/user/{id}/edit', [
    'middlewares' => [
        'required-admin-login'
    ],
    function ($request, $id) {
        return new Response(200, Admin\User::setEditUser($request, $id));
    }
]);

//Rota de exclusão de Usuário
$obRouter->get('/admin/user/{id}/delete', [
    'middlewares' => [
        'required-admin-login'
    ],
    function ($request, $id) {
        return new Response(200, Admin\User::getDeleteUser($request, $id));
    }
]);

//Rota de exclusão de Usuário (post)
$obRouter->post('/admin/user/{id}/delete', [
    'middlewares' => [
        'required-admin-login'
    ],
    function ($request, $id) {
        return new Response(200, Admin\User::setDeleteUser($request, $id));
    }
]);