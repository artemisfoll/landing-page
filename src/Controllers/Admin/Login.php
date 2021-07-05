<?php


namespace Src\Controllers\Admin;


use Src\Http\Request;
use Src\Models\Entity\User;
use Src\Utils\View;
use Src\Session\Admin\Login as SessionAdminLogin;

class Login extends Page
{

    /**
     * Método responsável por retornar a renderização da página de login
     * @param Request $request
     * @param string $errorMessage
     * @return string
     */
    public static function getLogin(Request $request, string $errorMessage = null): string
    {
        //Status
        $status = !is_null($errorMessage) ? View::render('admin/login/status', [
            'mensagem' => $errorMessage
        ]): '';

        //Conteúdo da página de login
        $content = View::render('admin/login', [
            'status' => $status
        ]);
        //Retorna a página completa
        return parent::getPage('Login', $content);
    }

    /**
     * Método responsável por definir o login do usuário
     * @param Request $request
     * 
     */
    public static function setlogin(Request $request)
    {
        //Post Vars
        $postVars = $request->getPostVars();
        $email = $postVars['email'] ?? '';
        $senha = $postVars['senha'] ?? '';

        //busca o usuario pelo emai
        $obUser = User::getUserByEmail($email);

        if (!$obUser instanceof User){
            return self::getLogin($request, 'E-mail inválido');
        }

        //Verifica a senha do usuario
        if (!password_verify($senha, $obUser->senha)){
            return self::getLogin($request, 'Senha inválida');
        }

        //Cria a Sessão de login
        SessionAdminLogin::login($obUser);

        //Redireciona o usuario para a home do admin
        $request->getRouter()->redirect('/admin');
    }

    /**
     * Método responsavel por deslogar o usuario
     * @param Request $request
     */
    public static function setLogout(Request $request)
    {
        //Destroi a Sessão de login
        SessionAdminLogin::logout();

        //Redireciona o usuario para o login do admin
        $request->getRouter()->redirect('/admin/login');
    }
}