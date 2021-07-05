<?php


namespace Src\Http\Middleware;


use Closure;
use Src\Http\Request;
use Src\Http\Response;
use Src\Session\Admin\Login as SessionadminLogin;

class RequireAdminLogin
{
    /**
         * Método responsavel por executar o middleware
         * @param Request $request
         * @param Closure $next
         * @return Response
         */
        public function handle(Request $request, Closure $next): Response
        {
            //Verifica se o usuario esta logado
            if (!SessionadminLogin::isLogged()){
                $request->getRouter()->redirect('/admin/login');
            }
            //Continua a execução
            return $next($request);
        }

}