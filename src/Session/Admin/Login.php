<?php


namespace Src\Session\Admin;


use Src\Models\Entity\User;

class Login
{

    /**
     * Método responsavel por iniciar a sessão
     */
    private static function init()
    {
        //Verifica se a sessão não esta ativa
        if (session_status() != PHP_SESSION_ACTIVE) {
            session_start();
        }
    }

    /**
     * Método responsável por criar o login do usuário
     * @param User $obUser
     * @return bool
     */
    public static function login(User $obUser): bool
    {
        //Inicia a sessão
        self::init();

        //Define a sessão do usuario
        $_SESSION['admin']['usuario'] = [
            'id'    => $obUser->id,
            'nome'  => $obUser->nome,
            'email' => $obUser->email
        ];

        //Sucesso
        return true;
    }

    /**
     * Método responsavel por verificar se o usuario está logado
     */
    public static function isLogged()
    {
        //Inicia a sessão
        self::init();

        //Retorna a verificação
        return isset($_SESSION['admin']['usuario']['id']);
    }

    /**
     * Método responsável por executar o logout do usuario
     * @return bool
     */
    public static function logout(): bool
    {
        //Inicia a sessão
        self::init();

        //Desloga o usuario
        unset($_SESSION['admin']['usuario']);

        //sucesso
        return true;
    }
}