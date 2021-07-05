<?php


namespace Src\Http\Middleware;


use Closure;
use Src\Http\Request;
use Src\Http\Response;

class Queue
{
    /**
     * Mapeamento de middlewares
     * @var array
     */
    private static $map = [];

    /**
     * Mapeamento de middlewares que serão carregados em todas as rotas
     * @var array
     */
    private static $default = [];

    /**
     * Fila de middlewares a serem executados
     * @var array
     */
    private $middlewares = [];

    /**
     * Função de execução do controlador
     * @var Closure
     */
    private $controller;

    /**
     * Argumentos da função do controlador
     * @var array
     */
    private $controllerArgs = [];

    /**
     * Método responsavel por construir a classe de fila de middlewares
     * @param array $middlewares
     * @param Closure $controller
     * @param array $controllerArgs
     */
    public function __construct(array $middlewares, Closure $controller, array $controllerArgs)
    {
        $this->middlewares    = array_merge(self::$default, $middlewares);
        $this->controller     = $controller;
        $this->controllerArgs = $controllerArgs;
    }

    /**
     * Método responsavel por definir o mapeamento de middlewares
     * @param array $map
     */
    public static function setMap(array $map)
    {
        self::$map = $map;
    }

    /**
     * Método responsavel por definir o mapeamento de middlewares
     * @param array $default
     */
    public static function setDefault(array $default)
    {
        self::$default = $default;
    }

    /**
     * Método responsável por executar o próximo nível da fila de middlewares
     * @param Request $request
     * @param Response
     */
    public function next(Request $request)
    {
       //Verifica se a fila está vazia
        if (empty($this->middlewares)) return call_user_func_array($this->controller, $this->controllerArgs);

        //Middleware
        $middleware = array_shift($this->middlewares);

        //Verifica o mapeamento
        if (!isset(self::$map[$middleware]))
        {
            throw new \Exception("Problemas ao processar o middleware da requesição", 500);
        }

        //Next
        $queue = $this;
        $next = function ($request) use ($queue){
            return $queue->next($request);
        };

        //Executa o Middleware
        return (new self::$map[$middleware])->handle($request, $next);
    }
}