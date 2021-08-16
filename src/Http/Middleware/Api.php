<?php

namespace Src\Http\Middleware;

use Closure;
use Src\Http\Request;
use Src\Http\Response;

class Api
{
    /**
     * Método responsavel por executar o middleware
     * @param Request $request
     * @param Closure $next
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        //Altera o content type para Json
        $request->getRouter()->setContentType('application/json');

        //Executa o próximo nível de middleware
        return $next($request);
    }
}