<?php


namespace Src\Http\Middleware;


use Closure;
use Src\Http\Request;
use Src\Http\Response;

class Maintenance
{
    /**
     * Método responsavel por executar o middleware
     * @param Request $request
     * @param Closure $next
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        //Verifica o estado de manutenção da página
        if(getenv('MAINTENANCE') === 'true'){
            throw new \Exception("Página em manutenção.", 200);
        }

        //Executa o próximo nível de middleware
        return $next($request);
    }
}