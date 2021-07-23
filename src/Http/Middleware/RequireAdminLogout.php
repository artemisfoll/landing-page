<?php


namespace Src\Http\Middleware;


use Closure;
use Src\Http\Request;
use Src\Http\Response;
use Src\Session\Admin\Login as SessionAdminLogin;

class RequireAdminLogout
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
            if (SessionAdminLogin::isLogged()){
                $request->getRouter()->redirect('/admin');
            }
            //Continua a execução
            return $next($request);
        }

}